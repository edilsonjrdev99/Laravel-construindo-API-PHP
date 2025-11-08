<?php

namespace App\Services\File\User;

use App\Models\User;
use App\Traits\UploadFileTrait;
use Illuminate\Http\UploadedFile;

class FileUserService {
    use UploadFileTrait;

    public function uploadUserImage(UploadedFile $file, int $id): ?string
    {
        $user = User::find($id);

        if (!$user) return null;

        $uploadPath = $this->uploadImage($file, 'user-images');

        $user->avatar = $uploadPath;

        $user->save();

        return $uploadPath;
    }
}