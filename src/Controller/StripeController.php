<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        return $this->render('stripe/pay.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
    #[Route('/pay', name: 'pay')]
    public function pay(Request $request, StripeService $stripeService)
{   
    $amount = $request->request->get('amount');
    $token = $request->request->get('stripeToken');
    $successUrl ='https://example.com/success'; // Replace 'success' with your success route name
    $cancelUrl = 'https://example.com/cancel'; // Replace 'cancel' with your cancel route name

    // create a Stripe Checkout Session and get the session ID
    $sessionId = $stripeService->createCheckoutSession(100, 'usd', $successUrl, $cancelUrl);

    return $this->render('stripe/pay.html.twig', [
        'stripePublicKey' => 'pk_test_51Mw8MbH5U7t3MAmZHZDecnuVq8RUQPaVysHyP8OaDAEdQCRVGvPIFMtpIQ4v3ZcFbSSCuSQ8MMpNMSCjH2L3YkBS00jKd2WOxi',
        'sessionId' => $sessionId,
        'amount' => 100,
        'stripeToken' => $token,
    ]);
}

    #[Route('/success', name: 'success')]

    public function success()
    {
        return $this->render('stripe/success.html.twig');
    }
    #[Route('/cancel', name: 'cancel')]

    public function cancel()
    {
        return $this->render('stripe/cancel.html.twig');
    }
    
}
