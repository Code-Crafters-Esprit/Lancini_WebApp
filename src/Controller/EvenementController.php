<?php

namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    #[Route('/afficherEvenement', name: 'affichage')]
    public function afficher(ManagerRegistry $doctrine): Response
    {

        $repository=$doctrine->getRepository(Evenement::class);
            $event=$repository->findAll() ;


        return $this->render('home/affichageEvenement.html.twig', [
            'event' => $event,
        ]);
    }

}
