<?php

namespace Revolution\Mastodon\Concerns;

trait Apps
{
    /**
     * Register a new OAuth client app on the target instance.
     *
     * @param  string  $client_name
     * @param  string  $redirect_uris
     * @param  string  $scopes
     * @param  string  $website
     * @return array
     */
    public function createApp(string $client_name, string $redirect_uris, string $scopes, string $website = ''): array
    {
        $params = compact('client_name', 'redirect_uris', 'scopes', 'website');

        return $this->post('/apps', $params);
    }
}
