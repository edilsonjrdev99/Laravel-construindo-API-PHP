<?php

namespace App\Services;

use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService {
    /**
     * Responsável por buscar todos os usuários.
     */
    public function getAllUsers(Request $request): LengthAwarePaginator 
    {
        $itemsPerPage = $request->has('itemsPerPage') ? $request->itemsPerPage : 10;

        if($request->has('name'))
            return User::whereName($request->name)->paginate($itemsPerPage);

        if($request->has('corporateName'))
            return User::whereCorporateName($request->corporateName)->paginate($itemsPerPage);

        return User::paginate($itemsPerPage);
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
        $user = User::create([
            'name' => $data['name'] ?? '',
            'surname' => $data['surname'] ?? null,
            'person_type' => $data['person_type'],
            'corporate_name' => $data['corporate_name'] ?? null,
            'cpf' => $data['cpf'] ?? null,
            'cnpj' => $data['cnpj'] ?? null,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $userName = $data['person_type'] == 'fisica' ? $data['name'] : $data['corporate_name'];

        Mail::to($user->email)->send(new UserCreatedMail($userName));

        return $user;
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
}