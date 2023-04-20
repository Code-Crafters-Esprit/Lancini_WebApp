<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;


class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        return $this->render('stripe/pay.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
    #[Route('/pay/{idproduit}', name: 'pay')]
    public function pay(Request $request, StripeService $stripeService, $idproduit)
    {
    // Retrieve the product from the database using the ID
    $entityManager = $this->getDoctrine()->getManager();
    $produit = $entityManager->getRepository(Produit::class)->find($idproduit);
    
    if (!$produit) {
    throw $this->createNotFoundException('The product does not exist');
    }
    
    $amount = $produit->getPrix() * 100; // Convert the price to cents
    $successUrl = 'https://example.com/success';
    $cancelUrl = 'https://example.com/cancel';
    
    // create a Stripe Checkout Session and get the session ID
    $sessionId = $stripeService->createCheckoutSession($amount, 'eur', $successUrl, $cancelUrl, $produit->getNom());
    
    return $this->render('stripe/pay.html.twig', [
    'stripePublicKey' => 'pk_test_51Mw8MbH5U7t3MAmZHZDecnuVq8RUQPaVysHyP8OaDAEdQCRVGvPIFMtpIQ4v3ZcFbSSCuSQ8MMpNMSCjH2L3YkBS00jKd2WOxi', // Replace with your Stripe public key
    'sessionId' => $sessionId,
        'produit' => $produit,
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
