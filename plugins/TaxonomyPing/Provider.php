<?php

namespace Plugins\TaxonomyPing;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyPing\CreateLink\PingLink;
use Plugins\TaxonomyPing\Executable\Ping;
use Plugins\TaxonomyPing\ParamAssigner\PingParamAssigner;
use Plugins\TaxonomyPing\ValidationRules\PingValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('ping', PingParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('ping', PingValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::HOOK, new PingLink());

        Mapper::extend('ping', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $url = array_get($taxonomy->getAttributes(), 'url');

            if (Str::length($url) > 0) {
                return new Ping($url);
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
