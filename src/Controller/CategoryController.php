<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie_default")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/categorie/add", name="add_categorie")
     */
    public function add(Request $request)
    {
        $form = $this->createForm(CategoryType::class, new Category());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('categorie_default');
        } else {
            return $this->render('category/add.html.twig', [
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/categorie/update/{categorie}", name="update_categorie")
     */
    public function update(Category $categorie, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('categorie_default');
        } else {
            return $this->render('category/edit.html.twig', [
                'category' => $categorie,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }
}
