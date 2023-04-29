<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Repository\CommentaireRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/afficherCommById', name: 'affichageCommentaireByPub')]
    public function ListByPub(CommentaireRepository $repo, Request $request)
    {
        $idPub = $request->query->get('pub');      
        $idp=((int)$idPub);
        $Commentaire=$repo->ListCommentaireByPub($idp) ;
    


        return $this->render('commentaire\affichageCommentaire.html.twig', [
            'comm' => $Commentaire,
        ]);
    }
    
    #[Route('/creerCommentaire', name: 'comment')]
    public function ajouterS(ManagerRegistry $mr, Request $request): Response
    {
        $idPub = $request->query->get('pub');      
        $idp=((int)$idPub);
        

        $em = $mr->getManager();
        $publication = $em->getRepository(Publication::class)->find($idp);

        if (!$publication) {
            throw $this->createNotFoundException('La publication avec l\'identifiant '.$idp.' n\'existe pas.');
        }

        $comm = new Commentaire;
        $comm->setIdpub($publication);
        $form = $this->createForm(CommentaireType::class,$comm);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($comm);
            $em->flush();
    
            return $this->redirectToRoute('app_publications');
        }
    
        return $this->render('commentaire\ajouterCommentaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    #[Route('/{id}/creerCommentaire/test', name: 'creer_commentaire')]
    public function ajouter(ManagerRegistry $mr, Request $request, $id): Response
    {

        $em = $mr->getManager();
        $publication = $em->getRepository(Publication::class)->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('La publication avec l\'identifiant '.$id.' n\'existe pas.');
        }

        $comm = new Commentaire;
        $comm->setIdpub($publication);
        $form = $this->createForm(CommentaireType::class,$comm);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($comm);
            $em->flush();
    
            return $this->redirectToRoute('affichageCommentaireByPub');
        }
    
        return $this->render('commentaire\ajouterCommentaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    


    #[Route('/creerPub', name: 'creerPub')]
    public function ajouterpub(ManagerRegistry $mr, Request $request): Response
    {
        $pub = new Publication();
        $form = $this->createForm(PublicationType::class,$pub);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($pub);
            $em->flush();
    
            return $this->redirectToRoute('app_publications');
        }
    
        return $this->render('publications/ajouterPublication.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    





}
