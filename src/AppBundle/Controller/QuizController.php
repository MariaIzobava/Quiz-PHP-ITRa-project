<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AnswerSubmitForm;

class QuizController extends Controller
{
    /**
     * @Route("/quiz/{id}", name="quiz", requirements={"id"="\d+"}))
     */
    public function quizRunAction(Request $request, $id)
    {
       
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
    
        $em = $this->getDoctrine()->getManager(); 
        $connection = $em->getConnection();
        
        $results = $this->getUserQuizInfo($id, $user_id, $connection);
        
        if ($results == null) {
            $this->insertNewUser($id, $user_id, $connection);
            $results = $this->getUserQuizInfo($id, $user_id, $connection);
        }
        $questions_numbers = $this->getQuestionsNumbers($id, $connection);
        $questions = $this->getQuestions($questions_numbers, $connection);

        $num = $results['question'];
        
        //that means that User has already passed the quiz 
        if ($num >= sizeof($questions)) 
        {
            $rating = $this->getFinalRating($id, $connection);
            return $this->render('quiz/result.html.twig', $rating);
        }
        
        $form = $this->createForm(AnswerSubmitForm::class, null, array(
            'user_question_data' => $results, 
            'questions' => $questions,
        ));
         
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateData($form, $id, $user_id, $questions, $results, $connection);
            
            return $this->redirect($request->getUri());
        }
        
        return $this->render('quiz/quiz_run.html.twig', array (
            'form' => $form->createView(),
        ));
    }
    
    private function getFinalRating($id, $connection) {
        $sql_query = "SELECT * FROM `quiz_user` WHERE `id_quiz`=$id ORDER BY result DESC";
        $statement = $connection->prepare($sql_query);
        $statement->execute();
        $rating = $statement->fetchAll();
        $users_list = array();
        $k = 0;
        $position = 0;
        foreach ($rating as $entity) 
        {
            $entity_id_user = $entity['id_user'];
            $sql_query = "SELECT username FROM `app_users` WHERE `id`=$entity_id_user ";
            $statement = $connection->prepare($sql_query);
            $statement->execute();
            $user = $statement->fetch();
            $users_list[] = $user['username'];
                
            if ($this->get('security.token_storage')->getToken()->getUser()->getUsername() == $users_list[$k]) {
                        $position = $k + 1;
                    }
            $k++;
        }
        while ($k < 3) {
            $users_list[] = '--none-- ';
            $k++;
        }
        
        $rating = array (
            'users_list' => $users_list,
            'position' => $position,
            'name' => $this->get('security.token_storage')->getToken()->getUser()->getUsername(), 
        );
        return $rating;
    }
    
    private function getQuestions($questions_numbers, $connection) {
        $questions = array();
        foreach ($questions_numbers as $num) {
            $q = $num['id_question'];
            $sql_query = "SELECT * FROM `questions` WHERE `id_question`= $q";
            $statement = $connection->prepare($sql_query);
            $statement->execute();
            $questions[] = $statement->fetch();
        }
        return $questions;
    }
    
    private function getUserQuizInfo($id, $user_id, $connection) {
        $sql_query = "SELECT * FROM `quiz_user` WHERE `id_quiz`=$id AND `id_user`=$user_id";
        $statement = $connection->prepare($sql_query);
        $statement->execute();
        $results = $statement->fetch();
        return $results;
    }
    
    private function insertNewUser($id, $user_id, $connection) {
        $dt = new \DateTime('now');
        $timestamp = $dt->getTimestamp();
        $sql_query = "INSERT INTO quiz_user (id_quiz, id_user, start_time, question, result) VALUES ($id, $user_id, FROM_UNIXTIME($timestamp), 0, 0)";
        $statement = $connection->prepare($sql_query);
        $statement->execute();
    }
    
    private function getQuestionsNumbers($id, $connection) {
        $sql_query = "SELECT * FROM `quiz_questions` WHERE `id_quiz`=$id";
        $statement = $connection->prepare($sql_query);
        $statement->execute();
        $questions_numbers = $statement->fetchAll();
        return $questions_numbers;
    }
    
    private function updateData($form, $id, $user_id, $questions, $results, $connection) {
        $num = $results['question'];
        $data = $form->getData();
        $ans_value = 1;
        if ($data['answers'] == $questions[$num]['variant2'])  { $ans_value = 2; }
        if ($data['answers'] == $questions[$num]['variant3']) { $ans_value = 3; }
        $new_result = $results['result'] + ($ans_value == $questions[$num]['answer'] ? 1 : 0);
        $new_question = $results['question'] + 1;
           
        $sql_query = "UPDATE `quiz_user` SET `question`=$new_question, `result`=$new_result WHERE `id_quiz`=$id AND `id_user`=$user_id";
        $statement = $connection->prepare($sql_query);
        $statement->execute();
    }
}
