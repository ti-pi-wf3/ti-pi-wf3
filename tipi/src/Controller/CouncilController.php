<?php

namespace App\Controller;

use App\Entity\Council;
use App\Form\CouncilType;
use App\Repository\UserRepository;
use App\Repository\CouncilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CouncilController extends AbstractController
{
    /**
     * entrer sur la fonctionnalité réunion + affichage des Réunions existantes
     * 
     * @Route("/council", name="council")
     */
    public function homeCouncil(CouncilRepository $repoCouncils): Response
    {
        // ********* CREER LE LIEN avec CouncilRepository.php et DONC la BDD ********* //
        // Contrôle :
        dump($repoCouncils);// dump(): outil de debug propre à Symfony, on affiche se que contient $repoCouncils

        // ********* SELECTIONNE ds la BDD des CouncilS ********* //
        // findAll(): SELECT * FROM Council + FETCHALL
        // $Councils : tableau ARRAY multidimentionnel contenant l'ensemble des Councils stockés ds la BDD
        $Councils = $repoCouncils->findAll();
        dump($Councils); // dump(): outil de debug propre à Symfony, on affiche se que contient $Councils

        // ********* AFFICHE les REUNIONS s/ LE TEMPLATE ds ma page  ********* //
        return $this->render('council/council.html.twig', [
            'controller_homeCouncilTitre' => 'Gérer vos réunions!',
            'CouncilsBDD' => $Councils // via la méthode render() on transmet au template les Councils que nous avons selectionnés en BDD afin de les traités et de les afficher avec le langage TWIG
        ]);
    }

    /**
     * Créer 1 réunion : formulaire
     * 
     * @Route("/addCouncil", name="addCouncil")
     */
    public function Council(Request $request, EntityManagerInterface $manager): Response
    {
        $addCouncil = new Council();
        $formAddCouncil = $this->createForm(CouncilType::class, $addCouncil);
        $formAddCouncil->handleRequest($request); // recuperer les données de POST (du formulaire) et de les envoyé dans le bon objet

        dump($request); // permet de stocker toute les informations des superglobales ($_POST,$_GET, $_FILES...)

        // dump($userRepository);

        // dump($formAddCouncil);

        if($formAddCouncil->isSubmitted() && $formAddCouncil->isValid())
        {

            $user = $this->getUser();

            $addCouncil->setUser($user);

            dump($addCouncil);

            $manager->persist($addCouncil);

            $manager->flush();

            return $this->redirectToRoute('council');
        }

        return $this->render('council/addCouncil.html.twig', [
            'formAddCouncil' => $formAddCouncil->createView(),
    
        ]); 
    }
}
