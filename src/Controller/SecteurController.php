<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Form\SecteurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SecteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;



#[Route('/secteur')]
class SecteurController extends AbstractController
{
    public function __construct(
        private SecteurRepository $secteurRepository,
        private EntityManagerInterface $em,
    )
    {
    }

    #[Route('/', name: 'affsecteur')]
    public function secteur(ManagerRegistry $mg): Response
    {
        $secteur = $mg->getRepository(Secteur::class)->findAll();

        return $this->render('secteur/secteur.html.twig', [
            'secteurs' => $secteur,
        ]);
    }
    #[Route('/add', name: 'addSecteur')]
    public function add(ManagerRegistry $mr, Request $request): Response
    {
        $secteur = new Secteur();
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($secteur);
            $em->flush();

            return $this->redirectToRoute('addOffer');
        }
        return $this->render('secteur/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/update/{id}', name: 'update')]
    public function update(ManagerRegistry $doctrine,$id,  Request  $request): Response
       {$secteur = $doctrine
        ->getRepository(Secteur::class)
        ->find($id);
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        { $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('affsecteur');
        }
        return $this->renderForm("secteur/update.html.twig",
            ["f"=>$form]) ;
    }


    #[Route('/details/{id}', name: 'details')]
    public function details($id): Response
    {
        return $this->render('offer/details.html.twig', [
            'controller_name' => $id,
        ]);
    }

    #[Route('/remove/{id}', name: 'SecteurRemove')]
    public function remove($id): Response
    {
        $secteur = $this->secteurRepository->find($id);
        $this->em->remove($secteur);
        $this->em->flush();
        return new RedirectResponse($this->generateUrl('affsecteur'));
    }
}
