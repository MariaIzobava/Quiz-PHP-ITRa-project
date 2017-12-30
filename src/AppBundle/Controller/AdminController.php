<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\QuestionForm;
use AppBundle\Entity\Question;
use AppBundle\Form\QuizForm;
use AppBundle\Entity\Quiz;

class AdminController extends Controller
{
    /**
     * @Route("/home/quizes", name="quizes")
     */
    public function homeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quiz = new Quiz();
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();
      
        $form = $this->createForm(QuizForm::class, $quiz, array(
            'questions' => $questions,
   
        ));
        
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($quiz->getQuestions() as $question) {
                $em->persist($question);
            }
            $em->persist($quiz);
            $em->flush();
        }
        return $this->render('admin/quizes.html.twig', array(
            'form' => $form->createView(),
            'questions' => $questions,
        ));
    }
    
    /**
     * @Route("/home/questions", name="questions")
     */
    public function questionsAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionForm::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
  
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('questions');
        }

        return $this->render(
            'admin/questions.html.twig',
            array('form' => $form->createView())
        );
        
    }
    
    /**
     * @Route("/home/users", name="users")
     */
    public function usersAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/users.html.twig');
    }
    
}
