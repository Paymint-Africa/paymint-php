<?php
namespace PayMint\Resources;

use GuzzleHttp\Client;

class VirtualAccount 
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $payload): array
    {
        $response = $this->client->post('virtual-accounts', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
