<?php

namespace Revolution\Mastodon;

use GuzzleHttp\ClientInterface;

interface MastodonClientInterface
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
    ): array;

    /**
     * @return array
     */
    public function verify_credentials(): array;

    /**
     * @param string $method
     * @param string $api
     * @param array  $options
     *
     * @return array
     */
    public function call(string $method, string $api, array $options = []): array;

    /**
     * @param string $api
     * @param array  $query
     *
     * @return array
     */
    public function get(string $api, array $query = []): array;

    /**
     * @param string $api
     * @param array  $params
     *
     * @return array
     */
    public function post(string $api, array $params = []): array;

    /**
     * @return string
     */
    public function api_endpoint(): string;

    /**
     * @param ClientInterface $client
     *
     * @return $this
     */
    public function setClient(ClientInterface $client);

    /**
     * @param string $domain
     *
     * @return $this
     */
    public function domain(string $domain);

    /**
     * @param string $token
     *
     * @return $this
     */
    public function token(string $token);

    /**
     * @param string $api_version
     *
     * @return $this
     */
    public function api_version(string $api_version);

    /**
     * @param int $account_id
     * @param int $limit
     * @param int $since_id
     *
     * @return array
     */
    public function status_list(int $account_id, int $limit = 40, int $since_id = null): array;

    /**
     * @param string $status
     * @param array  $options
     *
     * @return array
     */
    public function status_post(string $status, array $options = []): array;

    /**
     * @param int $status_id
     *
     * @return array
     */
    public function status_get(int $status_id): array;

    /**
     * @param string   $url
     * @param callable $callback (string $event, string $data)
     */
    public function streaming(string $url, callable $callback);
}
