<?php

namespace App\Providers;

use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Str;
use PicoFeed\PicoFeedException;
use PicoFeed\Reader\Reader;
use Storage;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Factory $factory
     * @param Hasher $hasher
     * @param Request $request
     */
    public function boot(Factory $factory, Hasher $hasher, Request $request)
    {
        $factory->extend('old_password', function ($attribute, $value, $parameters) use ($hasher) {
            return $hasher->check($value, $parameters[0]);
        });

        $factory->extend('recipient_variable_accessor', function ($attribute, $value, $parameters) use ($request) {
            $accessor = Str::slug($value);

            $query = Recipient\Variable::where('bot_id', $parameters[0])->where('accessor', $accessor);

            if (isset($parameters[1])) {
                $query = $query->where('id', '<>', $parameters[1]);
            }

            return $query->count() <= 0;
        });

        $factory->extend('rss_feed', function ($attribute, $value, $parameters) use ($request) {
            try {
                $reader = new Reader();
                $resource = $reader->download($value);

                $reader->getParser(
                    $resource->getUrl(),
                    $resource->getContent(),
                    $resource->getEncoding()
                );

                return true;
            } catch (PicoFeedException $e) {
            }

            return false;
        });

        $factory->extend('flows_file', function ($attribute, $value) use ($request) {
            $file = $request->file($attribute);

            try {
                try {
                    Storage::delete('public/import/bot_'.($request->route('bot')->id).'.json');
                } catch (\Exception $e) {
                    // ignore
                }

                $file->move(storage_path('app/public/import/'), 'bot_'.($request->route('bot')->id).'.json');

                $content = json_decode(
                    Storage::get('public/import/bot_'.($request->route('bot')->id).'.json')
                );

                if (!isset($content->meta->version)) {
                    return false;
                }

                if ($content->meta->version != 1) {
                    return false;
                }

                return true;
            } catch (\Exception $e) {
                // ignore
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
