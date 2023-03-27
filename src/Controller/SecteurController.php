<?php

namespace App\Controller;

use App\Entity\Secteur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


#[Route('/secteur')]
class SecteurController extends AbstractController
{
    #[Route('/', name: 'affsecteur')]
    public function secteur(ManagerRegistry $mg): Response
    {
        $secteur = $mg->getRepository(Secteur::class)->findAll();

        return $this->render('secteur/secteur.html.twig', [
            'secteurs' => $secteur,
        ]);
    }
    #[Route('/add', name: 'addSecteur')]
    public function add(): Response
    {
        return $this->render('secteur/add.html.twig', [
            'controller_name' => 'OfferController',
        ]);
    }


    #[Route('/update/{id}', name: 'update')]
    public function update($id): Response
    {
        return $this->render('secteur/update.html.twig', [
            'controller_name' => $id,
        ]);
    }


    #[Route('/details/{id}', name: 'details')]
    public function details($id): Response
    {
        return $this->render('offer/details.html.twig', [
            'controller_name' => $id,
        ]);
    }


}
