# Macroable

Extend any method by your self.

## Register in AppServiceProvider.php

```php
use Revolution\Mastodon\Facades\Mastodon;

    public function boot()
    {
        Mastodon::macro('instance', function () {
            return $this->get('/instance');
        });
    }
```

## Use somewhere
```php
$instance = Mastodon::domain($domain)->instance();
```
