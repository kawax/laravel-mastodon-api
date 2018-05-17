<?php

namespace Revolution\Mastodon\Traits;

use Revolution\Mastodon\Contracts\Factory;

trait Mastodon
{
    /**
     * @return Factory
     */
    public function mastodon()
    {
        return app(Factory::class)->domain($this->mastodonDomain())
                                  ->token($this->mastodonToken());
    }

    /**
     * @return string
     */
    abstract protected function mastodonDomain();

    /**
     * @return string
     */
    abstract protected function mastodonToken();
}
