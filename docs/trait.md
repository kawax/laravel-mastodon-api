# Mastodon Trait
Like a Laravel Notifications.

Add `Mastodon` trait to User model.(or other model)

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Revolution\Mastodon\Traits\Mastodon;

class User extends Authenticatable
{
    use Notifiable;
    use Mastodon;

    /**
     * @return string
     */
    protected function mastodonDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    protected function mastodonToken()
    {
        return $this->token;
    }
}
```

Add `mastodonDomain()` and `mastodonToken()`(abstract).

Trait has `mastodon()` that returns `Mastodon` instance.

```php
    public function __invoke(Request $request)
    {
        $statuses = $request->user()
                            ->mastodon()
                            ->statuses($account_id);

        dd($statuses);
    }
```

## Already mastodon() exists

```php
use Mastodon {
    Mastodon::mastodon as toots;
}
```
