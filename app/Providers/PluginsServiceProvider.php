<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PluginsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * Create a new service provider instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->providers = $this->getProviders();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->providers as $provider) {
            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPlugins();
    }

    /**
     * Register plugins
     *
     * @return void
     */
    protected function registerPlugins()
    {
        foreach ($this->providers as $provider) {
            if (method_exists($provider, 'register')) {
                $provider->register();
            }
        }
    }

    /**
     * Load plugins providers.
     *
     * @return array
     */
    protected function getProviders()
    {
        $providers = [];

        $pluginsFolder = new \DirectoryIterator($this->getPluginsPath());

        foreach ($pluginsFolder as $folder) {
            if ($folder->isDir() && !$folder->isDot()) {
                $class = $this->getProviderClass($folder);

                if (class_exists($class)) {
                    $providers[] = new $class($this->app);
                }
            }
        }

        return $providers;
    }

    /**
     * Return path to plugins.
     *
     * @return string
     */
    protected function getPluginsPath()
    {
        return base_path('plugins').DIRECTORY_SEPARATOR;
    }

    /**
     * Format provider class.
     *
     * @param \DirectoryIterator $folder
     * @return string
     */
    protected function getProviderClass(\DirectoryIterator $folder)
    {
        return $this->getPluginNamespace($folder).'\\Provider';
    }

    /**
     * Return driver namespace.
     *
     * @param \DirectoryIterator $folder
     * @return string
     */
    protected function getPluginNamespace(\DirectoryIterator $folder)
    {
        return 'Plugins\\'.$folder->getBasename();
    }
}
