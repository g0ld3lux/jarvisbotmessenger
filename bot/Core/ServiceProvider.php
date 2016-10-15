<?php

namespace Bot\Core;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Processor::class, function ($app) {

            $processor = new Processor();

            foreach ($app->tagged(Processor::TAG) as $service) {
                $processor->addHandler($service);
            }

            return $processor;
        });
    }
}
