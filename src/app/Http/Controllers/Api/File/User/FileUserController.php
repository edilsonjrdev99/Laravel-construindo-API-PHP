<?php

namespace App\Http\Controllers\Api\File\User;

use App\Http\Controllers\Controller;
use App\Services\File\User\FileUserService;
use Illuminate\Http\Request;

class FileUserController extends Controller
{
    public function __construct(private FileUserService $fileUserService) {}

    public function saveUserImage(Request $request, int $id)
    {
        $saveImage = $this->fileUserService->uploadUserImage($request->file('file'), $id);

        if (!$saveImage) 
            return response()->json(['message' => 'Falha ao tentar fazer o upload'], 400);

        return response()->json(['message' => 'Upload da imagem do usuário realizado com sucesso.'], 200);
    }
}
