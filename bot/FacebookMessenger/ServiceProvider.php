<?php

namespace Bot\FacebookMessenger;

use App\Services\RecipientProvider;
use App\Services\RespondMatcher;
use Bot\Core\Processor;
use Bot\FacebookMessenger\Handler;
use Illuminate\Contracts\Bus\Dispatcher;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Handler\VerificationHandler::class, function () {
            return new Handler\VerificationHandler();
        });

        $this->app->singleton(Handler\RespondHandler::class, function ($app) {
            return new Handler\RespondHandler($app->make(Dispatcher::class));
        });

        $this->app->singleton(Bots::class, function () {
            return new Bots();
        });

        $this->app->tag(Handler\VerificationHandler::class, Processor::TAG);
        $this->app->tag(Handler\RespondHandler::class, Processor::TAG);
    }
}
