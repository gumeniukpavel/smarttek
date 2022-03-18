<?php

namespace App\Modules;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileModule
{
    public static function saveFile(UploadedFile $file)
    {
        $currentDirectory = getcwd();
        $uploadDirectory = "/data/";

        $fileExtensionsAllowed = ['csv'];

        $fileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();

        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

        if (!in_array($fileExtension, $fileExtensionsAllowed)) {
            throw new \Exception("This file extension is not allowed. Please upload a CSV file");
        }

        $didUpload = move_uploaded_file($file->getPathname(), $uploadPath);
        if ($didUpload) {
            return basename($fileName);
        }
    }
}