<?php

namespace Plugins\TaxonomyCarousel;

use App\Http\Controllers\TaxonomiesController;
use App\Jobs\Responds\Taxonomies\GetNextOrderJob;
use App\Models\Project;
use App\Models\Respond;
use App\Services\Taxonomies\CreateLinkRegistry;
use App\Services\Taxonomies\ParamAssignerRegistry;
use App\Services\Taxonomies\ValidationRulesRegistry;
use Bot\Core\Respond\Taxonomy;
use Bot\FacebookMessenger\Mapper;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Str;
use pimax\Messages\MessageElement;
use pimax\Messages\StructuredMessage;
use Plugins\AbstractServiceProvider;
use Plugins\TaxonomyCarousel\CreateLink\CarouselLink;
use Plugins\TaxonomyCarousel\ParamAssigner\ElementParamAssigner;
use Plugins\TaxonomyCarousel\ValidationRules\ElementValidationRules;

class Provider extends AbstractServiceProvider
{
    /**
     * Boot plugin.
     */
    public function boot()
    {
        app(ParamAssignerRegistry::class)->add('element', ElementParamAssigner::class);

        app(ValidationRulesRegistry::class)->add('element', ElementValidationRules::class);

        app(CreateLinkRegistry::class)->add(CreateLinkRegistry::MESSAGE, new CarouselLink());

        TaxonomiesController::extend(
            TaxonomiesController::ACTION_CREATE,
            'carousel',
            function (Project $project, Respond $respond, $type, Respond\Taxonomy $parent = null) {
                $taxonomy = new Respond\Taxonomy([
                    'type' => $type,
                    'order' => app(Dispatcher::class)->dispatchNow(new GetNextOrderJob($respond)),
                ]);

                $taxonomy->respond()->associate($respond);

                $taxonomy->save();

                return redirect()->route('projects.responds.edit.taxonomies.edit', [
                    $project->id,
                    $respond->id,
                    $taxonomy->id
                ]);
            }
        );

        Mapper::extend('carousel', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $elements = [];

            foreach ($taxonomy->getChildren() as $child) {
                $elements = array_merge($elements, $mapper->mapTaxonomy($child, $recipient));
            }

            if (count($elements) > 0) {
                return new StructuredMessage($recipient, StructuredMessage::TYPE_GENERIC, [
                    'elements' => $elements,
                ]);
            }

            throw new \Exception('No elements was set.');
        });

        Mapper::extend('element', function (Taxonomy $taxonomy, $recipient, Mapper $mapper) {
            $title = array_get($taxonomy->getAttributes(), 'title');

            if (Str::length($title) <= 0) {
                throw new \Exception('Element title is not set.');
            }

            $imageUrl = array_get($taxonomy->getAttributes(), 'image_url');

            if (Str::length($imageUrl) <= 0) {
                throw new \Exception('Element image_url is not set.');
            }

            $buttons = [];

            /** @var Taxonomy $child */
            foreach ($taxonomy->getChildren() as $child) {
                if ($child->getType() == 'button') {
                    $buttons = array_merge($buttons, $mapper->mapTaxonomy($child, $recipient));
                }
            }

            return new MessageElement($title, array_get($taxonomy->getAttributes(), 'sub_title'), $imageUrl, $buttons);
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
