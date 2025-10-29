<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthService {
    /**
     * Responsável por fazer login e setar um cookie
     * @param $credentials credenciais
     */
    public function login(array $credentials)
    {
        $token = Auth::attempt($credentials);

        if (!$token)
            return response()->json(['message' => 'Credenciais inválidas.']);

        $cookie = $this->createTokenCookie($token);

        return response()->json(['message' => 'Login realizado com sucesso.'])->cookie($cookie);
    }

    /**
     * Responsável por criar um token
     * @param $token token do JWT
     */
    public function createTokenCookie(string $token)
    {
        return Cookie::make(
            'token',
            $token,
            60, // minutos (1h)
            null,
            null,
            true, // secure (HTTPS)
            true, // httpOnly
            false,
            'Strict'
        );
    }
}