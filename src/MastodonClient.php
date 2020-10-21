<?php

namespace Revolution\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Revolution\Mastodon\Contracts\Factory;

class MastodonClient implements Factory
{
    use Concerns\Apps;
    use Concerns\Accounts;
    use Concerns\Statuses;
    use Concerns\Streaming;
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var string
     */
    protected $api_version = 'v1';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $api_base = '/api/';

    /**
     * @var mixed|\Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * constructor.
     *
     * @param  ClientInterface  $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param  string  $method
     * @param  string  $api
     * @param  array  $options
     *
     * @return array
     */
    public function call(string $method, string $api, array $options = []): array
    {
        $url = $this->apiEndpoint().$api;

        if (! empty($this->token)) {
            Arr::set($options, 'headers.Authorization', 'Bearer '.$this->token);
        }

        $this->response = $this->client->request($method, $url, $options);

        return json_decode(optional($this->response)->getBody(), true);
    }

    /**
     * @param  string  $api
     * @param  array  $query
     *
     * @return array
     */
    public function get(string $api, array $query = []): array
    {
        $options = [];

        if (! empty($query)) {
            $options['query'] = $query;
        }

        return $this->call('GET', $api, $options);
    }

    /**
     * @param  string  $api
     * @param  array  $params
     *
     * @return array
     */
    public function post(string $api, array $params = []): array
    {
        $options = [];

        if (! empty($params)) {
            $options['form_params'] = $params;
        }

        return $this->call('POST', $api, $options);
    }

    /**
     * @return string
     */
    public function apiEndpoint(): string
    {
        return $this->domain.$this->api_base.$this->api_version;
    }

    /**
     * @return string
     * @see apiEndpoint()
     *
     * @deprecated PSR
     */
    public function api_endpoint(): string
    {
        return $this->apiEndpoint();
    }

    /**
     * @param  ClientInterface  $client
     *
     * @return Factory
     */
    public function setClient(ClientInterface $client): Factory
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param  string  $domain
     *
     * @return Factory
     */
    public function domain(string $domain): Factory
    {
        $this->domain = trim($domain, '/');

        return $this;
    }

    /**
     * @param  string  $token
     *
     * @return Factory
     */
    public function token(string $token): Factory
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param  string  $api_version
     *
     * @return Factory
     */
    public function apiVersion(string $api_version): Factory
    {
        $this->api_version = $api_version;

        return $this;
    }

    /**
     * @param  string  $api_version
     *
     * @return Factory
     * @deprecated PSR
     * @see apiVersion()
     */
    public function api_version(string $api_version): Factory
    {
        return $this->apiVersion($api_version);
    }

    /**
     * @param  string  $api_base
     *
     * @return Factory
     */
    public function apiBase(string $api_base): Factory
    {
        $this->api_base = $api_base;

        return $this;
    }

    /**
     * @param  string  $api_base
     *
     * @return Factory
     * @deprecated PSR
     * @see apiBase()
     */
    public function api_base(string $api_base): Factory
    {
        return $this->apiBase($api_base);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Magic call method.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->client, $method)) {
            return $this->client->{$method}(...array_values($parameters));
        }

        return $this->macroCall($method, $parameters);
    }
}
