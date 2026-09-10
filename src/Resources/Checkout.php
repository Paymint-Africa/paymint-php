<?php
namespace PayMint\Resources;

use GuzzleHttp\Client;

class Checkout 
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Initialize a checkout session
     *
     * @param array $payload [amount, email, redirect_url, reference, name, phone]
     * @return array
     */
    public function initialize(array $payload): array
    {
        $response = $this->client->post('checkout/initialize', [
            'json' => $payload
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Verify a checkout transaction by its reference
     *
     * @param string $reference
     * @return array
     */
    public function verify(string $reference): array
    {
        $response = $this->client->get('checkout/verify/' . urlencode($reference));

        return json_decode($response->getBody()->getContents(), true);
    }
}
