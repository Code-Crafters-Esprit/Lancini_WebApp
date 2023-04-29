<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\Badge;
use App\Form\TestType;
use App\Form\QuizType;
use App\Form\TestAnswerType;
use App\Form\QuizAnswerType;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use App\Repository\BadgeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/', name: 'app_test_index', methods: ['GET'])]
    public function index(TestRepository $testRepository): Response
    {
        return $this->render('test/index.html.twig', [
            'tests' => $testRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_test_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        TestRepository $testRepository
    ): Response {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testRepository->save($test, true);

            return $this->redirectToRoute(
                'app_test_index',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('test/new.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}/pass', name: 'app_test_pass', methods: ['GET', 'POST'])]
    // public function pass(
    //     Request $request,
    //     TestRepository $testRepository,
    //     Test $test
    // ): Response {
    //     return $this->renderForm('test/pass.html.twig', [
    //         'test' => $test,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_test_show', methods: ['GET'])]
    public function show(Test $test): Response
    {
        return $this->render('test/show.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_test_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Test $test,
        TestRepository $testRepository
    ): Response {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testRepository->save($test, true);

            return $this->redirectToRoute(
                'app_test_index',
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('test/edit.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_test_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Test $test,
        TestRepository $testRepository
    ): Response {
        if (
            $this->isCsrfTokenValid(
                'delete' . $test->getId(),
                $request->request->get('_token')
            )
        ) {
            $testRepository->remove($test, true);
        }

        return $this->redirectToRoute(
            'app_test_index',
            [],
            Response::HTTP_SEE_OTHER
        );
    }

    /**
     * @Route("/{id}/take", name="test_take")
     */
    public function takeTest(
        Request $request,
        Test $test,
        UserRepository $userRepo,
        EntityManagerInterface $entityManager
    ): Response {
        $quizAnswers = $test->getQuizzes();

        // dd($quizAnswers);

        // create form for the test and its quizzes
        $form = $this->createForm(QuizAnswerType::class, $quizAnswers);

        $quizzes = [];
        foreach ($quizAnswers as $quizAnswer) {
            $quizzes[] = $quizAnswer;
        }

        // handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $score = 0;
            $total = count($quizzes);
            // dd($total/2);
            $results = [];

            // dd($quizzes);

            foreach ($quizAnswers as $key => $quizAnswer) {
                // dd($quizAnswer);
                $question = '';
                $answer = '';
                $correct = '';
                // dd($key);
                // dd($form->getData()[$key]->getQuestion());
                if (is_int($key)) {
                    $question = $form->getData()[intval($key)]->getQuestion();
                    // rest of the code
                    $answer = $form->getData()[
                        'answer_' . $form->getData()[intval($key)]->getId()
                    ];
                    $correct =
                        $answer ===
                        $form->getData()[intval($key)]->getReponseCorrecte();
                    // dd($correct);
                    // $score += $correct ? 1 : 0;
                    if ($correct) {
                        $score++;
                    }
                    // if($correct == $answer) {
                    $results[] = [
                        'quiz' => $quizAnswer,
                        'answer' => $answer,
                        'correct' => $correct,
                    ];
                }
                // }
                // dd($quizAnswer);
                // dd($answer);
            }

            // dd($quizAnswers);

            // dd($results);

            // dd($score/$total);

            $badge = new Badge();
            // Get the array property from the entity object
            // dd($test->getQuizzes());
            $testBadge = new Test();
            $testBadge->setNomtest($test->getNomtest());
            $testBadge->setDifficulte($test->getDifficulte());

            foreach ($quizAnswers as $key => $quizAnswer) {
                if (is_int($key)) {
                    $testBadge->addQuiz($quizAnswer);
                }
            }

            // dd($testBadge);

            if ($score / $total > 1 / 2) {
                $user = $userRepo->find(1);
                $badge->setDate(new DateTime());
                $badge->setNombadge($test->getNomtest() . ' Badge');
                $badge->setUserid($user);
                $badge->setTestid($test);

                $this->addFlash('succes', 'Your score : ' . ($score/$total) * 100 . '%');

                // dd($testBadge);

                // $entityManager->persist($testBadge);
                // $entityManager->flush();
            } else {
                $this->addFlash('danger', 'Your score : ' . ($score/$total) * 100 . '%');
            }

            return $this->render('test/result.html.twig', [
                'test' => $test,
                'score' => $score,
                'total' => $total,
                'results' => $results,
                'badge' => $badge,
            ]);
        }

        return $this->render('test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }
}
