<?php
namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}
