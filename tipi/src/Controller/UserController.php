<?php

namespace App\Controller;

use App\Entity\User;
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
     * @Route("/gestion/{id}/remove", name="gestion_remove")
     */
    public function gestion(EntityManagerInterface $manager,UserRepository $userRepository, User $userRemove = null): Response
    {
        //clé étrangère
        $userByTribu = $this->getUser();

        // dump($userByTribu->getId());

        $userByTribus = $userRepository->findBy(array("tribeId" => $userByTribu->getTribeId()));
        $userRole = [];
        $userRole = $userByTribu->getRoles();

        dump($userRole);

        //suppression
        if($userRemove)
        {
            $manager->remove($userRemove);
            $manager->flush();
            return $this->redirectToRoute('gestion');
        }

        return $this->render('user/gestion_user.html.twig', [
            'controller_name' => 'UserController',
            'usersBDD' => $userByTribus,
            'role' => $userRole
        ]);
    }
}
