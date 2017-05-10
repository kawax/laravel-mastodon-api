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
        $scopes = 'read';
        
        $app_info = Mastodon::domain('https://example.com')
                            ->app_register($client_name, $redirect_uris, $scopes);

        dd($app_info);
        //[
        //    'id',
        //    'client_id',
        //    'client_secret'
        //]
     }
}
```

### OAuth authentication
Use https://github.com/kawax/socialite-mastodon

### Get statuses
```php
$statuses = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->status_list($account_id);

dd($statuses);
```

### Post status
```php
Mastodon::domain('https://example.com')->token('token');
$response = Mastodon::status_post('test1');
$response = Mastodon::status_post('test2');

dd($response);
```

### Any API by `get` or `post` method
```php
$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->get('/timelines/public', ['local' => true]);

dd($response);
```

```php
$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->post('/follows', ['uri' => '']);

dd($response);
```

### Any API can call by `call` method
```php
$response = Mastodon::domain('https://example.com')
                    ->token('token')
                    ->call('DELETE', '/statuses/1');

dd($response);
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
                    ->status_list($account_id);
```


### Other methods
Check public methods in `MastodonClientInterface.php`


## LICENSE
MIT  
Copyright kawax
