<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RepertoireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Repertoire;
use App\Repository\RepertoireRepository;

class RepertoireController extends AbstractController
{
    /**
     * Affichage du formulaire + ajoute de contact + modification d'un contact
     * @Route("/repertoire", name="repertoire")
     * @Route("/show/{id}/edit", name="editContact")    
     */
    public function repertoire(Repertoire $repertoire = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$repertoire)
        {
            $repertoire = new Repertoire();
        }

        $formRepertoire = $this->createForm(RepertoireType::class, $repertoire);//permet de créer un formulaire d'ajout

        $formRepertoire->handleRequest($request); //permet de récupérer les données saisie dans le formulaire et de les transmettre


        if($formRepertoire->isSubmitted() && $formRepertoire->isValid())
        {
            if(!$repertoire->getId())
                $word = 'enregistrée';
            else
                $word = 'modifiée';

            dump($repertoire);
            $user = $this->getUser(); // recupérer la clé étrangère
            $repertoire->setUser($user);
            
            $manager->persist($repertoire);// $data = $bdd->prepare
            $manager->flush(); //execute 

            $this->addFlash('success', "Le contact a été $word avec succès !");

            return $this->redirectToRoute('show',[
                'id'=> $repertoire->getId()
            ]);//redirection vers page d'accueil
        }

        return $this->render('repertoire/index.html.twig',[
            'formRepertoire' => $formRepertoire->createView(),
            'editContact' => $repertoire->getId()
        ]);
        
    }

    /**
     * Affichage des contacts créer + suppression d'un contact
     * @Route("/show", name="show") 
     * @Route("/show/{id}/remove", name="removeContact")
     */
    public function viewAll(Repertoire $removeContact = null, EntityManagerInterface $manager, RepertoireRepository $repoRepertoire):Response
    {
        // dump($repoRepertoire);
        // dump($removeContact);

        $colonne = $manager->getClassMetadata(Repertoire::class)->getFieldNames();
        $repertoire = $repoRepertoire->findBy(array(), array("lastName" => "ASC"));//SELECT * FROM + FETCHALL...

        // dump($request->server->get('DOCUMENT_ROOT'));
    
        
        if($removeContact) //suppression
        {
            $manager->remove($removeContact);
            $manager->flush();
            $this->addFlash('success', "Le contact a bien été supprimé !");

            return $this->redirectToRoute('show');
        }

            return $this->render('repertoire/show.html.twig',[
                'contacts'=> $colonne,
                'repertoiresBDD' => $repertoire,
                'contact' => $removeContact,
                // 'editContact' => $repertoire
            ]);
    
    }
    
}
