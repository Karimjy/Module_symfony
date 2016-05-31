<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\CateType;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * @Route("/tag", name="tagpage")
     */
    public function listAction(Request $request)
    {
        $filtercategory = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')
            ->findOneById($request->query->get('tag'));
        
        $articlesRep = $this->getDoctrine()
            ->getRepository('AppBundle:Article');
        
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();
        
        if(!is_null($filtercategory)){
            $articles = $articlesRep->findByCategory($filtercategory);
        }else{
            $articles = $articlesRep->findAll();
        }
        
        return $this->render('article/list.html.twig', [
            'articles' => $articles,
        ]);
    }

   
}
