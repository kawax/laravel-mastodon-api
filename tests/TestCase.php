<?php

namespace Tests;

use Revolution\Mastodon\Facades\Mastodon;
use Revolution\Mastodon\Providers\MastodonServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            MastodonServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Mastodon' => Mastodon::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        //
    }
}
