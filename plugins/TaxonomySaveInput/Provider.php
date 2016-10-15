<?php

namespace Plugins\TaxonomySaveInput;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomySaveInput\CreateLink\SaveInputLink;
use Plugins\TaxonomySaveInput\Executable\SaveInput;
use Plugins\TaxonomySaveInput\ParamAssigner\SaveInputParamAssigner;
use Plugins\TaxonomySaveInput\ValidationRules\SaveInputValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('save_input', SaveInputParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('save_input', SaveInputValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::HOOK, new SaveInputLink());

        Mapper::extend('save_input', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $variable = array_get($taxonomy->getAttributes(), 'variable');

            if (Str::length($variable) <= 0) {
                throw new \Exception('No variable was set.');
            }

            return new SaveInput($variable);
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
