<?php

namespace Revolution\Mastodon\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

use GuzzleHttp\Client;

use Revolution\Mastodon\Contracts\Factory;
use Revolution\Mastodon\MastodonClient;

class MastodonServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new MastodonClient(new Client());
        });

        $this->app->alias(
            MastodonClient::class,
            Factory::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            MastodonClient::class,
            Factory::class,
        ];
    }
}
