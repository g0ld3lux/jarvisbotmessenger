<?php

namespace App\Providers;

use App\Services\Flow\Exchange;
use App\Services\Flow\Exchanger1;
use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Facebook\Facebook;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use App\Models;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $aliases = [
        'facebook.facebook' => [Facebook::class],
        'app.services.taxonomies.param_assigner_registry' => [ParamAssignerRegistry::class],
        'app.services.taxonomies.validation_rules_registry' => [ValidationRulesRegistry::class],
        'app.services.taxonomies.create_link_registry' => [CreateLinkRegistry::class],
        'app.services.flow.exchange' => [Exchange::class],
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'project' => Models\Project::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('facebook.facebook', function ($app) {
            $facebook = new Facebook([
                'app_id' => $app['config']['services.facebook.client_id'],
                'app_secret' => $app['config']['services.facebook.client_secret'],
                'default_graph_version' => 'v2.6',
            ]);

            return $facebook;
        });

        $this->app->singleton('app.services.taxonomies.param_assigner_registry', function () {
            return new ParamAssignerRegistry();
        });

        $this->app->singleton('app.services.taxonomies.validation_rules_registry', function () {
            return new ValidationRulesRegistry();
        });

        $this->app->singleton('app.services.taxonomies.create_link_registry', function () {
            return new CreateLinkRegistry();
        });

        $this->app->singleton('app.services.flow.exchange', function () {
            $exchange = new Exchange();

            $exchange->addExchanger(Exchanger1::VERSION, new Exchanger1());

            return $exchange;
        });

        $this->registerAliases();
    }

    /**
     * Register service aliases.
     *
     * @return void
     */
    protected function registerAliases()
    {
        foreach ($this->aliases as $abstract => $aliases) {
            foreach ($aliases as $alias) {
                $this->app->alias($abstract, $alias);
            }
        }
    }
}
