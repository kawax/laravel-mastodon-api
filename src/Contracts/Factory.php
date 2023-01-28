<?php

namespace Revolution\Mastodon\Contracts;

use GuzzleHttp\ClientInterface;

interface Factory
{
    /**
     * @param  string  $client_name
     * @param  string  $redirect_uris
     * @param  string  $scopes
     * @param  string  $website
     *
     * @return array
     */
    public function createApp(string $client_name, string $redirect_uris, string $scopes, string $website = ''): array;

    /**
     * @return array
     */
    public function verifyCredentials(): array;

    /**
     * @param  string  $method
     * @param  string  $api
     * @param  array  $options
     *
     * @return array
     */
    public function call(string $method, string $api, array $options = []): array;

    /**
     * @param  string  $api
     * @param  array  $query
     *
     * @return array
     */
    public function get(string $api, array $query = []): array;

    /**
     * @param  string  $api
     * @param  array  $params
     *
     * @return array
     */
    public function post(string $api, array $params = []): array;

    /**
     * @return string
     */
    public function apiEndpoint(): string;

    /**
     * @param  ClientInterface  $client
     *
     * @return Factory
     */
    public function setClient(ClientInterface $client): self;

    /**
     * @param  string  $domain
     *
     * @return Factory
     */
    public function domain(string $domain): self;

    /**
     * @param  string  $token
     *
     * @return Factory
     */
    public function token(string $token): self;

    /**
     * @param  string  $api_version
     *
     * @return Factory
     */
    public function apiVersion(string $api_version): self;

    /**
     * @param  string  $api_base
     *
     * @return Factory
     */
    public function apiBase(string $api_base): self;

    /**
     * @return mixed
     */
    public function getResponse(): mixed;

    /**
     * @param  int  $account_id
     * @param  int  $limit
     * @param  int  $since_id
     *
     * @return array
     */
    public function statuses(int $account_id, int $limit = 40, int $since_id = null): array;

    /**
     * @param  string  $status
     * @param  array  $options
     *
     * @return array
     */
    public function createStatus(string $status, array $options = []): array;

    /**
     * @param  int  $status_id
     *
     * @return array
     */
    public function status(int $status_id): array;

    /**
     * @param  string  $url
     * @param  callable  $callback  (string $event, string $data)
     */
    public function streaming(string $url, callable $callback): void;
}
