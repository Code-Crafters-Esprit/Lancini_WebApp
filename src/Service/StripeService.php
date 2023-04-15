<?php 
namespace App\Service;

use Stripe\Charge;
use Stripe\Stripe;

class StripeService
{
    private $stripePublicKey;
    private $stripeSecretKey;

    public function __construct(string $stripePublicKey, string $stripeSecretKey)
    {
        $this->stripePublicKey = $stripePublicKey;
        $this->stripeSecretKey = $stripeSecretKey;
    }

    public function charge(int $amount, string $currency, string $token): void
    {
        Stripe::setApiKey($this->stripeSecretKey);

        Charge::create([
            'amount' => $amount,
            'currency' => $currency,
            'source' => $token,
        ]);
    }
}