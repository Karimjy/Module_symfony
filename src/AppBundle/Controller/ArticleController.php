<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
//use AppBundle\Entity\Comment;
//use AppBundle\Form\Type\CommentType;
use AppBundle\Form\Type\ArticleType;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
   
 /**
     * @Route("/", name="homepage")
     */
    public function listAction(Request $request)
    {
         $filtercategory = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findOneById($request->query->get('cat'));
        
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
            'categories' => $categories,
            'filtercategory' => $filtercategory,
        ]);
    } 
    /**
     * @Route("/article/{id}/{slug}", name="article_show")
     */
    public function showAction(Request $request, Article $article)
    {
//        $comment = new Comment($article);
//        $commentForm = $this->createForm(CommentType::class, $comment);
//        $commentForm->add('Ajouter mon commentaire', SubmitType::class);
//        if ($commentForm->handleRequest($request)->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($comment);
//            $em->flush();
//
//            $this->addFlash('success', 'Commentaire ajouté !');
//
//            return $this->redirectToRoute('article_show', [
//                'id' => $article->getId(),
//            ]);
//        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
//            'commentForm' => $commentForm->createView(),
        ]);
    }
    
    /**
     * @Route("/new", name="article_new")
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->add('submit', SubmitType::class);


        
        
        if ($form->handleRequest($request)->isValid()) {
            $slug = $this->get('app.slugger')->slugify($article->getTitle());
            $article->setSlug($slug);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article créé !');

            return $this->redirectToRoute('article_new');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
