<?php

namespace Plugins\TaxonomyChatToggle;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyChatToggle\CreateLink\ChatToggleLink;
use Plugins\TaxonomyChatToggle\Executable\ChatToggle;
use Plugins\TaxonomyChatToggle\ParamAssigner\ChatToggleParamAssigner;
use Plugins\TaxonomyChatToggle\ValidationRules\ChatToggleValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('chat_toggle', ChatToggleParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('chat_toggle', ChatToggleValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::HOOK, new ChatToggleLink());

        Mapper::extend('chat_toggle', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $option = array_get($taxonomy->getAttributes(), 'option');

            if (!in_array($option, ['enable', 'disable'])) {
                throw new \Exception('Chat toggle option is invalid.');
            }

            return new ChatToggle($option);
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
