<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];
}
