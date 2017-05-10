<?php

namespace Revolution\Mastodon\Traits;

trait AppsTrait
{
    /**
     * @param string $client_name
     * @param string $redirect_uris
     * @param string $scopes
     * @param string $website
     *
     * @return array
     */
    public function app_register(
        string $client_name,
        string $redirect_uris,
        string $scopes,
        string $website = ''
    ): array {

        $params = compact('client_name', 'redirect_uris', 'scopes', 'website');

        return $this->post('/apps', $params);
    }
}
