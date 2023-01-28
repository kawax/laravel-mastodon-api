<?php

namespace Revolution\Mastodon\Traits;

use Illuminate\Container\Container;
use Revolution\Mastodon\Contracts\Factory;

trait Mastodon
{
    /**
     * @return Factory
     */
    public function mastodon(): Factory
    {
        return Container::getInstance()->make(Factory::class)
                        ->domain($this->mastodonDomain())
                        ->token($this->mastodonToken());
    }

    /**
     * @return string
     */
    abstract protected function mastodonDomain(): string;

    /**
     * @return string
     */
    abstract protected function mastodonToken(): string;
}
