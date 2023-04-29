<?php

namespace App\Controller;
use App\Entity\Postulation;
use App\Repository\OffreRepository;
use App\Repository\PostulationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;



#[Route('/postulation')]
class PostulationController extends AbstractController
{

    public function __construct(
        private PostulationRepository $postRepository,
        private EntityManagerInterface $em,
    )
    {
    }
    #[Route('/', name: 'affPostulation')]
    public function affPostulation(ManagerRegistry $mg): Response
    {
        $post = $mg->getRepository(Postulation::class)->findAll();
        return $this->render('postulation/post.html.twig', [
            'posts' => $post,
        ]);
    }

    #[Route('/remove/{id}', name: 'PostRemove')]
    public function remove($id): Response
    {
        $post = $this->postRepository->find($id);

        $post->setIdoffre(null);
        $post->setIduser(null);
        $this->em->remove($post);
        $this->em->flush();
        return new RedirectResponse($this->generateUrl('affPostulation'));
    }
}
