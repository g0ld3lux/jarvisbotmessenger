<?php

namespace Plugins\TaxonomyButtons;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use pimax\Messages\StructuredMessage;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyButtons\CreateLink\ButtonsLink;
use Plugins\TaxonomyButtons\Message\MessageButton;
use Plugins\TaxonomyButtons\ParamAssigner\ButtonParamAssigner;
use Plugins\TaxonomyButtons\ParamAssigner\ButtonsParamAssigner;
use Plugins\TaxonomyButtons\ValidationRules\ButtonsValidationRules;
use Plugins\TaxonomyButtons\ValidationRules\ButtonValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('buttons', ButtonsParamAssigner::class);
        app(ParamAssignerRegistry::class)->add('button', ButtonParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('buttons', ButtonsValidationRules::class);
        app(ValidationRulesRegistry::class)->add('button', ButtonValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new ButtonsLink());

        Mapper::extend('buttons', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $text = array_get($taxonomy->getAttributes(), 'text');

            if (Str::length($text) > 0) {
                $buttons = [];

                /** @var Taxonomy $child */
                foreach ($taxonomy->getChildren() as $child) {
                    if ($child->getType() == 'button') {
                        $buttons = array_merge($buttons, $mapper->mapTaxonomy($child, $recipient));
                    }
                }

                if (count($buttons) > 0) {
                    return new StructuredMessage($recipient, StructuredMessage::TYPE_BUTTON, [
                        'text' => $text,
                        'buttons' => $buttons,
                    ]);
                }

                throw new \Exception('No buttons was set.');
            }

            throw new \Exception('No text was set.');
        });

        Mapper::extend('button', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $option = array_get($taxonomy->getAttributes(), 'option');

            if (!in_array($option, ['web_url', 'postback', 'phone_number'])) {
                throw new \Exception('Button option is invalid.');
            }

            $title = array_get($taxonomy->getAttributes(), 'title');

            if (Str::length($title) <= 0) {
                throw new \Exception('Button title is not set.');
            }

            if ($option == 'web_url') {
                $url = array_get($taxonomy->getAttributes(), 'url');

                if (Str::length($url) <= 0) {
                    throw new \Exception('Button url is not set.');
                }
            } elseif ($option == 'phone_number') {
                $url = array_get($taxonomy->getAttributes(), 'phone_number');

                if (Str::length($url) <= 0) {
                    throw new \Exception('Button phone number is not set.');
                }
            } else {
                $url = '$$POSTBACK$$'.$taxonomy->getOriginal()->id;
            }

            return new MessageButton($option, $title, $url);
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
