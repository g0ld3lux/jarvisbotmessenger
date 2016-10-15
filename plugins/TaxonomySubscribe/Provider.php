<?php

namespace Plugins\TaxonomySubscribe;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomySaveInput\Executable\SaveInput;
use Plugins\TaxonomySubscribe\CreateLink\SubscribeLink;
use Plugins\TaxonomySubscribe\Executable\Subscribe;
use Plugins\TaxonomySubscribe\ParamAssigner\SubscribeParamAssigner;
use Plugins\TaxonomySubscribe\ValidationRules\SubscribeValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('subscribe', SubscribeParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('subscribe', SubscribeValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::HOOK, new SubscribeLink());

        Mapper::extend('subscribe', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $channel = array_get($taxonomy->getAttributes(), 'channel');

            if (Str::length($channel) <= 0) {
                throw new \Exception('No channel was set.');
            }

            $option = array_get($taxonomy->getAttributes(), 'option');

            if (!in_array($option, ['add', 'remove'])) {
                throw new \Exception('subscribe option is invalid.');
            }

            return new Subscribe($channel, $option);
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
