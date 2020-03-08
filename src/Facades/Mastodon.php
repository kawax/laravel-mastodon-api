<?php

namespace Revolution\Mastodon\Facades;

use Illuminate\Support\Facades\Facade;
use Revolution\Mastodon\Contracts\Factory;

class Mastodon extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
