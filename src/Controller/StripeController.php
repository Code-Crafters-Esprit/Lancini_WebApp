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
    
        // create a Stripe Checkout Session and get the session ID
        $sessionId = $stripeService->createCheckoutSession($amount, 'usd');
    
        return $this->render('stripe/pay.html.twig', [
            'stripePublicKey' => 'pk_test_51Mw8MbH5U7t3MAmZHZDecnuVq8RUQPaVysHyP8OaDAEdQCRVGvPIFMtpIQ4v3ZcFbSSCuSQ8MMpNMSCjH2L3YkBS00jKd2WOxi',
            'sessionId' => $sessionId,
            'amount' => $amount,
            'stripeToken' => $token,
        ]);
    }

    #[Route('/success', name: 'success')]

    public function success()
    {
        return $this->render('stripe/success.html.twig');
    }
    
}
