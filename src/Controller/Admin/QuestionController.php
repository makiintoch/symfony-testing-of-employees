<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuestionController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/question", name="question")
     */
    public function index()
    {
        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();

        return $this->render('admin/question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/question/create", name="question_create")
     */
    public function create(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question');
        }

        return $this->render('admin/question/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
