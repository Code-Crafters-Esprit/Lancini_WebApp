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


class SecteurMobileController extends AbstractController
{
    #[Route('/mobileSecteur', name: 'app_mobile_secteur' , methods:'GET'  )]
    public function Secteuremobile( NormalizerInterface  $normalizer)
    {
        $secteur = $this->getDoctrine()->getRepository(Secteur::class)->findAll();
        $json = $normalizer->normalize($secteur, "json");
        dd($json);
       // $json = json_encode($secteur);
        return new JsonResponse($json);
    }
    /**
     * @Route("/newSecteur_mobile/{nom}/{description}/{DateCreation}/{DateModification}/}", name="newSecteur_mobile", methods={"GET","POST"})
     */
    public function newSecteur($nom,$description,$DateCreation,$DateModification,NormalizerInterface  $normalizer )
    {

        $secteur = new Sinstre();
        $secteur->setFirstname($nom);
        $secteur->setLastname($description);
        $secteur->setEmail($DateCreation);
        $secteur->setDate($DateModification);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($secteur);
        $entityManager->flush();
        $json = $normalizer->normalize($secteur, "json", ['groups' => ['post:read']]);
        return new JsonResponse($json);

    }

    /**
     * @Route("/SupprimerSecteur", name="SupprimerSecteur")
     */
    public function SupprimerSecteur(Request $request)
    {

        $idSecteur = $request->get("idSecteur");
        $em = $this->getDoctrine()->getManager();
        $secteur = $em->getRepository(Secteur::class)->find($idSecteur);
        if($secteur != null)
        {
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
