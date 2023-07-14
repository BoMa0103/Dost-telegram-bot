<?php

namespace App\Providers;

use App\Services\Cart\Repositories\CacheCartRepository;
use App\Services\Cart\Repositories\CartRepository;
use App\Services\Orders\Repositories\EloquentOrderRepository;
use App\Services\Orders\Repositories\OrderRepository;
use App\Services\Users\Repositories\EloquentUserRepository;
use App\Services\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CartRepository::class, CacheCartRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
