<?php

namespace Revolution\Mastodon\Concerns;

use GuzzleHttp\Psr7\CachingStream;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Str;

trait Streaming
{
    /**
     * @param  string  $url
     * @param  callable  $callback  (string $event, string $data)
     */
    public function streaming(string $url, callable $callback): void
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
            ],
            'stream'  => true,
        ];

        $response = $this->request('GET', $url, $options);

        $body = $response->getBody();

        $stream = new CachingStream($body);

        while (! $stream->eof()) {
            $line = Utils::readLine($stream);
            $line = trim($line);

            if (Str::startsWith($line, 'event: ')) {
                $event = substr($line, 7);

                $data = substr(trim(Utils::readLine($stream)), 6);

                $callback($event, $data);
            }
        }
    }
}
