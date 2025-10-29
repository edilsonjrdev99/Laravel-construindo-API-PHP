<?php

namespace App\HTTP\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Services\AuthService;

class LoginUserController {
    public function __construct(private AuthService $authService) {}

    /**
     * Responsável por validar a request e fazer login
     * @param $request payload da request
     */
    public function login(LoginUserRequest $request)
    {
        return $this->authService->login($request->validated());
    }
}