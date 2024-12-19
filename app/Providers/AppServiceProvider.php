<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
//Para la paginacion
use Illuminate\Pagination\Paginator;
use App\Models\Log;
use App\Models\Materia;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Observers\LogObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        
        Pedido::observe(LogObserver::class);
        Venta::observe(LogObserver::class);
        Producto::observe(LogObserver::class);
        Materia::observe(LogObserver::class);
        User::observe(LogObserver::class);
        Role::observe(LogObserver::class);
    }
}
