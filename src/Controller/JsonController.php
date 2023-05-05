<?php
namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JsonController extends AbstractController
{
    #[Route('/jsonEvenement', name: 'jsonEvenement')]
    public function index(EntityManagerInterface $entitymanager): JsonResponse
    {
        // Récupérer tous les événements en utilisant le repository
        $evenementRepository = $entitymanager->getRepository(Evenement::class);
        $evenements = $evenementRepository->findAll();

        // Convertir les événements en tableau associatif
        $evenementsArray = [];
        foreach ($evenements as $evenement) {
           
            $evenementsArray[] = [
                'id' => $evenement->getIdevent(),
                'titre' => $evenement->getTitre(),
                'sujet' => $evenement->getSujet(),
                'lieu' => $evenement->getLieu(),
                'horaire' => $evenement->getHoraire(),
                'date' => $evenement->getDateevent(),
                'proprietaire' => $evenement->getProprietaire()->getIdUser()
            ];
        }

        // Retourner les événements au format JSON
        return $this->json($evenementsArray);
    }


    #[Route('/api/ajoutEvenement', name: 'evenement_json_create')]
    public function create(Request $request, EntityManagerInterface $entityManager,NormalizerInterface $normalizer): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager() ;
        $evenement = new Evenement();
        $evenement->setTitre($request->get('titre'));
        $evenement->setSujet($request->get('sujet'));
        $evenement->setDateevent(new \DateTime($request->get('date')));
        $evenement->setLieu($request->get('lieu'));
        $evenement->setHoraire($request->get('horaire'));

       // $proprietaire = $this->getDoctrine()
      //   ->getRepository(User::class)
    // ->find($request->request->get('idUser'));

        $proprietaire = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($request->get('proprietaire'));
            $evenement->setProprietaire($proprietaire);
        $entityManager->persist($evenement);
        $entityManager->flush();

        return $this->json([          
            'id' => $evenement->getIdevent(),
            'titre' => $evenement->getTitre(),
            'sujet' => $evenement->getSujet(),
            'date' => $evenement->getDateevent(),
            'lieu' => $evenement->getLieu(),
            'horaire' => $evenement->getHoraire(),
            'proprietaire' => $evenement->getProprietaire()->getIdUser()
          
        ]);
    }

    #[Route('/api/delete/evenement/{id}', name: 'evenement_json_delete')]
    public function delete($id): JsonResponse
    {   $em = $this->getDoctrine()->getManager() ;
        $evenement = $em->getRepository(Evenement::class)->find($id) ;
        $em->remove($evenement);
        $em->flush();

        return $this->json(['message' => 'L evenement a été supprimée avec succès.']);
    }
}
