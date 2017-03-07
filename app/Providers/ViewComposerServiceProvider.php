<?php namespace App\Providers;

use App\Http\ViewComposers\MenuBotsComposer;
use App\Http\ViewComposers\RouteParamsComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Factory $factory
     */
    public function boot(Factory $factory)
    {
        $factory->composer(['*'], RouteParamsComposer::class);
        $factory->composer(['layouts.*'], MenuBotsComposer::class);
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
