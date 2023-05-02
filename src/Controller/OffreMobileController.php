<?php

namespace App\Controller;

use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class OffreMobileController extends AbstractController
{
    #[Route('/getOffre', name: 'getOffre')]
    public function getOffre(EntityManagerInterface $entityManager): JsonResponse
    {
        $offreRepository = $entityManager->getRepository(Offre::class);
        $offres = $offreRepository->findAll();
        $offresArray = [];
        foreach ($offres as $offre) {
            $offre->setDatefin(new \DateTime());
            $offre->setDatedebut(new \DateTime());
            $offresArray[] = [
                'idoffre' => $offre->getIdOffre(),
                'nom' => $offre->getNom(),
                'description' => $offre->getDescription(),
                'datedebut' => $offre->getDatedebut(),
                'datefin' => $offre->getDatefin(),
                'competence' => $offre->getCompetence(),
                'typeoffre' => $offre->getTypeoffre(),
              //  'secteur' => $offre->getSecteur(),
               // 'proprietaire' => $offre->getProprietaire(),
            ];
        }
        return $this->json($offresArray);
    }
}



