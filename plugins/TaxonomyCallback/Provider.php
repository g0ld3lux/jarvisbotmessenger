<?php

namespace Plugins\TaxonomyCallback;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyCallback\CreateLink\CallbackLink;
use Plugins\TaxonomyCallback\Executable\Callback;
use Plugins\TaxonomyCallback\ParamAssigner\CallbackParamAssigner;
use Plugins\TaxonomyCallback\ValidationRules\CallbackValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('callback', CallbackParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('callback', CallbackValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::PLUGIN, new CallbackLink());

        Mapper::extend('callback', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $url = array_get($taxonomy->getAttributes(), 'url');

            if (Str::length($url) > 0) {
                return new Callback($url);
            }

            throw new \Exception('No URL was set.');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPluginViews(__DIR__ . DIRECTORY_SEPARATOR . 'views');
    }
}
