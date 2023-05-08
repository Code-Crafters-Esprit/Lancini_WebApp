<?php

namespace App\Controller;

use ApiPlatform\Metadata\Delete;
use FontLib\Table\Type\post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Secteur;
use Doctrine\ORM\EntityManagerInterface;





class SecteurMobileController extends AbstractController
{
    #[Route('/mobileSecteur', name: 'mobileSecteur')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $secteurRepository = $entityManager->getRepository(Secteur::class);
        $secteurs = $secteurRepository->findAll();

        $secteursArray = [];
        foreach ($secteurs as $secteur) {
            $secteur->setDatemodification(new \DateTime());

            $secteursArray[] = [
                'idsecteur' => $secteur->getIdsecteur(),
                'nom' => $secteur->getNom(),
                'description' => $secteur->getDescription(),
                'datecreation' => $secteur->getDatecreation(),
                'datemodification' => $secteur->getDatemodification(),
            ];
        }

        return $this->json($secteursArray);
    }

    #[Route('/addSecteurM', name: 'addSecteurM',methods: ['POST'])]
    public function ajouterSecteur(Request $request)
    {
        $nom = $request->query->get('nom');
        $description = $request->query->get('description');
        $dateCreation = new \DateTime($request->query->get('date_creation'));

        $secteur = new Secteur();
        $secteur->setNom($nom);
        $secteur->setDescription($description);
        $secteur->setDatecreation($dateCreation);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($secteur);
        $entityManager->flush();

        return new JsonResponse([
            'idsecteur' => $secteur->getIdsecteur(),
            'nom' => $secteur->getNom(),
            'description' => $secteur->getDescription(),
            'datecreation' => $secteur->getDatecreation()->format('Y-m-d'),
        ]);
    }


    #[Route('/SupprimerSecteur/{id}', name: 'SupprimerSecteur')]
    public function SupprimerSecteur(Request $request, $id, NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $secteur = $em->getRepository(Secteur::class)->find($id);

        if (!$secteur) {
            throw $this->createNotFoundException('Secteur non trouvé.');
        }

        $em->remove($secteur);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated = $serializer->normalize("Le secteur a été supprimé avec succès.");
        return new JsonResponse($formated);
    }


    #[Route('/updateSecteur', name: 'updateSecteur')]
    public function updateSecteur(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $secteur = $this->getDoctrine()->getManager()->getRepository(Secteur::class)->find($request->get("id"));


        $secteur->setNom($request->get("nom"));
        $secteur->setDescription($request->get("description"));
        $secteur->setDatecreation($request->get("DateCreation"));
        $secteur->setDatemodification($request->get("DateModification"));

        $em->persist($secteur);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($secteur);
        return new JsonResponse("Secteur a ete modifiee avec success.");

    }
}