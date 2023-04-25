<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Postulation;
use App\Entity\Secteur;
use App\Form\OfferType;
use App\Form\SecteurType;
use App\Repository\OffreRepository;
use App\Repository\PostulationRepository;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController

{
    public function __construct(
        private OffreRepository $offreRepository,
        private SecteurRepository $secteurRepository,
        private PostulationRepository $postRepository,
        private EntityManagerInterface $em,
    )
    {
    }

    #[Route('/offerList', name: 'app_admin_offerList')]
    public function affOffer(ManagerRegistry $mg): Response
    {
        $offer = $mg->getRepository(Offre::class)->findAll();
        return $this->render('admin/offerAdmin/offerList.html.twig', [
            'offers' => $offer,
        ]);
    }

    #[Route('/addOffer', name: 'app_admin_addOffer')]
    #[Route('/add', name: 'addOffer')]
    public function add(ManagerRegistry $mr, Request $request): Response
    {
        $offer = new Offre();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($offer);
            $em->flush();

            return $this->redirectToRoute('app_admin_offerList');
        }

        return $this->render('admin/offerAdmin/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/updateOffer/{id}', name: 'app_admin_updateOffer')]
    public function update(ManagerRegistry $doctrine,$id,  Request  $request): Response
    {
        {
            $offer = $doctrine
                ->getRepository(Offre::class)
                ->find($id);
            $form = $this->createForm(OfferType::class, $offer);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $em = $doctrine->getManager();
                $em->flush();

                return $this->redirectToRoute('app_admin_offerList');
            }
            return $this->renderForm(
                "admin/offerAdmin/update.html.twig",
                ["form" => $form]);
        }
    }

    #[Route('/detailsOffer/{id}', name: 'app_admin_detailsOffer')]
    public function details(ManagerRegistry $mg, $id): Response
    {
        $offer = $mg->getRepository(Offre::class)->find($id);

        return $this->render('admin/offerAdmin/details.html.twig',
            [
                'offer' => $offer,
            ]);
    }

    #[Route('/removeOffer/{id}', name: 'app_admin_removeOffer')]
    public function remove($id): Response
    {
        $offer = $this->offreRepository->find($id);

        $offer->setSecteur(null);
        $offer->setProprietaire(null);
        $this->em->remove($offer);
        $this->em->flush();
        return new RedirectResponse($this->generateUrl('app_admin_offerList'));
    }

    #[Route('/secteurList', name: 'app_admin_secteurList')]
    public function secteur(ManagerRegistry $mg): Response
    {
    $secteur = $mg->getRepository(Secteur::class)->findAll();

    return $this->render('admin/secteurAdmin/secteurList.html.twig', [
        'secteurs' => $secteur,
    ]);
    }


    #[Route('/addSecteur', name: 'app_admin_addsecteur')]
    public function addSecteur(ManagerRegistry $mr, Request $request): Response
    {
        $secteur = new Secteur();
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($secteur);
            $em->flush();

            return $this->redirectToRoute('app_admin_secteurList');
        }
        return $this->render('admin/secteurAdmin/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/updateSecteur/{id}', name: 'app_admin_updatesecteur')]
    public function updateSecteur(ManagerRegistry $doctrine,$id,  Request  $request): Response
    {$secteur = $doctrine
        ->getRepository(Secteur::class)
        ->find($id);
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_admin_secteurList');
        }
        return $this->renderForm("admin/secteurAdmin/update.html.twig",
            ["f"=>$form]) ;
    }

    #[Route('/remove/{id}', name: 'app_admin_removesecteur')]
    public function removeSecteur($id): Response
    {
        $secteur = $this->secteurRepository->find($id);
        $this->em->remove($secteur);
        $this->em->flush();
        return new RedirectResponse($this->generateUrl('app_admin_secteurList'));
    }


    #[Route('/postList', name: 'app_admin_postList')]
    public function affPostulation(ManagerRegistry $mg): Response
    {
        $post = $mg->getRepository(Postulation::class)->findAll();
        return $this->render('admin/postAdmin/postList.html.twig', [
            'posts' => $post,
        ]);
    }

    #[Route('/remove/{id}', name: 'app_admin_removepost')]
    public function removepost($id): Response
    {
        $post = $this->postRepository->find($id);

        $post->setIdoffre(null);
        $post->setIduser(null);
        $this->em->remove($post);
        $this->em->flush();
        return new RedirectResponse($this->generateUrl('app_admin_postList'));
    }
}
