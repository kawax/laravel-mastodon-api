<?php

namespace Revolution\Mastodon\Facades;

use Illuminate\Support\Facades\Facade;

use Revolution\Mastodon\MastodonClient;

class Mastodon extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MastodonClient::class;
    }
}
