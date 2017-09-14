# Mastodon API for Laravel

[![Build Status](https://travis-ci.org/kawax/laravel-mastodon-api.svg?branch=master)](https://travis-ci.org/kawax/laravel-mastodon-api)

## Requirements
PHP >= 7.0

## Installation

### Composer
```
composer require revolution/laravel-mastodon-api
```

### Laravel

Not necessary for Laravel >= 5.5

`config/app.php`

```
'providers' => [
        ...
        Revolution\Mastodon\Providers\MastodonServiceProvider::class,
        ...

'aliases' => [
        ...
        'Mastodon' => Revolution\Mastodon\Facades\Mastodon::class,
        ...
```

## Usage

### Registering an application

```php
use Mastodon;

class MastodonController
{
    public function app()
    {
        $client_name = 'my-app';
        $redirect_uris = 'https://my-instance/callback';
        $scopes = 'read write follow';
        
        $app_info = Mastodon::domain('https://example.com')
                            ->createApp($client_name, $redirect_uris, $scopes);

        dd($app_info);
        //[
        //    'id' => '',
        //    'client_id' => '',
        //    'client_secret' => '',
        //]
     }
}
```

### OAuth authentication
Use https://github.com/kawax/socialite-mastodon

Save account info.(`id`, `token`, `username`, `acct`...and more.)

### Get statuses
```php
$statuses = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->statuses($account_id);

dd($statuses);
```

### Get one status
```php
$status = Mastodon::domain('https://example.com')
                  ->token('token')
                  ->status($status_id);

dd($status);
```

### Post status
```php
Mastodon::domain('https://example.com')->token('token');
$response = Mastodon::createStatus('test1');
$response = Mastodon::createStatus('test2', ['visibility' => 'unlisted']);

dd($response);
```

### Any API by `get` or `post` method
```php
$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->get('/timelines/public', ['local' => true]);
```

```php
$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->post('/follows', ['uri' => '']);
```

### Any API can call by `call` method
```php
$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->call('DELETE', '/statuses/1');
```

### Any request through Guzzle
Set all data by your self.

```php
$url = 'https://example.com/api/v1/instance';

$options = [
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
    ]
]

$response = Mastodon::request('GET', $url, $options);

dd($response);
```

### without Laravel, or without Facade

```
use Revolution\Mastodon\MastodonClient;

$mastodon = new MastodonClient();

$statuses = $mastodon->domain('https://example.com')
                     ->token('token')
                     ->statuses($account_id);
```


### Other methods
Check public methods in `MastodonClientInterface.php`

## Streaming API
Edit `$token` and `$url` in streaming_example.php

```
php ./streaming_example.php
```

`Ctrl+C` to quit.

## LICENSE
MIT  
Copyright kawax
