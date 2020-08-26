<?php

namespace App\Controller;

use App\Entity\Sejour;
use App\Form\SejourType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SejourController extends AbstractController
{
    /**
     * @Route("/sejour", name="sejour_default")
     */
    public function index()
    {
        return $this->render('sejour/index.html.twig', [
            'controller_name' => 'SejourController',
        ]);
    }

    /**
     * @Route("/sejour/display/{longueur}", name="detail_sejour")
     */
    public function getOne($longueur)
    {

        return $this->render('sejour/detail.html.twig', [
            'controller_name' => 'SejourController',
            'longueur' => $longueur
        ]);
    }

    /**
     * @Route("/sejour/add", name="add_sejour")
     */
    public function add(Request $request)
    {
        $form = $this->createForm(SejourType::class, new Sejour());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sejour = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($sejour);
            $em->flush();
            return $this->redirectToRoute('sejour_default');
        } else {
            return $this->render('sejour/add.html.twig', [
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/sejour/update/{sejour}", name="update_sejour")
     */
    public function update(Sejour $sejour, Request $request)
    {
        $form = $this->createForm(SejourType::class, $sejour);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('sejour_default');
        } else {
            return $this->render('sejour/edit.html.twig', [
                'sejour' => $sejour,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }
}
