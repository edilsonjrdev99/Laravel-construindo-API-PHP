<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'person_type' => 'required|in:fisica,juridica',
            'name' => 'required_if:person_type,fisica|string|max:50|nullable',
            'surname' => 'required_if:person_type,fisica|string|max:255|nullable',
            'cpf' => 'required_if:person_type,fisica|string|max:11|nullable',
            'corporate_name' => 'required_if:person_type,juridica|string|max:50|nullable',
            'cnpj' => 'required_if:person_type,juridica|string|max:14|nullable',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'person_type.in' => 'O tipo de pessoa deve ser fisica ou juridica.',
            'email.unique' => 'Este email já existe.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Erro de validação.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
