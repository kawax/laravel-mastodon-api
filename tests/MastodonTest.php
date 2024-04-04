<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Revolution\Mastodon\Facades\Mastodon;
use Revolution\Mastodon\MastodonClient;

class MastodonTest extends TestCase
{
    protected MastodonClient $mastodon;

    protected Client $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->setClientHandler(json_encode(['test' => 'test']));
    }

    public function setClientHandler(mixed $body): void
    {
        $mock = new MockHandler([
            new Response(200, [], $body),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->mastodon = new MastodonClient($client);
    }

    public function testCall()
    {
        $response = $this->mastodon->apiVersion('v1')
            ->apiBase('/api/')
            ->domain('https://example.com')
            ->token('token')
            ->call('get', '/');

        $this->assertArrayHasKey('test', $response);
        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testGet()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->token('token')
            ->get('/', ['query' => 'test']);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testPost()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->token('token')
            ->post('/', ['params' => 'test']);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testRequest()
    {
        $response = $this->mastodon->request('get', '/', ['query' => 'test']);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testRequestException()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('does not exist.');

        $response = $this->mastodon->test();
    }

    public function testCreateApp()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->createApp('', '', '');

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testVerifyCredentials()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->token('test')
            ->verifyCredentials();

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStatusList()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->token('test')
            ->statuses(0);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStatusGet()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->token('test')
            ->status(0);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStatusPost()
    {
        $response = $this->mastodon->domain('https://example.com')
            ->token('test')
            ->createStatus('test');

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStreaming()
    {
        $res = 'event: update'.PHP_EOL.'data: '.json_encode(['test' => 'test']);

        $this->setClientHandler($res);

        $e = $d = '';

        $this->mastodon->token('test')
            ->streaming('https://example.com/api/v1/streaming/public',
                function ($event, $data) use (&$e, &$d) {
                    $e = $event;
                    $d = $data;
                });

        $this->assertEquals('update', $e);
        $this->assertJson('{"test": "test"}', json_encode($d));
    }

    public function testMacroable()
    {
        MastodonClient::macro('instance', function () {
            return $this->get('/instance');
        });

        $mastodon = new MastodonClient(new Client());

        $this->assertTrue(MastodonClient::hasMacro('instance'));
        $this->assertTrue(is_callable(MastodonClient::class, 'instance'));
    }

    public function testResponse()
    {
        $res = Mastodon::getResponse();

        $this->assertNull($res);
    }
}
