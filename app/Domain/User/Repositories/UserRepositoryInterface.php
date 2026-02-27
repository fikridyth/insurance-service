<?php

namespace App\Domain\User\Repositories;

use App\Domain\User\Entities\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function findById(int $id): ?User;
    public function verifyPassword(User $user, string $password): bool;
    public function createToken(User $user): string;
    public function deleteTokens(User $user): void;
}