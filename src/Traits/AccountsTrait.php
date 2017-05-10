<?php

namespace Revolution\Mastodon\Traits;

trait AccountsTrait
{
    /**
     * @return array
     */
    public function verify_credentials(): array
    {
        return $this->get('/accounts/verify_credentials');
    }
}
