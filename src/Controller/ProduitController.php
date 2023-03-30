<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\ProduitType;



class ProduitController extends AbstractController
{
    
    #[Route('/produit', name: 'app_produit')]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
    #[Route('/addproduit', name: 'addproduit')]
    public function addproduit(Request $req,ManagerRegistry $mr): Response
    {
$Produit=new Produit();
$form=$this->createForm(ProduitType::class,$Produit);
$form->handleRequest($req);
if($form->isSubmitted()&& $form->isValid()){
$em=$mr->getManager();
$em->persist($Produit);
$em->flush();
}
        return $this->render('Produit/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
}
