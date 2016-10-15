<?php

namespace Plugins\TaxonomyText;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use pimax\Messages\Message;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyText\CreateLink\TextLink;
use Plugins\TaxonomyText\ParamAssigner\TextParamAssigner;
use Plugins\TaxonomyText\ValidationRules\TextValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('text', TextParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('text', TextValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new TextLink());

        Mapper::extend('text', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $text = array_get($taxonomy->getAttributes(), 'text');

            if (Str::length($text) > 0) {
                return new Message($recipient, $text);
            }

            throw new \Exception('No text was set.');
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
