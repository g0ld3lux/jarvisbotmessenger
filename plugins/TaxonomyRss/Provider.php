<?php

namespace Plugins\TaxonomyRss;

use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Support\Str;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyRss\CreateLink\RssLink;
use Plugins\TaxonomyRss\Executable\Rss;
use Plugins\TaxonomyRss\ParamAssigner\RssParamAssigner;
use Plugins\TaxonomyRss\ValidationRules\RssValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('rss', RssParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('rss', RssValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::PLUGIN, new RssLink());

        Mapper::extend('rss', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $url = array_get($taxonomy->getAttributes(), 'url');

            if (Str::length($url) <= 0) {
                throw new \Exception('No URL was set.');
            }

            $count = array_get($taxonomy->getAttributes(), 'count');

            if ($count > 9 || $count <= 0) {
                throw new \Exception('Count is invalid.');
            }

            $textLink = array_get($taxonomy->getAttributes(), 'text_link');

            if (Str::length($textLink) <= 0) {
                throw new \Exception('No text link was set.');
            }

            return new Rss($url, $count, $textLink);
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
