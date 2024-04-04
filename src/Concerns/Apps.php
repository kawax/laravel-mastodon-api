<?php

namespace Revolution\Mastodon\Concerns;

trait Apps
{
    /**
     * Register a new OAuth client app on the target instance.
     */
    public function createApp(string $client_name, string $redirect_uris, string $scopes, string $website = ''): array
    {
        $params = compact('client_name', 'redirect_uris', 'scopes', 'website');

        return $this->post('/apps', $params);
    }
}
