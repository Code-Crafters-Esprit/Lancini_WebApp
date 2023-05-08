<?php

namespace App\Controller;

use App\Entity\Offre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    #[Route('/SupprimerOffre/{id}', name: 'SupprimerOffre')]
    public function SupprimerSecteur(Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository(Offre::class)->find($id);

        if (!$offre) {
            throw $this->createNotFoundException('offre non trouvé.');
        }

        $em->remove($offre);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize("L'offre a été supprimé avec succès.");
        return new JsonResponse($formated);
    }
}
