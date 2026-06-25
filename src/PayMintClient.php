<?php
namespace PayMint;

use GuzzleHttp\Client;
use PayMint\Resources\VirtualAccount;
use PayMint\Resources\Webhook;

class PayMintClient 
{
    protected Client $client;
    protected string $secretKey;
    
    public VirtualAccount $virtualAccounts;
    public Webhook $webhooks;

    public function __construct(string $secretKey, string $baseUrl = 'https://api.paymint.africa/v1/')
    {
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $secretKey,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
            // 'http_errors' => false // You can handle exceptions manually if you prefer
        ]);
        $this->secretKey = $secretKey;
        $this->virtualAccounts = new VirtualAccount($this->client);
        $this->webhooks = new Webhook($this->secretKey);
    }

    public function virtualAccounts(): VirtualAccount
    {
        return $this->virtualAccounts;
    }

    public function webhooks(): Webhook
    {
        return $this->webhooks;
    }
}
