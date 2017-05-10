<?php

namespace Revolution\Mastodon\Providers;

use Illuminate\Support\ServiceProvider;

use Revolution\Mastodon\MastodonClient;

class MastodonServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

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
        $this->app->singleton(MastodonClient::class, function ($app) {
            return new MastodonClient();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [MastodonClient::class];
    }
}
