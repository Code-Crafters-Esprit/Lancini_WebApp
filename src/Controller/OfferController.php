<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


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
    public function add(): Response
    {
        return $this->render('offer/add.html.twig', [
            'controller_name' => 'OfferController',
        ]);
    }


    #[Route('/update/{id}', name: 'OfferUpdate')]
    public function update($id): Response
    {
        return $this->render('offer/update.html.twig', [
            'controller_name' => $id,
        ]);
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
}
