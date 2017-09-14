<?php

namespace Revolution\Mastodon\Traits;

trait AccountsTrait
{
    /**
     * Retrieve account of authenticated user
     *
     * @return array
     */
    public function verifyCredentials(): array
    {
        return $this->get('/accounts/verify_credentials');
    }

    /**
     * @deprecated PSR
     * @see verifyCredentials()
     *
     * @return array
     */
    public function verify_credentials(): array
    {
        return $this->verifyCredentials();
    }
}
