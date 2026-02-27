<?php

namespace App\Application\Auth\UseCases;

use App\Domain\User\Repositories\UserRepositoryInterface;

class LogoutUseCase
{
    public function __construct(
        private UserRepositoryInterface $repo
    ) {}

    public function execute(int $userId)
    {
        $user = $this->repo->findById($userId);

        $this->repo->deleteTokens($user);

        return [
            "message"=>"Logged out"
        ];
    }
}