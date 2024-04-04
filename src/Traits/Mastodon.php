<?php

namespace Revolution\Mastodon\Traits;

use Illuminate\Container\Container;
use Revolution\Mastodon\Contracts\Factory;

trait Mastodon
{
    public function mastodon(): Factory
    {
        return Container::getInstance()
            ->make(Factory::class)
            ->domain($this->mastodonDomain())
            ->token($this->mastodonToken());
    }

    abstract protected function mastodonDomain(): string;

    abstract protected function mastodonToken(): string;
}
