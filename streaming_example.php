<?php

require_once './vendor/autoload.php';

$token = '';

// set full url
// https://example.com/api/v1/streaming/public
$url = '';

$mastodon = new Revolution\Mastodon\MastodonClient(new GuzzleHttp\Client());

$mastodon->token($token)
         ->streaming($url, function ($event, $data) {
             //event: update|notification|delete
             //data: JSON

             if ($event === 'update') {
                 $status = json_decode($data, true);

                 echo strip_tags($status['account']['acct']).PHP_EOL;
                 echo strip_tags($status['content']).PHP_EOL.PHP_EOL;
             }
         });
