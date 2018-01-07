<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AjaxController extends Controller
{
    
    
    /**
     * @Route("/ajax", name="_ajax")
     * @Method("POST")
     */
    public function ajaxAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $sort_by = strtolower($request->request->get('sort_by'));
        $direction = $request->request->get('direction');
        $text = strtolower($request->request->get('text_search'));
        $field = strtolower($request->request->get('field'));
        $page = $request->request->get('page');
        $amount = $request->request->get('amount');
        
        if ($text != null) {
            $quizes = $this->getDoctrine()
                ->getRepository(User::class)
                    ->findBy([$field => $text]); // ASC
        } 
        else if ($sort_by != null) {
        
            $quizes = $this->getDoctrine()
                ->getRepository(User::class)
                    ->findBy([], [$sort_by => $direction]); // ASC
        } else {
            $quizes = $this->getDoctrine()
            ->getRepository(User::class)
                ->findAll();
        }
        $ans = array();
        
        for ($i = ($page - 1) * $amount; $i < sizeof($quizes) && $i < $page * $amount; $i++) {
            $ans[] = $quizes[$i];
        }
        
        if (sizeof($ans) == 0)
            return new Response(json_encode("No such page"));
        
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($ans, 'json');
 
        return new Response($jsonContent);
        
    }
}
