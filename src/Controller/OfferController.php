<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\OfferType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;



   #[Route('/offer')]
class OfferController extends AbstractController
{
    public function __construct(
        private OffreRepository $offreRepository,
        private EntityManagerInterface $em,
    )
    {
    }

    #[Route('/', name: 'affOffer')]
    public function affOffer(ManagerRegistry $mg): Response
    {
        $offer = $mg->getRepository(Offre::class)->findAll();
        return $this->render('offer/offer.html.twig', [
            'offers' => $offer,
        ]);
    }
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

            return $this->redirectToRoute('affOffer');
        }

        return $this->render('offer/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'OfferUpdate')]
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

                return $this->redirectToRoute('affOffer');
            }
            return $this->renderForm(
                "offer/update.html.twig",
                ["form" => $form]);
        }
    }

    #[Route('/details/{id}', name: 'offerDetails')]
    public function details(ManagerRegistry $mg, $id): Response
    {
        $offer = $mg->getRepository(Offre::class)->find($id);

        return $this->render('offer/details.html.twig',
            [
            'offer' => $offer,
            ]);
    }

    #[Route('/remove/{id}', name: 'OfferRemove')]
    public function remove($id): Response
    {
        $offer = $this->offreRepository->find($id);

        $offer->setSecteur(null);
        $offer->setProprietaire(null);
        $this->em->remove($offer);
        $this->em->flush();
        return new RedirectResponse($this->generateUrl('affOffer'));
    }

       public function Recherche(Request $request): Response
       {
           $searchForm = $this->createFormBuilder()
               ->add('nom', TextType::class, ['required' => false])
               ->getForm();

           $searchForm->handleRequest($request);

           if ($searchForm->isSubmitted() && $searchForm->isValid()) {
               $data = $searchForm->getData();
               $nom = $data['nom'];

               $offer = $this->getDoctrine()->getRepository(Offre::class)
                   ->findBy(['nom' => $nom]);
           } else {
               $offer = [];
           }

           return $this->render('search/index.html.twig', [
               'searchForm' => $searchForm->createView(),
               '$offer' => $offer,
           ]);
       }
}
