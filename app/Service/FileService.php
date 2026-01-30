<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{

    /**
     * Upload a file to the storage and create a MediaObject
     * 
     */
    public function uploadFile(Request $request, $inputName = 'file', $modelClass, $folderName, $allowedMimeTypes, $id)
    {
        $this->validateFile($request, $inputName, $allowedMimeTypes);

        $file = $request->file($inputName);

        // Check if the folder exists, if not, create it
        $directory =  'uploads/' . $folderName;
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Update the file path to include the type-specific folder
        $filePath = $file->store($directory, 'public');

        // Create MediaObject and assign the correct foreign key
        $file = [
            'file_path' => $filePath,
            'file_type' => $file->getClientMimeType(),
        ];

        $file[$folderName . '_id'] = $id;

        $model = 'App\\Models\\' . $modelClass;
        return $model::create($file);
    }

    /**
     * Delete a file from the storage and the MediaObject
     * 
     */
    public function deleteFile($id, $modelClass)
    {
        $model = 'App\\Models\\' . $modelClass;
        $file = $model::find($id);

        if ($file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        return $model::delete($id);
    }

    /**
     * Validate the file
     * 
     */
    private function validateFile($request, $inputName, $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
    {
        // Validate the file dynamically
        $validate = $request->validate([
            $inputName => ['required', 'mimes:' . implode(',', array_map(fn($type) => explode('/', $type)[1], $allowedMimeTypes))],
        ]);

        if ($validate) {
            $file = $request->file($inputName);
            $mimeType = $file->getClientMimeType();
            if (!in_array($mimeType, $allowedMimeTypes)) {
                $validate = false;
            }
        }

        return $validate;
    }
}
