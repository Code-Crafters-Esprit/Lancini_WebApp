<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
  
    #[Route('/afficherCommentaire', name: 'affichageCommentaire')]
    public function afficher(ManagerRegistry $doctrine): Response
    {

        $repository=$doctrine->getRepository(Commentaire::class);
            $comm=$repository->findAll() ;


        return $this->render('commentaire\affichageCommentaire.html.twig', [
            'comm' => $comm,
        ]);
    }

    #[Route('/afficherCommById/{id}', name: 'affichageCommentaireByPub')]
    public function ListByPub(CommentaireRepository $repo , $id)
    {
          
        $Commentaire=$repo->ListCommentaireByPub($id) ;
    


        return $this->render('commentaire\affichageCommentaire.html.twig', [
            'comm' => $Commentaire,
        ]);
    }

    





}
