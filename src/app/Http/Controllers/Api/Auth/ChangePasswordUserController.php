<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordUserRequest;
use App\Services\AuthService;

class ChangePasswordUserController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Altera a senha do usuário autenticado
     */
    public function changePassword(ChangePasswordUserRequest $request)
    {
        return $this->authService->changePassword($request->validated());
    }
}
