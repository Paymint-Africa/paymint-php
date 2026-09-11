# PayMint Africa PHP SDK

The official PHP SDK for PayMint Africa. This SDK allows you to easily integrate PayMint's powerful checkout, virtual accounts, and secure webhooks into any core PHP application.

## Installation

Install the package via Composer:

```bash
composer require paymint/paymint-php
```

## Requirements

- PHP 8.1 or higher
- Composer

## Usage

Initialize the `PayMintClient` with your PayMint Secret Key.

```php
require 'vendor/autoload.php';

use PayMint\PayMintClient;

$paymint = new PayMintClient('sec_live_your_secret_key');
```

### 1. Hosted Checkout (Accept Payments)

Accept payments with PayMint's hosted checkout experience:

```php
// Initialize Checkout
$checkout = $paymint->checkout()->initialize([
    'amount'       => 5000,
    'email'        => 'customer@example.com',
    'reference'    => 'ORDER_12345', // Optional unique reference
    'redirect_url' => 'https://mywebsite.com/payment/callback',
    'name'         => 'John Doe',     // Optional
    'phone'        => '08012345678', // Optional
]);

// Redirect customer to the payment page
header('Location: ' . $checkout['data']['authorization_url']);
exit;

// Verify Payment upon return
$payment = $paymint->checkout()->verify('ORDER_12345');

if ($payment['data']['status'] === 'successful') {
    // Transaction is verified! Give value to customer
}
```

### 2. Dedicated Virtual Accounts

Create dynamic or dedicated virtual accounts:

```php
$response = $paymint->virtualAccounts()->create([
    'name'  => 'John Doe',
    'email' => 'john@example.com',
    'phone' => '08012345678',
    'bvn'   => '12345678901' // Optional
]);

print_r($response);
```

### 3. Webhook Signature Verification

When receiving webhooks, verify the signature to ensure the request came from PayMint:

```php
$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_PAYMINT_SIGNATURE'] ?? '';

if (!$paymint->webhooks()->verifySignature($payload, $signature)) {
    http_response_code(401);
    die('Invalid signature detected.');
}

// Process webhook safely!
echo "Webhook verified successfully!";
```

## License
MIT License
