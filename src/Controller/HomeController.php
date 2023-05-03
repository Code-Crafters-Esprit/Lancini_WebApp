<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailerService;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(MailerService $mailer): Response
    {
        return $this->render('home/base.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
