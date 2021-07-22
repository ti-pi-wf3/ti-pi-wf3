<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TipiController extends AbstractController
{
    /**
     * @Route("/", name="tipi")
     */
    public function home(AuthenticationUtils $authenticationUtils): Response
    {
         // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'controller_name' => 'TipiController',
            'title' => 'Welcome to TIPI !', 
            'last_username' => $lastUsername, 
            'error' => $error
        ]);
    }
}
