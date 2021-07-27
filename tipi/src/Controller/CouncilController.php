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
     * entrer sur la fonctionnalité réunion + affichage des Réunions existantes + posibilité de modifier/supprimer 1 réunion
     * 
     * @Route("/council", name="council")
     * @Route("/council/{id}/remove", name="councilRemove")
     */
    public function homeCouncil( EntityManagerInterface $manager , CouncilRepository $repoCouncils, Council $councilRemove = null): Response
    {
        // ********* CREER LE LIEN avec CouncilRepository.php et DONC la BDD ********* //
        // Contrôle :
        dump($repoCouncils); // dump(): outil de debug propre à Symfony, on affiche se que contient $repoCouncils

        dump($councilRemove);

        // ********* SELECTIONNE ds la BDD d'1 Council pr préparer la suppression ********* //
        // via le manager qui permet de manipuler la BDD (insert, upadte, delete etc...), on execute la méthode getClassMetadata() afin de selectionner les méta données (primary key ,not null, noms des champs etc..) d'une entité (donc d'une table SQL), pour selectionner le nom des champs/colonnes de la table grace à la méthode getFieldNames()
        // getColumnMeta()
        $colonnes = $manager->getClassMetadata(Council::class)->getFieldNames();
        dump($colonnes);

        // ********* SELECTIONNE ds la BDD des CouncilS pr les afficher ********* //
        // findAll(): SELECT * FROM Council + FETCHALL
        // $Councils : tableau ARRAY multidimentionnel contenant l'ensemble des Councils stockés ds la BDD
        // $councilsUser = $this->findBy(); // findBy, findOneBy ou countBy ->getUser()
        // dump($councilsUser);
        $user = $this->getUser();
        dump($user->getId());

        $councils = $repoCouncils->findBy(array("user" => $user));
        dump($councils); // dump(): outil de debug propre à Symfony, on affiche se que contient $Councils
        

        // ********* TRAITEMENT SUPPRESSION REUNION BDD
        // SI la condition IF retourne TRUE, cela veut dire $councilRemove contient les informations de la reunion a supprimer en BDD, on entre dans le IF
        if($councilRemove)
        {
            // Avant de supprimer le council en BDD, on stock son ID dans une variable afin de l'injecter dans le message de validation
            $councilTitle = $councilRemove->getTitleCouncilTribe();

            // remove() : méthode issue de l'interface EntityManagerInterface permettant de formuler une requete SQL de suppression (DELETE) 
            // $pdo->prepare("DELETE FROM councilicle WHERE id = $_GET[id]")
            $manager->remove($councilRemove);
            // flush() execute véritablement la requete DELETE en BDD (execute())
            $manager->flush();

            $this->addFlash('success', "$councilTitle a été supprimé avec succès !");

            return $this->redirectToRoute('council');
        }

        // ********* AFFICHE les REUNIONS s/ LE TEMPLATE ds ma page  ********* //
        return $this->render('council/council.html.twig', [
            'controller_homeCouncilTitre' => 'Gérer vos réunions!',
            'councilsBDD' => $councils, // via la méthode render() on transmet au template les Councils que nous avons selectionnés en BDD afin de les traités et de les afficher avec le langage TWIG
            'colonnes' => $colonnes,
            'councils' => $councils
        ]);
    }

    /**
     * Créer 1 réunion (formulaire) + modification de réunion
     * 
     * @Route("/council/addCouncil", name="addCouncil")
     * @Route("/council/{id}/edit", name="councilEdit")
     */
    public function Council(Council $addCouncil = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$addCouncil) // Si la reunion n'existe pas (donc $addCouncil = null)
        {
            $addCouncil = new Council();
        }
        
        $formAddCouncil = $this->createForm(CouncilType::class, $addCouncil);
        $formAddCouncil->handleRequest($request); // recuperer les données de POST (du formulaire) et de les envoyé dans le bon objet

        dump($request); // permet de stocker toute les informations des superglobales ($_POST,$_GET, $_FILES...)
        dump($addCouncil);

        // dump($userRepository);

        // dump($formAddCouncil);

        if($formAddCouncil->isSubmitted() && $formAddCouncil->isValid())
        {
            // recupération de la clé étrangère:
            $user = $this->getUser();

            $addCouncil->setUser($user);

            dump($addCouncil);

            $manager->persist($addCouncil);

            $manager->flush();

            // *********** REDIRECTION sur 1 autre page à la validation du FORMULAIRE
            return $this->redirectToRoute('councilShow', [
                "id" => $addCouncil->getId()
            ]);
        }
        // *********** GENERER / AFFICHAGE du FORMULAIRE ds le template
        return $this->render('council/addCouncil.html.twig', [
            'formAddCouncil' => $formAddCouncil->createView(),
            "editCouncil" => $addCouncil->getID() // on transmet l'ID de la réunion au template
    
        ]); 
    }

    /**
     * Méthode permettant d'afficher le détail/ le contenu d'une REUNION
     * 
     * @Route("/council/{id}", name="councilShow")
     */
    public function show(Council $addCouncil, Request $request, EntityManagerInterface $manager): Response
    {
        // L'id transmit dans l'URL est envoyé directement en argument de la fonction show(), ce qui nous permet d'avoir accès à l'id de l'article a selectionner en BDD au sein de la méthode show()
        // dump($id); // 6

        // Importation de la classe CouncilRepository
        // $repoCouncil = $this->getDoctrine()->getRepository(Council::class);
        // dump($repoCouncil);

        // find() : méthode mise à dispostion par Symfony issue de la classe CouncilRepository permettant de selectionner un élément de la BDD par son ID 
        // $council : tableau ARRAY contenant toutes les données de la réunion selectionné en BDD en fonction de l'ID transmit dans l'URL 

        // SELECT * FROM Council WHERE id = 6 + FETCH 
        // $council = $repoCouncil->find($id); // 6
        dump($request->server->get('DOCUMENT_ROOT'));

        $this->addFlash("success", "Félicitations, Vous avez créer une réunion !");

        // ****** ENVOIS les infos au TEMPLATE
        // render() : méthode qui permet d'envoyer les info receptionner au dessu
        return $this->render('council/showCouncil.html.twig', [
            "councilBDD" => $addCouncil, // on transmet au template les données de la réunion selectionné en BDD afin de les traiter avec le langage TWIG ds le template
        ]);
    }
}
