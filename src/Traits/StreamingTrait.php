<?php

namespace Revolution\Mastodon\Traits;

use GuzzleHttp\Psr7;

trait StreamingTrait
{
    /**
     * @param string   $url
     * @param callable $callback (string $event, string $data)
     */
    public function streaming(string $url, callable $callback)
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'stream'  => true,
        ];

        $response = $this->request('GET', $url, $options);

        $body = $response->getBody();

        $stream = new Psr7\CachingStream($body);

        while (!$stream->eof()) {
            $line = Psr7\readline($stream);
            $line = trim($line);

            if (starts_with($line, 'event: ')) {
                $event = substr($line, 7);

                $data = substr(trim(Psr7\readline($stream)), 6);

                $callback($event, $data);
            }
        }
    }
}
