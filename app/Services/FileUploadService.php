<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file to the specified folder with optional WebP conversion.
     *
     * @param \Illuminate\Http\UploadedFile $file The uploaded file.
     * @param string $folder The folder where the file will be stored.
     * @param string $prefix The prefix to be added to the filename (optional).
     * @param bool $convertToWebP Whether to convert the image to WebP format (default is true).
     * @return string The filename of the uploaded or converted file.
     */
    public static function upload(UploadedFile $file, string $folder, string $prefix = '', bool $convertToWebP = true): string
    {
        // Generate a unique filename with the provided prefix
        $filename = uniqid($prefix) . '.' . $file->getClientOriginalExtension();

        // Check if conversion to WebP is enabled and the file extension is supported
        if (in_array(Str::lower($file->getClientOriginalExtension()), ['jpeg', 'jpg', 'png', 'JPEG', 'JPG', 'PNG'])) {
            if ($convertToWebP) {
                $webpFilename = uniqid($prefix) . '.webp';
                self::convertToWebP($file->getRealPath(), $folder, $webpFilename);
                $filename = $webpFilename;
            } else {
                $filename = uniqid($prefix) . '.' . Str::lower($file->getClientOriginalExtension());
                self::uploadDirectly($file->getRealPath(), $folder, $filename);
                $filename = $filename;
            }
        } else abort('400', 'Not Supported Image of ' .  $file->getClientOriginalName());

        return $folder . '/' . $filename;
    }
    /**
     * Multi-upload files to the specified folder with optional WebP conversion.
     *
     * @param array $filesArray An array of arrays of UploadedFile instances.
     *                         Example: [['file1' => $file1], ['file2' => $file2]]
     * @param string $folder The folder where the files will be stored.
     * @param bool $convertToWebP Whether to convert the images to WebP format (default is true).
     * @return array An array of arrays containing the filenames of the uploaded or converted files.
     */
    public static function multiUpload(array $filesArray, string $folder, bool $convertToWebP = true): array
    {
        $uploadedFilesArray = [];

        foreach ($filesArray as $fileKey => $file) {
            if ($file) {
                // Use the existing upload function for each file
                $uploadedFilename = self::upload($file, $folder, $fileKey, $convertToWebP);

                $uploadedFilesArray[$fileKey] = $uploadedFilename;
            }
        }

        return $uploadedFilesArray;
    }
    /**
     * Convert an image to WebP format and save it in the specified folder.
     *
     * @param string $imagePath The path of the source image.
     * @param string $folder The folder where the WebP image will be stored.
     * @param string $webpFilename The filename for the WebP image.
     */
    private static function convertToWebP(string $imagePath, string $folder, string $webpFilename): void
    {
        // Check if the folder exists, if not, create it
        $folderPath = storage_path("app/public/{$folder}");
        self::createFolderIfNotExist($folderPath);

        // Create an image resource from the source image
        $image = imagecreatefromstring(file_get_contents($imagePath));

        if ($image !== false) {
            // Check if the image is paletted and needs conversion
            if (imageistruecolor($image) === false) {
                // Convert paletted image to true color (RGB)
                $trueColorImage = imagecreatetruecolor(imagesx($image), imagesy($image));
                imagecopy($trueColorImage, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                imagedestroy($image);
                $image = $trueColorImage;
            }

            // Generate the path for the WebP image
            $webpPath = $folderPath . '/' . $webpFilename;

            // Convert and save the image as WebP
            if (imagewebp($image, $webpPath)) {
                // Destroy the image resource
                imagedestroy($image);
            } else {
                abort(500, 'WebP Conversion Failed');
            }
        }
    }
    private static function uploadDirectly(string $imagePath, string $folder, string $filename): void
    {
        // Check if the folder exists, if not, create it
        $folderPath = storage_path("app/public/{$folder}");
        self::createFolderIfNotExist($folderPath);

        // Generate the path for the uploaded image
        $uploadedImagePath = $folderPath . '/' . $filename;

        // Move the image to the destination folder
        if (rename($imagePath, $uploadedImagePath)) {
            // Image moved successfully, you can perform additional actions if needed
        } else {
            abort(500, 'Failed to upload image');
        }
    }


    /**
     * Create a folder if it does not exist.
     *
     * @param string $folder The folder path.
     */
    private static function createFolderIfNotExist($folder)
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true); // Recursive directory creation with full permissions (you may adjust permissions based on your requirements)
        }
    }

    public static function webLoad($path, $ignorePublicPath = false)
    {
        if(!$ignorePublicPath) $path = storage_path() . "/app/public/" . $path;
        if(!file_exists($path)) abort(404);
        return response()->file($path);
    }
}
