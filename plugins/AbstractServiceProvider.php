<?php

namespace Plugins;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

abstract class AbstractServiceProvider extends BaseServiceProvider
{
    /**
     * Register plugin views.
     *
     * @param string $path
     */
    protected function registerPluginViews($path)
    {
        foreach ((new \DirectoryIterator($path)) as $directory) {
            if ($directory->isDir() && !$directory->isDot()) {
                $this->app['view']->addLocation($path);
            }
        }
    }

    /**
     * Register plugin routes.
     *
     * @param string $path
     * @param string $namespace
     */
    protected function registerPluginRoutes($path, $namespace)
    {
        $this->app->make(Router::class)->group(
            ['namespace' => $namespace.'\\Http\\Controllers', 'as' => 'plugins.'],
            function () use ($path) {
                require $path;
            }
        );
    }
}
