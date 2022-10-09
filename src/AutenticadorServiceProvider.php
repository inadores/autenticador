<?php
namespace Inador\Autenticador;

use App\Http\Middleware\AutorizadorMiddleware;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class AutenticadorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //agregando rutas de api
        Route::middleware('api')->prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    public function register()
    {
        //
    }
}