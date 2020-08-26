<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ActiviteController extends AbstractController
{

    /**
     * @Route("/activite", name="activite_default")
     * @Route("/activite/{activePage}", name="activite", requirements={"activePage"="\d+"})
     */
    public function index($activePage = 1)
    {
        $nbElements = 5;
        $activityRepository = $this->getDoctrine()->getRepository(Activite::class);
        $nbPages = ceil($activityRepository->count([]) / $nbElements);
        $activites = $activityRepository->pagination($activePage, $nbElements);
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
            'activites' => $activites,
            'nbPages' => $nbPages,
            'activePage' => $activePage
        ]);
    }

    /**
     * @Route("/activite/add", name="add_activite")
     */
    public function add(Request $request, SluggerInterface $slugger)
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activite = $form->getData();
            $image = $form->get('image')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $activite->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
            return $this->redirectToRoute('activite_default');
        } else {
            return $this->render('activite/add.html.twig', [
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/activite/update/{activite}", name="update_activite")
     */
    public function update(Activite $activite, Request $request, SluggerInterface $slugger)
    {
        $originalImage = $activite->getImage();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activite = $form->getData();
            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();
            if ($image && $originalImage) {
                $image->move(
                    $this->getParameter('images_directory'),
                    $originalImage
                );
                $activite->setImage($originalImage);
            } else if ($image && !$originalImage) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $activite->setImage($newFilename);
            } else if (!$image && $originalImage) {
                $activite->setImage($originalImage);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('activite_default');
        } else {
            return $this->render('activite/edit.html.twig', [
                'originalImage' => $originalImage,
                'activite' => $activite,
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            ]);
        }
    }

    /**
     * @Route("/activite/detail/{activite}", name="show_activite")
     */
    public
    function selectOne(Activite $activite)
    {
        return $this->render('activite/show.html.twig', [
            'controller_name' => 'ActiviteController',
            'activite' => $activite
        ]);
    }

    /**
     * @Route("/activite/delete/{activite}", name="delete_activite")
     */
    public
    function delete(Activite $activite)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($activite);
        $entityManager->flush();

        return $this->redirectToRoute('activite');
    }

    /**
     * @Route("/activite/search/{string}", name="findByName_activite")
     */
    public
    function findByName($string)
    {
        $activiteRepository = $this->getDoctrine()->getRepository(Activite::class);
        $activites = $activiteRepository->findByName($string);
        return $this->render('activite/search.html.twig', [
            'controller_name' => 'ActiviteController',
            'activites' => $activites,
            'search' => $string
        ]);
    }
}
