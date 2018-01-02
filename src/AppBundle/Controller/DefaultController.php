<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Quiz;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/home", name="home")
     */
    public function homeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $quizes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();
        return $this->render('default/home.html.twig', array(
            'quizes' => $quizes,
            )     
        );
    }
}
