<?php

namespace Revolution\Mastodon\Concerns;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\CachingStream;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Str;

trait Streaming
{
    /**
     * @param  callable(string $event, string $data): void  $callback
     *
     * @throws GuzzleException
     */
    public function streaming(string $url, callable $callback): void
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
            ],
            'stream' => true,
        ];

        $response = $this->client->request('GET', $url, $options);

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
