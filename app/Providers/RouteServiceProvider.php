<?php

namespace App\Providers;

use App\Models\Recipient;
use App\Models\Mass;
use App\Models\Subscription\Channel;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });

        $router->group([
            'namespace' => $this->namespace,
        ], function ($router) {
            require app_path('Http/routes_incoming.php');
        });

        $router->bind('recipientVariable', function ($value) {
            return Recipient\Variable::findOrFail($value);
        });

        $router->bind('massMessage', function ($value) {
            return Mass\Message::findOrFail($value);
        });

        $router->bind('subscriptionChannel', function ($value) {
            return Channel::findOrFail($value);
        });

        $router->bind('channelBroadcast', function ($value) {
            return Channel\Broadcast::findOrFail($value);
        });
    }
}
