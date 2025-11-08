<?php

namespace App\Http\Requests\File\User;

use Illuminate\Foundation\Http\FormRequest;

class saveUserImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'image',
                'mimes:jpeg,npg,jpg',
                'max:2048'
            ],
        ];
    }

    public function messages()
    {
        return [
            'cover.required' => 'A imagem é obrigatória.',
            'cover.image' => 'O arquivo deve ser uma imagem válida.',
            'cover.mimes' => 'A imagem deve estar no formato PNG ou JPG.',
            'cover.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }
}
