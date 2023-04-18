<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationsController extends AbstractController
{
    #[Route('/publications', name: 'app_publications')]
    public function index(): Response
    {
        return $this->render('publications/index.html.twig', [
            'controller_name' => 'PublicationsController',
        ]);
    }

    #[Route('/afficherPublications', name: 'app_publications')]
    public function afficher(ManagerRegistry $doctrine): Response
    {

        $repository=$doctrine->getRepository(Publication::class);
            $pub=$repository->findAll() ;
        $user = $this->getUser();


        return $this->render('publications/affichagePublications.html.twig',  [
            'pub' => $pub,
        ]);
    }
    public function ajouterCommentaire()
    {


    }

    #[Route('/afficherPublicationsAdmin', name: 'app_publicationsAdmin')]
    public function afficherAdmin(ManagerRegistry $doctrine): Response
    {

        $repository=$doctrine->getRepository(Publication::class);
            $pub=$repository->findAll() ;


        return $this->render('admin\adminPublication\PublicationAdmin.html.twig',  [
            'pub' => $pub,
        ]);
    }

    #[Route('/creerPublication', name: 'creer_publications')]
public function ajouter(ManagerRegistry $mr, Request $request): Response
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


#[Route('/supprimerPublication/{idpub}', name: 'supprimerPublication')]
        public function supprimerPublication($idpub, ManagerRegistry $doctrine): Response
        {
            //Trouver publication
            $repo = $doctrine->getRepository(Publication::class);
            $publication= $repo->find($idpub);
            //Utiliser Manager pour supprimer le classroom trouvé
            $em= $doctrine->getManager();
            $em->remove($publication);
            $em->flush();
            return $this->redirectToRoute('app_publicationsAdmin');
        }


        #[Route('/modifierPublication', name: 'modifierPublication')]
        public function modifierPublication(ManagerRegistry $doctrine , Request $request)
        {


            $idpub = $request->query->get('pub');      
            $idp=((int)$idpub);

            $publication= $doctrine  -> getRepository(Publication::class)-> find($idp) ;
            $form = $this->createForm(PublicationType::class, $publication);
            $form->handleRequest($request);
            
            if ($form->isSubmitted()) {
                $em = $doctrine ->getManager();
                //$em->persist($publication);
                $em->flush();
                return $this->redirectToRoute('app_publicationsAdmin'); 
            }
            return $this->render('admin\adminPublication\modifierPublicationAdmin.html.twig', [
                'form' => $form->createView(),
            ]);
        }





    }

