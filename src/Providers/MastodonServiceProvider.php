<?php

namespace Revolution\Mastodon\Providers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Revolution\Mastodon\Contracts\Factory;
use Revolution\Mastodon\MastodonClient;

class MastodonServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Factory::class, fn ($app) => new MastodonClient(new Client()));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            Factory::class,
        ];
    }
}
