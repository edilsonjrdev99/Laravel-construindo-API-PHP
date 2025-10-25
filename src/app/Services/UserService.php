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
     */
    public function getUserById(int $id): ?User 
    {
        return User::find($id);
    }

    /**
     * Responsável por criar um usuário.
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Responsável por atualizar um usuário.
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
     */
    public function deleteUserById(int $id): bool
    {
        $user = $this->getUserById($id);

        if (!$user)
            return false;

        return $user->delete();
    }
}