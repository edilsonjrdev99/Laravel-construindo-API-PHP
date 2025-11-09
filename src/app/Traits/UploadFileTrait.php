<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait {
    /**
     * Responsável por salvar a imagem no disco
     * @var UploadedFile $file arquivo
     * @var string $path path onde o arquivo será salvo
     * @return string url do path da imagem
     */
    public function uploadImage(UploadedFile $file, string $path = 'uploads'): string
    {
        $pathExist = $this->pathExist($path);

        if ($pathExist) $this->removeImage($path);

        $fileName = Str::uuid() . '.' . $file->getClientOriginalName();

        $filePath = $file->storeAs($path, $fileName, 'public');

        return "storage/$filePath";
    }

    /**
     * Responsável por verificar se existe um diretório
     * @var string $path caminho do arquivo
     * @return bool
     */
    private function pathExist(string $path): bool
    {
        return count(Storage::disk('public')->files($path));
    }

    /**
     * Responsável por remover as imagens de um diretório
     * @var string $path caminho dos arquivos
     * @return void
     */
    public function removeImage(string $path): void
    {
        if (!$this->pathExist($path)) return;

        $image = Storage::disk('public');

        $files = $image->files($path);

        if (!empty($files))
            $image->delete($files);
    }
} 