<?php

namespace Plugins\TaxonomyImage;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use pimax\Messages\ImageMessage;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyImage\CreateLink\ImageLink;
use Plugins\TaxonomyImage\ParamAssigner\ImageParamAssigner;
use Plugins\TaxonomyImage\ValidationRules\ImageValidationRules;
use Storage;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('image', ImageParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('image', ImageValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new ImageLink());

        Mapper::extend('image', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            switch (array_get($taxonomy->getAttributes(), 'option')) {
                case 'url':
                    $url = array_get($taxonomy->getAttributes(), 'url');

                    if (Str::length($url) > 0) {
                        return new ImageMessage($recipient, $url);
                    }
                    break;

                case 'upload':
                    $source = array_get($taxonomy->getAttributes(), 'source');

                    if (Str::length($source) > 0 && Storage::exists('public/taxonomies/'.$source)) {
                        return new ImageMessage($recipient, storage_path('app/public/taxonomies/'.$source));
                    }
                    break;
            }

            throw new \Exception('No image was set.');
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
