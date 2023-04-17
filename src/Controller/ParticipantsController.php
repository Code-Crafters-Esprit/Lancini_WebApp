<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participants;
use App\Form\ParticipantsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


class ParticipantsController extends AbstractController
{
    #[Route('/participants', name: 'app_participants')]
    public function index(): Response
    {
        return $this->render('participants/index.html.twig', [
            'controller_name' => 'ParticipantsController',
        ]);
    }

    #[Route('/creerParticipant', name: 'creer_participant')]
    public function ajouterParticipant(ManagerRegistry $mr, Request $request): Response
    {

        $idevent = $request->query->get('event');      
        $idp=((int)$idevent);
    
        $em = $mr->getManager();
        $event = $em->getRepository(Evenement::class)->find($idp);

      #  if (!$event) {
           # throw $this->createNotFoundException('Cher Utilisateur Evenement avec l\'identifiant '.$idp.' n\'existe pas.');
         #}

        $part = new Participants;
        $part->setIdevent($event);
        $form = $this->createForm(ParticipantsType::class,$part);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($part);
            $em->flush();
    
            return $this->redirectToRoute('affichage');
        }
    
        return $this->render('participants\ajouterParticipant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/afficherParticipant', name: 'affichagePrticipant')]
    public function afficherParticipant(ManagerRegistry $doctrine): Response
    {

        $repository=$doctrine->getRepository(Participants::class);
            $comm=$repository->findAll() ;


        return $this->render('commentaire\affichageCommentaire.html.twig', [
            'comm' => $comm,
        ]);
    }


}
