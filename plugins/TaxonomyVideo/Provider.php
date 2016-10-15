<?php

namespace Plugins\TaxonomyVideo;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyVideo\CreateLink\VideoLink;
use Plugins\TaxonomyVideo\Message\VideoMessage;
use Plugins\TaxonomyVideo\ParamAssigner\VideoParamAssigner;
use Plugins\TaxonomyVideo\ValidationRules\VideoValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('video', VideoParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('video', VideoValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new VideoLink());

        Mapper::extend('video', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            switch (array_get($taxonomy->getAttributes(), 'option')) {
                case 'url':
                    $url = array_get($taxonomy->getAttributes(), 'url');

                    if (Str::length($url) > 0) {
                        return new VideoMessage($recipient, $url);
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
