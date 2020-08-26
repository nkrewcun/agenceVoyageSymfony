<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/session/add", name="add_session")
     */
    public function index(Request $request)
    {
        $session = $request->getSession();
        $session->set('firstname', 'Nathan');
        $session->set('lastname', 'Krewcun');
        return $this->render('session/add.html.twig', [
            'controller_name' => 'addSession',
        ]);
    }

    /**
     * @Route("/session/display", name="display_session")
     */
    public function display(Request $request) {
        $session = $request->getSession();
        return $this->render('session/display.html.twig', [
            'controller_name' => 'displaySession',
            'session' => $session->all()
        ]);
    }

    /**
     * @Route("/session/remove", name="remove_session")
     */
    public function remove(Request $request) {
        $session = $request->getSession();
        $session->clear();
        return $this->render('session/remove.html.twig', [
            'controller_name' => 'removeSession',
        ]);
    }
}
