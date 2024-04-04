<?php

namespace Revolution\Mastodon\Facades;

use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\ResponseInterface;
use Revolution\Mastodon\Contracts\Factory;

/**
 * @method static array createApp(string $client_name, string $redirect_uris, string $scopes, string $website = '')
 * @method static array get(string $api, array $query = [])
 * @method static array post(string $api, array $params = [])
 * @method static static domain(string $domain)
 * @method static static token(string $token)
 * @method static ResponseInterface|null getResponse()
 * @method static array statuses(int $account_id, int $limit = 40, int $since_id = null)
 * @method static array createStatus(string $status, array $options = [])
 * @method static array status(int $status_id)
 * @method static void streaming(string $url, callable $callback)
 */
class Mastodon extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
