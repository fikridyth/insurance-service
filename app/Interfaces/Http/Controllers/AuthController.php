<?php

namespace App\Interfaces\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Auth\UseCases\LoginUseCase;
use App\Application\Auth\UseCases\LogoutUseCase;
use App\Shared\Responses\Response;

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
    
            return response()->json(
                Response::successRecord(
                    "Login success",
                    $result
                ),
                200
            );
    
        } catch (\Exception $e) {
    
            return response()->json(
                Response::error(
                    $e->getMessage(),
                    400
                ),
                400
            );
    
        }
    }

    public function logout(Request $request)
    {
        return response()->json(
            $this->logout->execute($request->user()->id)
        );
    }
}