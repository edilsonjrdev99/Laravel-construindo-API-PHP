<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\AuthService;

class LogoutUserController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Responsável por fazer o logout
     */
    public function logout()
    {
        return $this->authService->logout();
    }
}