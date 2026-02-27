<?php

namespace App\Application\Auth\UseCases;

use App\Domain\User\Repositories\UserRepositoryInterface;
use Exception;

class LoginUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(string $email, string $password): array
    {
        $user = $this->repo->findByEmail($email);

        if (!$user)
            throw new Exception("User not found");

        if (!$this->repo->verifyPassword($user, $password))
            throw new Exception("Invalid password");

        $this->repo->deleteTokens($user);

        $token = $this->repo->createToken($user);

        return [
            "token"=>$token,
            "token_type"=>"Bearer",
            "name"=>$user->name,
            "email"=>$user->email,
            "role"=>$user->role
        ];
    }
}