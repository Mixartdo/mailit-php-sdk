<?php

namespace MailitSDK\Tests\Integration;

use GuzzleHttp\Exception\GuzzleException;
use MailitSDK\Mailit;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../', ".env.test");
$dotenv->load();

class MailitTest extends TestCase
{
    private $clientId;
    private $endpoint;
    private $secretKey;

    public function setUp(): void
    {
        $this->clientId = $_ENV['MAILIT_CLIENT_ID'];
        $this->endpoint = $_ENV['MAILIT_ENDPOINT'];
        $this->secretKey = $_ENV['MAILIT_SECRET_KEY'];
    }

    /**
     * @throws GuzzleException
     */
    public function testGetParsedTemplate()
    {
        $slug = 'password-recovery';
        $data = ['name' => 'hello', 'company' => 'mailit'];
        $mailit = new Mailit($this->clientId, $this->secretKey, $this->endpoint);
        $responseHtml = $mailit->getParsedTemplate($slug, $data);

        $this->assertStringContainsString("hello", $responseHtml);
        $this->assertStringContainsString("mailit", $responseHtml);
        $this->assertStringContainsString("An user has signed up with the following information", $responseHtml);
    }
}
