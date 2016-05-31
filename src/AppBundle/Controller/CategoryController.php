<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\Type\CateType;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="categorypage")
     */
    public function listAction()
    {
        $category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $category,
        ]);
    }

    /**
     * @Route("/category/show/{id}", name="category_show")
     */
    public function showAction(Request $request, Category $category)
    {
        
         $articles = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findBy(['category'=> $category]);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'articles' => $articles
        ]);
    }
    
    /**
     * @Route("/category/new", name="cate_new")
     */
    public function newAction(Request $request)
    {
        $cate = new Category();
        
        $form = $this->createForm(CateType::class, $cate);
        $form->add('submit', SubmitType::class);


        
        
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cate);
            $em->flush();

            $this->addFlash('success', 'Cate créé !');

            return $this->redirectToRoute('cate_new');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/category/edit/{id}", name="cate_edit")
     */
    public function editAction(Request $request, Category $cate)
    {
        $form = $this->createForm(CateType::class, $cate);
        $form->add('submit', SubmitType::class);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Cate édité !');

            return $this->redirectToRoute('cate_edit', [
                'id' => $cate->getId(),
            ]);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $cate,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/category/delete/{id}", name="cate_delete")
     */
    public function deleteAction(Category $cate)
    {        
        $em = $this->getDoctrine()->getManager();
        $em->remove($cate);
        $em->flush();

        $this->addFlash('success', 'Cate supprimé !');

        return $this->redirectToRoute('categorypage');
    }
}
