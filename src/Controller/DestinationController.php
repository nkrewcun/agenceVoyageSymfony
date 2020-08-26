<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Form\DestinationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{
    /**
     * @Route("/destination", name="destination_default")
     */
    public function index()
    {
        $destinations = ['plage', 'montagne', 'campagne'];
        return $this->render('destination/index.html.twig', [
            'controller_name' => 'DestinationController',
            'destinations' => $destinations
        ]);
    }

    /**
     * @Route("/destination/display/{name}", name="detail_destination")
     */
    public function getOne($name) {
        return $this->render('destination/detail.html.twig', [
            'controller_name' => 'DestinationController',
            'name' => $name
        ]);
    }

    /**
     * @Route("/destination/add", name="add_destination")
     */
    public function add(Request $request)
    {
        $form = $this->createForm(DestinationType::class, new Destination());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $destination = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($destination);
            $em->flush();
            return $this->redirectToRoute('destination_default');
        } else {
            return $this->render('destination/add.html.twig', [
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/destination/update/{destination}", name="update_destination")
     */
    public function update(Destination $destination, Request $request)
    {
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('destination_default');
        } else {
            return $this->render('destination/edit.html.twig', [
                'destination' => $destination,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }


}
