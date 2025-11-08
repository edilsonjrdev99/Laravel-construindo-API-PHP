<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadFileTrait {
    public function uploadImage(UploadedFile $file, string $path = 'uploads'): string
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalName();

        $filePath = $file->storeAs($path, $fileName, 'public');

        return "storage/$filePath";
    }
}