<?php 
namespace App\Service;

use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeService
{
    private $stripePublicKey;
    private $stripeSecretKey;
    private $urlGenerator;

    public function __construct(string $stripePublicKey, string $stripeSecretKey,UrlGeneratorInterface $urlGenerator )
    {
        $this->stripePublicKey = $stripePublicKey;
        $this->stripeSecretKey = $stripeSecretKey;
        $this->urlGenerator = $urlGenerator;


        // Set the Stripe API key
        Stripe::setApiKey($stripeSecretKey);
    }

    public function createCheckoutSession($amount, $currency, $successUrl, $cancelUrl)
    {
        // Convert the amount to cents
        $amountInCents = floatval($amount) * 100;
        
        // Create a new Checkout Session using the Stripe API
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => $amountInCents, // Stripe requires the amount to be in cents
                    'product_data' => [
                        'name' => 'Product Name', // Replace with your product name
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    
        // Return the ID of the Checkout Session
        return $session->id;
    }
    
}