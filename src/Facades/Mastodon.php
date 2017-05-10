<?php

namespace Revolution\Mastodon\Facades;

use Illuminate\Support\Facades\Facade;

class Mastodon extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Revolution\Mastodon\MastodonClient::class;
    }
}
