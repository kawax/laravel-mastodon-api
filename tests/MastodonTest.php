<?php

namespace Revolution\Mastodon\tests;

use PHPUnit\Framework\TestCase;

use Revolution\Mastodon\MastodonClient;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class MastodonTest extends TestCase
{
    /**
     * @var MastodonClient
     */
    protected $mastodon;

    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $this->mastodon = new MastodonClient();

        $this->setClientHandler(json_encode(['test' => 'test']));
    }

    /**
     * @param mixed $body
     */
    public function setClientHandler($body)
    {
        $mock = new MockHandler([
            new Response(200, [], $body),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->mastodon->setClient($client);
    }

    public function testMastodonInstance()
    {
        $this->assertInstanceOf('Revolution\Mastodon\MastodonClient', $this->mastodon);
    }

    public function testCall()
    {
        $response = $this->mastodon->api_version('v1')
                                   ->api_base('/api/')
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

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method [test] does not exist.
     */
    public function testRequestException()
    {
        $response = $this->mastodon->test();
    }

    public function testAppRegister()
    {
        $response = $this->mastodon->domain('https://example.com')
                                   ->app_register('', '', '');

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testVerifyCredentials()
    {
        $response = $this->mastodon->domain('https://example.com')
                                   ->token('test')
                                   ->verify_credentials();

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStatusList()
    {
        $response = $this->mastodon->domain('https://example.com')
                                   ->token('test')
                                   ->status_list(0);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStatusGet()
    {
        $response = $this->mastodon->domain('https://example.com')
                                   ->token('test')
                                   ->status_get(0);

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStatusPost()
    {
        $response = $this->mastodon->domain('https://example.com')
                                   ->token('test')
                                   ->status_post('test');

        $this->assertJson('{"test": "test"}', json_encode($response));
    }

    public function testStreaming()
    {
        $res = 'event: update' . PHP_EOL . 'data: ' . json_encode(['test' => 'test']);

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
}
