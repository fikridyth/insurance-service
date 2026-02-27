<?php

namespace App\Interfaces\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Auth\UseCases\LoginUseCase;
use App\Application\Auth\UseCases\LogoutUseCase;

class AuthController
{
    public function __construct(
        private LoginUseCase $login,
        private LogoutUseCase $logout
    ) {}

    public function login(Request $request)
    {
        try {
            $result = $this->login->execute(
                $request->email,
                $request->password
            );
    
            return response()->json([
                "success" => true,
                "data" => $result
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 400);
    
        }
    }

    public function logout(Request $request)
    {
        return response()->json(
            $this->logout->execute($request->user()->id)
        );
    }
}