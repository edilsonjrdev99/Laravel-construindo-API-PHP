<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
            'person_type' => 'sometimes|in:fisica,juridica',
            'name' => 'sometimes|required_if:person_type,fisica|prohibited_if:person_type,juridica|string|max:50|nullable',
            'surname' => 'sometimes|required_if:person_type,fisica|prohibited_if:person_type,juridica|string|max:255|nullable',
            'cpf' => 'sometimes|required_if:person_type,fisica|prohibited_if:person_type,juridica|regex:/^\d+$/|size:11|nullable',
            'corporate_name' => 'sometimes|required_if:person_type,juridica|prohibited_if:person_type,fisica|string|max:50|nullable',
            'cnpj' => 'sometimes|required_if:person_type,juridica|prohibited_if:person_type,fisica|regex:/^\d+$/|size:14|nullable',
            'phone' => 'sometimes|regex:/^\d+$/|size:11',
            'email' => 'sometimes|email|unique:users,email,' . $this->route('id'),
            'password' => 'sometimes|string|min:6|confirmed'
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
            'phone.regex' => 'O telefone deve conter apenas números.',
            'phone.size' => 'O telefone deve ter exatamente 11 dígitos.',
            'cpf.regex' => 'O CPF deve conter apenas números.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.prohibited_if' => 'O CPF não deve ser enviado para pessoa jurídica.',
            'cnpj.regex' => 'O CNPJ deve conter apenas números.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 dígitos.',
            'cnpj.prohibited_if' => 'O CNPJ não deve ser enviado para pessoa física.',
            'name.prohibited_if' => 'O nome não deve ser enviado para pessoa jurídica.',
            'surname.prohibited_if' => 'O sobrenome não deve ser enviado para pessoa jurídica.',
            'corporate_name.prohibited_if' => 'A razão social não deve ser enviada para pessoa física.',
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
