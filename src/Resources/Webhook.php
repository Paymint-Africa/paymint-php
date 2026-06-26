<?php
namespace PayMint\Resources;

class Webhook
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Verifies the payload signature to ensure the webhook was sent by PayMint.
     *
     * @param string $payload The raw JSON payload from the request body.
     * @param string $signature The signature from the X-Paymint-Signature header.
     * @return bool True if valid, false otherwise.
     */
    public function verifySignature(string $payload, string $signature): bool
    {
        if (empty($signature) || empty($payload)) {
            return false;
        }

        $expectedSignature = hash_hmac('sha512', $payload, $this->secretKey);

        // Use hash_equals to prevent timing attacks
        return hash_equals($expectedSignature, $signature);
    }
}
