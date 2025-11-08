<?php

namespace App\Providers;

use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\EloquentProjectRepository;
use App\Repositories\EloquentTaskRepository;
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
        TaskRepositoryInterface::class => EloquentTaskRepository::class
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
