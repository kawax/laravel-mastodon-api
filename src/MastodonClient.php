<?php

namespace Revolution\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

use Revolution\Mastodon\Traits\AppsTrait;
use Revolution\Mastodon\Traits\AccountsTrait;
use Revolution\Mastodon\Traits\StatusesTrait;
use Revolution\Mastodon\Traits\StreamingTrait;

class MastodonClient implements MastodonClientInterface
{
    use AppsTrait;
    use AccountsTrait;
    use StatusesTrait;
    use StreamingTrait;

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
     * Apps constructor.
     *
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $method
     * @param string $api
     * @param array  $options
     *
     * @return array
     */
    public function call(string $method, string $api, array $options = []): array
    {
        $url = $this->api_endpoint() . $api;

        if (!empty($this->token)) {
            array_set($options, 'headers.Authorization', 'Bearer ' . $this->token);
        }

        $response = $this->client->request($method, $url, $options);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $api
     * @param array  $query
     *
     * @return array
     */
    public function get(string $api, array $query = []): array
    {
        $options = [];

        if (!empty($query)) {
            $options['query'] = $query;
        }

        return $this->call('GET', $api, $options);
    }

    /**
     * @param string $api
     * @param array  $params
     *
     * @return array
     */
    public function post(string $api, array $params = []): array
    {
        $options = [];

        if (!empty($params)) {
            $options['form_params'] = $params;
        }

        return $this->call('POST', $api, $options);
    }

    /**
     * @return string
     */
    public function api_endpoint(): string
    {
        return $this->domain . '/api/' . $this->api_version;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $domain
     *
     * @return $this
     */
    public function domain(string $domain)
    {
        $this->domain = trim($domain, '/');

        return $this;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function token(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $api_version
     *
     * @return $this
     */
    public function api_version(string $api_version)
    {
        $this->api_version = $api_version;

        return $this;
    }

    /**
     * Magic call method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->client, $method)) {
            return call_user_func_array([$this->client, $method], $parameters);
        }

        throw new \BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }
}
