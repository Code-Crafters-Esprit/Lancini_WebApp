<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\Produit1Type;
use App\Repository\ProduitRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    } 
  #[Route('/market', name: 'app_market_index', methods: ['GET'])]
    public function list(ProduitRepository $produitRepository): Response
    {
        return $this->render('LanciniMarket/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    } 
   #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $timezone = $this->getParameter('timezone');

        $produit->setDate(new DateTime('now', new \DateTimeZone($timezone)));
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/products',
                        $fileName
                    );

                    $produit->setImage($fileName);
                } catch (FileException $e) {
                    // Handle exception
                }
            }

            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idproduit}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{idproduit}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/products',
                        $fileName
                    );

                    $produit->setImage($fileName);
                } catch (FileException $e) {
                    // Handle exception
                }
            }

            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

#[Route('/{idproduit}', name: 'app_produit_delete', methods: ['POST'])]
public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$produit->getIdproduit(), $request->request->get('_token'))) {
        // Check if the image is null and set it to a default image if it is
        if ($produit->getImage() === null) {
            $produit->setImage('default_image.png');
        }
        $produitRepository->remove($produit, true);
    }

    return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
}
    

}