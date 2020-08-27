<?php


namespace Hamlet\Modules\Auth;


use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadRoutesFrom(__DIR__ . '/Routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

}
