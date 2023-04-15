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
    public function createCheckoutSession($amount, $currency)
{
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => $currency,
                'product_data' => [
                    'name' => 'My Product',
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
       
    ]);

    return $session->id;
}

}