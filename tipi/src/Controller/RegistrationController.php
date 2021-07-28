<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tribe;
use App\Form\TribeType;
use App\Form\RegistrationType;
use App\Repository\TribeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/tribe", name="tribe")
     */
    public function tribe(Request $request, EntityManagerInterface $manager, SessionInterface $session): Response
    {
        $tribe = new Tribe();
        $formTribe = $this->createForm(TribeType::class, $tribe);
        $formTribe->handleRequest($request);
        

        dump($formTribe);

        if($formTribe->isSubmitted() && $formTribe->isValid())
        {


            $sessionTribe = $session->set('tribe', $tribe);


            dump($sessionTribe);

            return $this->redirectToRoute('register');
        }

        return $this->render('registration/tribe.html.twig', [
            'formTribe' => $formTribe->createView(),
    
        ]); 
    }

     // Creation du chef de la tribu

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, TribeRepository $tribeRepository, SessionInterface $session, UserPasswordHasherInterface $encoder): Response
    {
        $userRegister = new User();
        $formRegister = $this->createForm(RegistrationType::class, $userRegister);

        $formRegister->handleRequest($request);

        dump($request);

        dump($tribeRepository);

        if($formRegister->isSubmitted() && $formRegister->isValid())
        {
            $hash = $encoder->hashPassword($userRegister, $userRegister->getPassword());
            dump($hash);
            $userRegister->setPassword($hash);

            dump($session->get('tribe'));

            $tribe = $session->get('tribe');

            $userRegister->setTribeId($tribe);
            $userRegister->setRoles(["ROLE_SUPER_USER"]);

            dump($userRegister);

            $manager->persist($userRegister);

            $manager->flush();

            return $this->redirectToRoute('tipi');
        }

        return $this->render('registration/register.html.twig', [
            // 'superUser' => 'ROLE_SUPER_USER',
            
            'formRegister' => $formRegister->createView(),
        ]);
    }

    // Creation d'un nouveau membre de la tribu
    /**
     * @Route("/addMember", name="addMember")
     */
    public function addMember(Request $request, EntityManagerInterface $manager,  SessionInterface $session, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();


        $addMember = new User();
        $formAddMember = $this->createForm(RegistrationType::class, $addMember);

        $formAddMember->handleRequest($request);

        dump($request);

        if($formAddMember->isSubmitted() && $formAddMember->isValid())
        {
            $hash = $encoder->hashPassword($addMember, $addMember->getPassword());
            dump($hash);
            $addMember->setPassword($hash);

            $tribeName = $user->getTribeId();

            dump($tribeName);
            
            

            $addMember->setTribeId($tribeName);
            $addMember->setRoles(["ROLE_USER"]);


            $manager->persist($addMember);

            $manager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('registration/add_member.html.twig', [
            // 'superUser' => 'ROLE_SUPER_USER',
            
            'formAddMember' => $formAddMember->createView(),
        ]);
    }
}
