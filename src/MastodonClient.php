<?php

namespace Revolution\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

use Illuminate\Support\Traits\Macroable;
use BadMethodCallException;
use Closure;

class MastodonClient implements MastodonClientInterface
{
    use Traits\AppsTrait;
    use Traits\AccountsTrait;
    use Traits\StatusesTrait;
    use Traits\StreamingTrait;

    use Macroable;

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
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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
        $url = $this->apiEndpoint() . $api;

        if (!empty($this->token)) {
            array_set($options, 'headers.Authorization', 'Bearer ' . $this->token);
        }

        $this->response = $this->client->request($method, $url, $options);

        return json_decode(optional($this->response)->getBody(), true);
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
    public function apiEndpoint(): string
    {
        return $this->domain . $this->api_base . $this->api_version;
    }

    /**
     * @deprecated PSR
     * @see apiEndpoint()
     *
     * @return string
     */
    public function api_endpoint(): string
    {
        return $this->apiEndpoint();
    }

    /**
     * @param ClientInterface $client
     *
     * @return MastodonClientInterface
     */
    public function setClient(ClientInterface $client): MastodonClientInterface
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @param string $domain
     *
     * @return MastodonClientInterface
     */
    public function domain(string $domain): MastodonClientInterface
    {
        $this->domain = trim($domain, '/');

        return $this;
    }

    /**
     * @param string $token
     *
     * @return MastodonClientInterface
     */
    public function token(string $token): MastodonClientInterface
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $api_version
     *
     * @return MastodonClientInterface
     */
    public function apiVersion(string $api_version): MastodonClientInterface
    {
        $this->api_version = $api_version;

        return $this;
    }

    /**
     * @deprecated PSR
     * @see apiVersion()
     *
     * @param string $api_version
     *
     * @return MastodonClientInterface
     */
    public function api_version(string $api_version): MastodonClientInterface
    {
        return $this->apiVersion($api_version);
    }

    /**
     * @param string $api_base
     *
     * @return MastodonClientInterface
     */
    public function apiBase(string $api_base): MastodonClientInterface
    {
        $this->api_base = $api_base;

        return $this;
    }

    /**
     * @deprecated PSR
     * @see apiBase()
     *
     * @param string $api_base
     *
     * @return MastodonClientInterface
     */
    public function api_base(string $api_base): MastodonClientInterface
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

        if (static::hasMacro($method)) {
            if (static::$macros[$method] instanceof Closure) {
                return call_user_func_array(static::$macros[$method]->bindTo($this, static::class), $parameters);
            }
        }

        throw new BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }
}
