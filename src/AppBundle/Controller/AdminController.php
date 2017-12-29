<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\QuestionForm;
use AppBundle\Entity\Question;

class AdminController extends Controller
{
    /**
     * @Route("/home/quizes", name="quizes")
     */
    public function quizesAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/quizes.html.twig');
    }
    
    /**
     * @Route("/home/questions", name="questions")
     */
    public function questionsAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionForm::class, $question);
                
        //var_dump($form);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

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
