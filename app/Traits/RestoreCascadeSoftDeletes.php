<?php

namespace App\Traits;

trait RestoreCascadeSoftDeletes
{

    public function restoreWithCascading($id)
    {

        $record = parent::withTrashed()->find($id);
        // Restore the current model
        $record->restore();
        foreach ($this->cascadeDeletes as $key => $relation) {
            $record->{$relation}()->withTrashed()->each(function ($relatedModel) {
                $relatedModel->restore();
            });
        }
    }
}
