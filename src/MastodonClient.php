<?php

namespace Revolution\Mastodon;

use BadMethodCallException;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Psr\Http\Message\ResponseInterface;
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

    protected string $api_version = 'v1';

    protected ClientInterface $client;

    protected string $domain;

    protected string $token;

    protected string $api_base = '/api/';

    protected ?ResponseInterface $response = null;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function call(string $method, string $api, array $options = []): array
    {
        $url = $this->apiEndpoint().$api;

        if (! empty($this->token)) {
            Arr::set($options, 'headers.Authorization', 'Bearer '.$this->token);
        }

        $this->response = $this->client->request($method, $url, $options);

        return json_decode($this->response->getBody(), true);
    }

    public function get(string $api, array $query = []): array
    {
        $options = [];

        if (! empty($query)) {
            $options['query'] = $query;
        }

        return $this->call('GET', $api, $options);
    }

    public function post(string $api, array $params = []): array
    {
        $options = [];

        if (! empty($params)) {
            $options['form_params'] = $params;
        }

        return $this->call('POST', $api, $options);
    }

    public function apiEndpoint(): string
    {
        return $this->domain.$this->api_base.$this->api_version;
    }

    public function setClient(ClientInterface $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function domain(string $domain): static
    {
        $this->domain = trim($domain, '/');

        return $this;
    }

    public function token(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function apiVersion(string $api_version): static
    {
        $this->api_version = $api_version;

        return $this;
    }

    public function apiBase(string $api_base): static
    {
        $this->api_base = $api_base;

        return $this;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * Magic call method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->client, $method)) {
            return $this->client->{$method}(...array_values($parameters));
        }

        return $this->macroCall($method, $parameters);
    }
}
