<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Services\UserService;

class UserController extends Controller
{
    // Instância do service de usuário
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Responsável por retornar todos os usuários.
     */
    public function index()
    {
        return response()->json($this->userService->getAllUsers());
    }

    /**
     * Responsável por criar um novo usuário.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        if (!$user) return response()->json(['message' => 'Cpf deve conter 11 dígitos numéricos, CNPJ deve conter 14 dígitos numéricos.']);

        return response()->noContent(201);
    }

    /**
     * Responsável por retornar um usuário.
     */
    public function show(int $id)
    {
        $user = $this->userService->getUserById($id);

        if(!$user)
            return response()->json(['message' => 'usuário não encontrado.'], 404);

        return response()->json($user);
    }

    /**
     * Responsável por atualizar um usuário.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = $this->userService->updateUser($id, $request->validated());

        if (!$user)
            return response()->json(['message' => 'Usuário não encontrado.'], 404);

        return response()->json($user);
    }

    /**
     * Responsável por excluir um usuário.
     */
    public function destroy(string $id)
    {
        $user = $this->userService->deleteUserById($id);

        if (!$user)
            return response()->json(['message' => 'Usuário não encontrado']);

        return response()->json(['message' => 'Usuário excluído com sucesso.']);
    }
}
