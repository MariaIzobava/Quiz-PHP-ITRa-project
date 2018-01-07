<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {  
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
        
        $results = array();
        
        foreach ($quizes as $quiz) { 
            $connection = $em->getConnection();
            $quiz_id = $quiz->getId();
            $sql_query = "SELECT * FROM `quiz_user` WHERE `id_quiz`=$quiz_id ORDER BY result DESC";
            $statement = $connection->prepare($sql_query);
            $statement->execute();
            $users = $statement->fetchAll();
            $leader = "--none--";
            if (sizeof($users) > 0) {
                $id_user = $users[0]['id_user'];
                $user = $this->getDoctrine()
                ->getRepository(User::class)
                    ->findOneBy(['id' => $id_user]);
                $leader = $user->getUsername();
            }
            $results[] = [
                "quiz" => $quiz,
                "users" => sizeof($users),
                "leader" => $leader, 
                
            ];
        }
        return $this->render('default/home.html.twig', array(
            'results' => $results,
            )     
        );
    }
}
