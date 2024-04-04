<?php

namespace Revolution\Mastodon\Concerns;

trait Accounts
{
    /**
     * Retrieve account of authenticated user.
     */
    public function verifyCredentials(): array
    {
        return $this->get('/accounts/verify_credentials');
    }
}
