<?php
namespace MailitSDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Mailit
{
    private Client $client;
    private String $clientId;
    public function __construct(String $endpoint, String $clientId, String $secretKey)
    {
        $this->clientId = $clientId;
        $this->client = new Client(
            [
                'base_uri' => $endpoint,
                'headers' => [
                    'X-Api-Key' => $secretKey
                ],
                'timeout' => 2,
            ]);
    }

    /**
     * @param mixed $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function getParsedTemplate(String $slug, array $data): String
    {
        $response = $this->client->post("", ['json' => ['data' => $data, 'url' => "$this->clientId/$slug.html"]]);
        return $response->getBody()->getContents();
    }
}