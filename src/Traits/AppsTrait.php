<?php

namespace Revolution\Mastodon\Traits;

trait AppsTrait
{
    /**
     * Register a new OAuth client app on the target instance
     *
     * @param string $client_name
     * @param string $redirect_uris
     * @param string $scopes
     * @param string $website
     *
     * @return array
     */
    public function createApp(string $client_name, string $redirect_uris, string $scopes, string $website = ''): array
    {
        $params = compact('client_name', 'redirect_uris', 'scopes', 'website');

        return $this->post('/apps', $params);
    }

    /**
     * @deprecated PSR
     * @see createApp()
     *
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
        return $this->createApp($client_name, $redirect_uris, $scopes, $website);
    }
}
