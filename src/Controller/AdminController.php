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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Entity\Avis;
use App\Form\Avis1Type;
use App\Repository\AvisRepository;

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
  
    #[Route('/newrecadmin', name: 'app_reclamation_admin', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_recadd', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/reclamationadmin/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    

    #[Route('/showlist', name: 'app_reclamation_recadd', methods: ['GET'])]
    public function admin(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('admin/reclamationadmin/show.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    #[Route('adminedit/{id}/edit', name: 'app_reclamation_editadmin', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/reclamationadmin/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    #[Route('deleteadmin/{id}', name: 'app_reclamation_deleteadmin', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_show', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/indexavis', name: 'app_avis_admin', methods: ['GET'])]
    public function indexx(AvisRepository $avisRepository): Response
    {
        return $this->render('admin/avisadmin/index.html.twig', [
            'avis' => $avisRepository->findAll(),
        ]);
    }

    #[Route('/newavis', name: 'app_avis_new', methods: ['GET', 'POST'])]
    public function newfeedback(Request $request, AvisRepository $avisRepository): Response
    {
        $avi = new Avis();
        $form = $this->createForm(Avis1Type::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avisRepository->save($avi, true);

            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/avisadmin/new.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('showavis/{id}', name: 'app_avis_show', methods: ['GET'])]
    public function show(Avis $avi): Response
    {
        return $this->render('admin/avisadmin/show.html.twig', [
            'avi' => $avi,
        ]);
    }
    #[Route('editavis/{id}/edit', name: 'app_avis_editavis', methods: ['GET', 'POST'])]
    public function editavis(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        $form = $this->createForm(Avis1Type::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avisRepository->save($avi, true);

            return $this->redirectToRoute('app_avis_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/avisadmin/edit.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('deleteavis/{id}', name: 'app_avis_deleteavis', methods: ['POST'])]
    public function deleteavis(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avi->getId(), $request->request->get('_token'))) {
            $avisRepository->remove($avi, true);
        }

        return $this->redirectToRoute('admin/avisadmin/delete   .html.twig', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
