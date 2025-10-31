<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthService {
    /**
     * Responsável por fazer login e setar um cookie
     * @param $credentials credenciais
     */
    public function login(array $credentials)
    {
        $token = Auth::guard('api')->attempt($credentials);

        if (!$token)
            return response()->json(['message' => 'Credenciais inválidas.'], 401);

        $cookie = $this->createTokenCookie($token);

        return response()->json(['message' => 'Login realizado com sucesso.'])->cookie($cookie);
    }

    /**
     * Responsável por fazer logout e remover o cookie
     */
    public function logout()
    {
        Auth::guard('api')->logout(); // Invalida o token JWT no backend

        $cookie = $this->removeTokenCookie();

        return response()->json(['message' => 'Logout realizado com sucesso.'])->cookie($cookie);
    }

    /**
     * Retorna os dados do usuário autenticado
     */
    public function me()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return response()->json(['user' => $user]);
    }

    /**
     * Altera a senha do usuário autenticado
     * @param array $data contém current_password, new_password e new_password_confirmation
     */
    public function changePassword(array $data)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Verifica se a senha atual está correta
        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'A senha atual está incorreta.'], 400);
        }

        // Atualiza a senha
        $user->password = Hash::make($data['new_password']);
        $user->save();

        return response()->json(['message' => 'Senha alterada com sucesso.']);
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

    /**
     * Responsável por remover o cookie de autenticação
     */
    private function removeTokenCookie()
    {
        return Cookie::make(
            'token',
            '',
            -1, // expira imediatamente
            null,
            null,
            true, // secure (HTTPS)
            true, // httpOnly
            false,
            'Strict'
        );
    }
}