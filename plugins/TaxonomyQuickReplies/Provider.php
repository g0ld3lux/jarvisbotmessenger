<?php

namespace Plugins\TaxonomyQuickReplies;

use App\Models\Respond;
use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyQuickReplies\CreateLink\QuickRepliesLink;
use Plugins\TaxonomyQuickReplies\Message\QuickRepliesMessage;
use Plugins\TaxonomyQuickReplies\Message\QuickReplyMessageElement;
use Plugins\TaxonomyQuickReplies\ParamAssigner\QuickRepliesParamAssigner;
use Plugins\TaxonomyQuickReplies\ParamAssigner\QuickReplyParamAssigner;
use Plugins\TaxonomyQuickReplies\ValidationRules\QuickRepliesValidationRules;
use Plugins\TaxonomyQuickReplies\ValidationRules\QuickReplyValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('quick_replies', QuickRepliesParamAssigner::class);
        app(ParamAssignerRegistry::class)->add('quick_reply', QuickReplyParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('quick_replies', QuickRepliesValidationRules::class);
        app(ValidationRulesRegistry::class)->add('quick_reply', QuickReplyValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new QuickRepliesLink());

        Mapper::extend('quick_replies', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $text = array_get($taxonomy->getAttributes(), 'text');

            if (Str::length($text) > 0) {
                $quickReplies = [];

                /** @var Taxonomy $child */
                foreach ($taxonomy->getChildren() as $child) {
                    if ($child->getType() == 'quick_reply') {
                        $quickReplies = array_merge($quickReplies, $mapper->mapTaxonomy($child, $recipient));
                    }
                }

                if (count($quickReplies) > 0) {
                    return new QuickRepliesMessage($recipient, [
                        'text' => $text,
                        'quick_replies' => $quickReplies,
                    ]);
                }

                throw new \Exception('No quick replies was set.');
            }

            throw new \Exception('No text was set.');
        });

        Mapper::extend('quick_reply', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $type = array_get($taxonomy->getAttributes(), 'content_type');

            if (!in_array($type, ['text'])) {
                throw new \Exception('Quick reply content type is invalid.');
            }

            $title = array_get($taxonomy->getAttributes(), 'title');

            if (Str::length($title) <= 0) {
                throw new \Exception('Quick reply title is not set.');
            }

            $payload = '$$QUICKREPLY$$'.$taxonomy->getOriginal()->id;

            return new QuickReplyMessageElement($type, $title, $payload);
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
