<?php

namespace Plugins\TaxonomyFile;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyFile\CreateLink\FileLink;
use Plugins\TaxonomyFile\Message\FileMessage;
use Plugins\TaxonomyFile\ParamAssigner\FileParamAssigner;
use Plugins\TaxonomyFile\ValidationRules\FileValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('file', FileParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('file', FileValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new FileLink());

        Mapper::extend('file', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            switch (array_get($taxonomy->getAttributes(), 'option')) {
                case 'url':
                    $url = array_get($taxonomy->getAttributes(), 'url');

                    if (Str::length($url) > 0) {
                        return new FileMessage($recipient, $url);
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
