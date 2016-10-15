<?php

namespace Plugins\TaxonomyAudio;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyAudio\CreateLink\AudioLink;
use Plugins\TaxonomyAudio\Message\AudioMessage;
use Plugins\TaxonomyAudio\ParamAssigner\AudioParamAssigner;
use Plugins\TaxonomyAudio\ValidationRules\AudioValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('audio', AudioParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('audio', AudioValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new AudioLink());

        Mapper::extend('audio', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            switch (array_get($taxonomy->getAttributes(), 'option')) {
                case 'url':
                    $url = array_get($taxonomy->getAttributes(), 'url');

                    if (Str::length($url) > 0) {
                        return new AudioMessage($recipient, $url);
                    }
                    break;
            }

            throw new \Exception('No file was set.');
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
