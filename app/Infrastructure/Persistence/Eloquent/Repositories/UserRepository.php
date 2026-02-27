<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Entities\User;
use App\Infrastructure\Persistence\Eloquent\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    private function toEntity(UserModel $model): User
    {
        return new User(
            $model->id,
            $model->name,
            $model->email,
            $model->password,
            $model->role
        );
    }
    
    public function findByEmail(string $email): ?User
    {
        $model = UserModel::where('email',$email)->first();

        return $model ? $this->toEntity($model) : null;
    }

    public function findById(int $id): ?User
    {
        $model = UserModel::find($id);

        return $model ? $this->toEntity($model) : null;
    }

    public function verifyPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function createToken(User $user): string
    {
        $model = UserModel::find($user->id);

        return $model->createToken('api-token')->plainTextToken;
    }

    public function deleteTokens(User $user): void
    {
        UserModel::find($user->id)
            ->tokens()
            ->delete();
    }
}