<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/pay", name="pay")
     */
    public function pay(Request $request, StripeService $stripeService)
    {
        $amount = $request->request->get('amount');
        $token = $request->request->get('stripeToken');

        $stripeService->charge($amount, 'usd', $token);

        return $this->redirectToRoute('success');
    }

    /**
     * @Route("/success", name="success")
     */
    public function success()
    {
        return $this->render('stripe/success.html.twig');
    }
}