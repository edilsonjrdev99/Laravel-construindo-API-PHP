<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService {
    /**
     * Responsável por buscar todos os usuários.
     */
    public function getAllUsers(): Collection 
    {
        return User::all();
    }

    /**
     * Responsável por buscar um usuário pelo id.
     * @param int $id = id do usuário
     * @return User
     */
    public function getUserById(int $id): ?User 
    {
        return User::find($id);
    }

    /**
     * Responsável por criar um usuário.
     * @param array $data = payload de criação do usuário
     * @return User
     */
    public function createUser(array $data): User|bool
    {
        $document = $data['person_type'] == 'fisica' ? $data['cpf'] : $data['cnpj'];

        $isValidDocument = $this->validateCpfOrCnpj($document);

        if (!$isValidDocument) return false;

        return User::create([
            'name' => $data['name'] ?? null,
            'surname' => $data['surname'] ?? null,
            'person_type' => $data['person_type'],
            'corporate_name' => $data['corporate_name'] ?? null,
            'cpf' => $data['cpf'] ?? null,
            'cnpj' => $data['cnpj'] ?? null,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Responsável por atualizar um usuário.
     * @param int $id = id do usuário
     * @param array $data = payload de atualização do usuário
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->getUserById($id);

        if (!$user)
            return null;

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->save();

        return $user;
    }

    /**
     * Responsável por excluir um usuário.
     * @param int $id = id do usuário
     */
    public function deleteUserById(int $id): bool
    {
        $user = $this->getUserById($id);

        if (!$user)
            return false;

        return $user->delete();
    }

    /**
     * Responsável por validar se o cpf ou cnpj é válido
     * @param string $document = string do cpf ou cnpj
     * @return bool
     */
    private function validateCpfOrCnpj(string $document): bool
    {
        // Remove a máscara .
        $document = preg_replace('/\D/', '', $document);

        $document = trim($document);

        if (!ctype_digit($document))
            return false;

        if(strlen($document) === 11)
            return true;

        if(strlen($document) === 14)
            return true;

        return false;
    }
}