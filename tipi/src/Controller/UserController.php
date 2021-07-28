<?php

namespace App\Controller;

use App\Entity\Tribe;
use App\Repository\UserRepository;
use App\Repository\TribeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /**
     * @Route("/gestion", name="gestion")
     */
    public function gestion(EntityManagerInterface $manager,UserRepository $userRepository, Tribe $tribe = null): Response
    {
        $userByTribu = $this->getUser();
        dump($userByTribu->getId());
        $userByTribus = $userRepository->findBy(array("tribeId" => $userByTribu->getTribeId()));
        dump($userByTribus);

        return $this->render('user/gestion_user.html.twig', [
            'controller_name' => 'UserController',
            'usersBDD' => $userByTribus
        ]);
    }
}
