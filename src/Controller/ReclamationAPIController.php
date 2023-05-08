<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ReclamationAPIController extends AbstractController
{
    #[Route('/reclamation/api/get', name: 'app_reclamation_api_get', methods: ['GET','POST'])]
    public function getAll(): Response
    {
        return $this->render('reclamation_api/index.html.twig', [
            'controller_name' => 'ReclamationAPIController',
        ]);
    }
    #[Route("/AllReclamations", name: "app_rec" , methods :['GET','POST'])]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function index(ReclamationRepository $repo, SerializerInterface $serializer)
    {
        $reclamations = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);

        $json = $serializer->serialize($reclamations, 'json', ['groups' => "reclamations"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
    #[Route("/Reclamation/{id}", name: "Reclamation")]
    public function ReclamationId($id, NormalizerInterface $normalizer, StudentRepository $repo)
    {
        $reclamtion = $repo->find($id);
        $reclamationNormalises = $normalizer->normalize($reclamtion, 'json', ['groups' => "reclamations"]);
        return new Response(json_encode($reclamationNormalises));
    }

    #[Route("/addReclamationJSON/new", name: "addReclamationJSON" , methods :['GET','POST'])]
    public function addReclamationJSON(Request $req, ReclamationRepository $reclamationRepository,  NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $reclamation = new Reclamation();
        $reclamation->setNom($req->get('nom'));
        $reclamation->setPrenom($req->get('prenom'));
        $reclamation->setDescription($req->get('description'));
        $reclamation->setSujetdereclamations($req->get('sujetdereclamations'));
        $reclamation->setEmail($req->get('email'));
        $reclamation->setTel($req->get('tel'));
        $reclamation->setEtat($req->get('etat'));
        $em->persist($reclamation);
        $em->flush();

        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => 'reclamations']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("updateReclamationJSON/{id}", name: "updateReclamationJSON")]
    public function updateReclamationJSON(Request $req, $id, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Student::class)->find($id);
        $reclamation->setNom($req->get('nom'));
        $reclamation->setPrenom($req->get('prenom'));
        $reclamation->setDescription($req->get('description'));
        $reclamation->setSujetdereclamations($req->get('sujet de reclamations'));
        $reclamation->setEmail($req->get('email'));
        $reclamation->setTel($req->get('tel'));
        $reclamation->setEtat($req->get('etat'));

        $em->flush();

        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => 'Reclamations']);
        return new Response("Reclamation updated successfully " . json_encode($jsonContent));
    }

    #[Route("deleteReclamationJSON/{id}", name: "deleteReclamationJSON")]
    public function deleteDeleteJSON(Request $req, $id, Reclamation $reclamation, ReclamationRepository $reclamationRepository,NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $reclamation = $em->getRepository(Student::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        $jsonContent = $Normalizer->normalize($reclamation, 'json', ['groups' => 'reclamatios']);
        return new Response("Recalamtion deleted successfully " . json_encode($jsonContent));
    }



}
