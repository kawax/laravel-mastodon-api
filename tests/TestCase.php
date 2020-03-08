<?php

namespace Tests;

use Revolution\Mastodon\Facades\Mastodon;
use Revolution\Mastodon\Providers\MastodonServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MastodonServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Mastodon' => Mastodon::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
