<?php

namespace App\Providers;

use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\EloquentProjectRepository;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public $bindings = [
        UserRepositoryInterface::class => EloquentUserRepository::class,
        ProjectRepositoryInterface::class => EloquentProjectRepository::class,
    ];
    public function register(): void
    {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
