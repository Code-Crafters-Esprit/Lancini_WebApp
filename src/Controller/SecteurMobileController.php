<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Secteur;
use App\Controller\EntityManager;
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
            $secteur->setDatemodification(new \DateTime()); // Set the modification date to the current time

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
/**
     * @Route("/newSecteur/{nom}/{description}/{DateCreation}/{DateModification}/}", name="newSecteur_mobile",
      *methods={"POST"}
     */
    public function newSecteur($nom,$description,$DateCreation,$DateModification,NormalizerInterface  $normalizer )
    {

        $secteur = new Sinstre();
        $secteur->setNom($nom);
        $secteur->setDescription($description);
        $secteur->setDatecreation($DateCreation);
        $secteur->setDatemodification($DateModification);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($secteur);
        $entityManager->flush();
        $json = $normalizer->normalize($secteur, "json", ['groups' => ['post:read']]);
        return new JsonResponse($json);

    }

    /**
@Route("/addSecteurM", name="addSecteurM")

@Method("POST")
     * */

    public function ajouterSecteur ($nom,$description,$DateCreation,$DateModification ,Request $request , EntityManagerInterface $entityManager)
    {
        $secteur = new Secteur();
        $description = $request->query->get("description");
        $entityManager = $this->getDoctrine()->getManager();

        $secteur->setNom($nom);
        $secteur->setDescription($description);
        $secteur->setDatecreation($DateCreation);
        $secteur->setDatemodification($DateModification);

        $entityManager->persist($secteur);
        $entityManager->Flush();
        $serializer = new Serializer ([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($secteur );
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/SupprimerSecteur", name="SupprimerSecteur", methods={"DELETE"})
     */
    public function SupprimerSecteur(Request $request)
    {
        $idSecteur = $request->get("idSecteur");
        $em = $this->getDoctrine()->getManager();
        $secteur = $em->getRepository(Secteur::class)->find($idSecteur);

        if($secteur != null)
        {
            $secteur->setOffre(null);
            $em->remove($secteur);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formated = $serializer->normalize("secteur ete supprimer avec succées ");
            return new JsonResponse($formated);
        }

    }

    /**
     * @Route("/updateSecteur", name="updateSecteur")
     */
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
