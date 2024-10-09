<?php
// SetCreatedAtToNull.php

namespace App\Traits;

use App\Enums\UpdateTypeEnum;
use App\Services\CreateWithTranslationService;
use App\Services\FileUploadService;
use App\Services\SwapperService;
use App\Services\UpdaterService;
use Illuminate\Http\Request;

trait RepositoryControllerTrait
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $records = $this->configuration['mainModel']::withTrashed()->with($this->configuration['withForIndex'])->paginate($request->limit ?? 8);
        $associate = $this->configuration['associateForIndex'];
        $routes = $this->routes;
        return view($this->configuration['parentView'] . 'index', compact('records', 'routes', 'associate'));
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $record = $this->configuration['mainModel']::with([
            $this->configuration['imagesRelation'] => fn ($q) => $q->withTrashed(),
            'translations'
        ])->findOrFail($id);
        $associate = $this->configuration['associateForEdit'];
        $routes = $this->routes;
        return view($this->configuration['parentView'] . 'edit', compact('routes', 'record', 'associate'));
    }
    /**
     * Update the specified resource in storage.
     * @param $request
     * @param int $id
     * @return Response
     */
    public function updateResource($request, $id)
    {

        // Create an instance of the UpdaterService
        $updaterService = new UpdaterService();
        // Set values using setter methods
        $updaterService
            ->setMainModel(new $this->configuration['mainModel'])
            ->setTranslationModel($this->configuration['translationModel'])
            ->setTranslationForeignKeyToMainModel($this->configuration['foreignKey'])
            ->setLanguage($request->language ?? null)
            ->setUpdateRequest($request)
            ->setUpdateType($request->submit_method ?? UpdateTypeEnum::SINGLE())
            ->setMainModelId($id)
            ->smartUpdate();

        return redirectBackWithHash(isset($request->language) ? 'tabs-language-' . $request->language : '')->with('Success', 'تم تعديل السجل بنجاح');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $associate = $this->configuration['associateForCreate'];
        $routes = $this->routes;
        return view($this->configuration['parentView'] . 'create', compact('routes', 'associate'));
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->configuration['mainModel']::findOrFail($id)->delete();
        return redirect()->route($this->configuration['parentRoute'] . 'index')->with('Success', 'تم حذف العنصر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function restore($id)
    {
        $this->configuration['mainModel']::onlyTrashed()->findOrFail($id)->restoreWithCascading($id);
        return redirect()->route($this->configuration['parentRoute'] . 'index')->with('Success', 'تم استعادة العنصر بنجاح');
    }


    /**
     * Swap the order of images based on the specified direction.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageSwap(request $request)
    {
        $swapper = new SwapperService($this->configuration['imageModel'], 'order', $this->configuration['foreignKey']);
        $success = ($request->direction == "up") ?  $swapper->moveUp($request->route('id')) : $swapper->moveDown($request->route('id'));

        if ($success)
            return redirectBackWithHash('tabs-image-data')->with('Success', 'تم تغيير الترتيب بنجاح');
        return redirectBackWithHash('tabs-image-data')->withErrors('لا يمكن تغيير الترتيب الحالي لهذه الصورة');
    }

    /**
     * Delete or restore a image based on its current state.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageDeleteRestore(request $request)
    {
        $image = $this->configuration['imageModel']::withTrashed()->findOrFail($request->route('id'));
        if ($image->deleted_at) {
            $image->restore();
            return redirectBackWithHash('tabs-image-data')->with('Success', 'تم استرجاع الصورة بنجاح');
        };
        $image->delete();
        return redirectBackWithHash('tabs-image-data')->with('Success', 'تم حذف الصورة بنجاح');
    }


    /**
     * Create & Upload Image
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageCreateResource($request)
    {
        $filenames  = FileUploadService::multiUpload($request->images, 'images'); // Adjust the storage path
        $latestOrder = $this->configuration['imageModel']::where($this->configuration['foreignKey'], $request->route('id'))->orderBy('order', 'desc')->first()->order ?? 0;
        $insertable = [];
        collect($filenames)->each(function ($filename) use ($request, &$latestOrder, &$insertable) {
            $latestOrder += 1;
            $insertable[] = [
                $this->configuration['foreignKey']      => $request->route('id'),
                'image'                                 => $filename,
                'order'                                 => $latestOrder,
                'created_by'                            => auth()->user()->username,
                'created_at'                            => now(),
            ];
        });

        $this->configuration['imageModel']::insert($insertable);
        return redirectBackWithHash('tabs-image-data')->with('Success', 'تم حفظ الصور بنجاح');
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function storeResource($request)
    {
        // Instantiate the CreateWithTranslationService with your main model
        $createService = new CreateWithTranslationService(new $this->configuration['mainModel']);
        $createService->setMainModelKeys($this->mainModelKeys);
        $createService->setRelationshipsWithKeys($this->relationships);
        $createService->setImageKeys($this->imageKeys);
        $createService->setImageStructure($this->imageStructure);
        // Create the record with translation and images
        $mainRecord = $createService->createWithTranslation($request);

        return redirect()->route($this->configuration['parentRoute'] . 'index')->with('Success', 'تم انشاء العنصر بنجاح');
    }
}