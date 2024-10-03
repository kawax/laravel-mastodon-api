<?php

namespace Revolution\Mastodon\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Revolution\Mastodon\Contracts\Factory;
use Revolution\Mastodon\MastodonClient;

class MastodonServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->scoped(Factory::class, MastodonClient::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            Factory::class,
        ];
    }
}
