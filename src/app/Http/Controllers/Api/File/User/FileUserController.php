<?php

namespace App\Http\Controllers\Api\File\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\User\saveUserImageRequest;
use App\Services\File\User\FileUserService;

class FileUserController extends Controller
{
    public function __construct(private FileUserService $fileUserService) {}

    public function saveUserImage(saveUserImageRequest $request, int $id)
    {
        $saveImage = $this->fileUserService->uploadUserImage($request->file('file'), $id);

        if (!$saveImage) 
            return response()->json(['message' => 'Falha ao tentar fazer o upload'], 400);

        return response()->json(['message' => 'Upload da imagem do usuário realizado com sucesso.'], 200);
    }
}
