<?php

namespace MailitSDK\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MailitSDK\Mailit;
use PHPUnit\Framework\TestCase;

class MailitUnitTest extends TestCase
{
    private string $clientId = 'test_client_id';
    private string $endpoint = 'https://api.example.com';
    private string $secretKey = 'test_secret_key';

    /**
     * @throws GuzzleException
     */
    public function testGetParsedTemplate()
    {
        $slug = 'test_slug';
        $data = ['key' => 'value'];
        $expectedHtml = '<h1>Test HTML Content</h1>';

        $mock = new MockHandler([
            new Response(200, [], $expectedHtml),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $mailit = new Mailit($this->endpoint, $this->clientId, $this->secretKey);
        $mailit->setClient($client);

        $responseHtml = $mailit->getParsedTemplate($slug, $data);

        $this->assertEquals($expectedHtml, $responseHtml);
    }

    public function testGetParsedTemplateThrowsException()
    {
        $this->expectException(\GuzzleHttp\Exception\GuzzleException::class);

        $slug = 'test_slug';
        $data = ['key' => 'value'];

        $client = new Client(['base_uri' => $this->endpoint, 'handler' => HandlerStack::create()]);

        $mailit = new Mailit($this->endpoint, $this->clientId, $this->secretKey);
        $mailit->setClient($client);

        $mailit->getParsedTemplate($slug, $data);
    }
}
