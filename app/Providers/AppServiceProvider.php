<?php

namespace App\Providers;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Repositories\ClaimRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ClaimRepositoryInterface::class,
            ClaimRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
