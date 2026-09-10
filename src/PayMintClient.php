<?php
namespace PayMint;

use GuzzleHttp\Client;
use PayMint\Resources\VirtualAccount;
use PayMint\Resources\Webhook;
use PayMint\Resources\Checkout;

class PayMintClient 
{
    protected Client $client;
    protected string $secretKey;
    
    public VirtualAccount $virtualAccounts;
    public Webhook $webhooks;
    public Checkout $checkout;

    public function __construct(string $secretKey, string $baseUrl = 'https://api.paymint.africa/v1/')
    {
        $this->client = new Client([
            'base_uri'    => $baseUrl,
            'http_errors' => false,
            'headers'     => [
                'Authorization' => 'Bearer ' . $secretKey,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
        ]);
        $this->secretKey = $secretKey;
        $this->virtualAccounts = new VirtualAccount($this->client);
        $this->webhooks = new Webhook($this->secretKey);
        $this->checkout = new Checkout($this->client);
    }

    public function virtualAccounts(): VirtualAccount
    {
        return $this->virtualAccounts;
    }

    public function webhooks(): Webhook
    {
        return $this->webhooks;
    }

    public function checkout(): Checkout
    {
        return $this->checkout;
    }
}
