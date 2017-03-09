<?php

namespace App\Providers;

use App\Wizard\DefaultSetupWizard;

class WizardServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public static $RES_NAMESPACE = 'setup_wizard';
    public static $CONFIG_FILE = 'setup_wizard.php';
    private $packageDir;

    /** @var string Base directory for the package */


    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->packageDir = dirname(__DIR__);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $config = $this->app['config'];

        // Add the setup wizard routes if asked to
        $loadDefaultRoutes = $config->get('setup_wizard.routing.load_default');
        if ($loadDefaultRoutes && !$this->app->routesAreCached()) {
   
        require($this->packageDir . '/Http/routes_wizard.php');

        }

        // Facade
        $this->app->singleton('SetupWizard', function ($app) {
            $wizard = new DefaultSetupWizard($app);

            return $wizard;
        }
        );

        $this->app->alias('SetupWizard', DefaultSetupWizard::class);

        // We do this to be able to call view like so 
        // wizard::nameOfBladefile
        $this->loadViewsFrom(resource_path('views/wizard'), 'wizard');
        $this->loadTranslationsFrom(resource_path('lang/wizard'), 'wizard');

    }

}