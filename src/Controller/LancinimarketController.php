<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LancinimarketController extends AbstractController
{
    #[Route('/lancinimarket', name: 'app_lancinimarket')]
    public function index(): Response
    {
        return $this->render('lancinimarket/index.html.twig', [
            'controller_name' => 'LancinimarketController',
        ]);
    }
    
}
