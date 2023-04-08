<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


        return $this->render('evenement/affichageEvenement.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/creerEvenement', name: 'creer_evenement')]
public function ajouter(ManagerRegistry $mr, Request $request): Response
{
    $event = new Evenement;
    $form = $this->createForm(EvenementType::class,$event);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $mr->getManager();
        $em->persist($event);
        $em->flush();

        return $this->redirectToRoute('affichage');
    }

    return $this->render('evenement\ajouterEvenement.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/supprimerEvenement/{idevent}', name: 'supprimerEvenement')]
        public function supprimerEvenement($idevent, ManagerRegistry $doctrine): Response
        {
            //Trouver Evenement
            $repo = $doctrine->getRepository(Publication::class);
            $evenement= $repo->find($idevent);
            //Utiliser Manager pour supprimer l'event trouvé
            $em= $doctrine->getManager();
            $em->remove($evenement);
            $em->flush();
            return $this->redirectToRoute('affichage');
        }



}
