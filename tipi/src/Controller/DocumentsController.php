<?php

namespace App\Controller;

use App\Entity\CategoryDocument;
use App\Entity\Documents;
use App\Entity\User;
use App\Entity\Files;
use App\Form\CategoryDocumentAddType;
use App\Form\DocumentAddType;
use App\Repository\CategoryDocumentRepository;
use App\Repository\DocumentsRepository;
use App\Repository\FilesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentsController extends AbstractController
{
    /**
     * @Route("/documents", name="documents")
     */
    public function index(): Response
    {
        return $this->render('documents/index.html.twig', [
            'controller_name' => 'DocumentsController',
        ]);
    }

    // Ajout et Modification d'une catégorie pour les documents
    /**
     * @Route("/categoryDocumentAdd", name="categoryDocumentAdd")
     * @Route("/categoryDocumentEdit/{id}", name="categoryDocumentEdit")
     */
    public function CategoryDocumentAddEdit(CategoryDocument $CategoryDocumentNew = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$CategoryDocumentNew)
        {
            $CategoryDocumentNew = new CategoryDocument();
        }

        $formCategoryDocumentAdd = $this->createForm(CategoryDocumentAddType::class, $CategoryDocumentNew);
        $formCategoryDocumentAdd->handleRequest($request);

        if($formCategoryDocumentAdd->isSubmitted() && $formCategoryDocumentAdd->isValid())
        {
            $user = $this->getUser();
            $tribeId = $user->getTribeId(); // ENTITY Tribe
            $CategoryDocumentNew->setTribeCategoryDoc($tribeId);

            $manager->persist($CategoryDocumentNew);
            $manager->flush();

            $this->addFlash('success', 'La catégorie a bien été ajouté !');

            return $this->redirectToRoute('viewCategoryDocument');
        }

        // return $this->render('documents/categoryDocumentAdd.html.twig', [
        return $this->render('documents/categoryDocumentAdd.html.twig', [
            'controller_name' => 'Ajouter une catégorie de document',
            'formCategoryDocumentAdd' => $formCategoryDocumentAdd->createView(),
            'editMode' => $CategoryDocumentNew->getId() !== null
        ]);
    }

    // Suppression d'une catégorie pour les documents
    //!!!!!!!!!!!!!!!! PRÉVENIR MSG D'ERREUR SI CAT utilisée par un DOC !!!!!!!!!!!!!
    /**
     * @Route("/categoryDocumentDelete/{id}", name="categoryDocumentDelete")
     */
    public function categoryDocumentDelete(CategoryDocument $CategoryDocumentDelete, EntityManagerInterface $manager): RedirectResponse
    {
        $manager->remove($CategoryDocumentDelete);
        $manager->flush();
        $this->addFlash('success', "La catégorie a bien été supprimée !");
        return $this->redirectToRoute('viewCategoryDocument');
    }

    // Vue des catégories par tribu
    /**
     * @Route("/viewCategoryDocument", name="viewCategoryDocument")
     */
    public function viewCategoryDocument(CategoryDocumentRepository $repo): Response
    {

//        // On appelle getManager pour récupérer le noms des champs et des colonnes
//        $em = $this->getDoctrine()->getManager();
//        // récupération des champs
//        $colonnes = $em->getClassMetadata(CategoryDocument::class)->getFieldNames();
//        // dump($colonnes);

//        $categoryDocument = $repo->findBy(array("user" => $user));


        $catByTribu = $this->getUser();
        $categoryDocument = $repo->findBy(array("tribeCategoryDoc" => $catByTribu->getTribeId()));

        // dump($categoryDocument);
        return $this->render('documents/categoryDocument.html.twig', [
            'categoryDocument' => $categoryDocument,
//            'colonnes' => $colonnes
        ]);
    }

    // Ajouter / Éditer un document
    //!!!!!!!!!!!!!!!!!!!! VERIFIER PK $manager est déclaré comme non utilisé
    /**
     * @Route("/documentAdd", name="documentAdd")
     * @Route("/documentEdit/{id}", name="documentEdit")
     */
    public function DocumentAddEdit(Documents $DocumentNew = null, Request $request): Response
    {
        if(!$DocumentNew)
        {
            $DocumentNew = new Documents();
        }

        $formDocumentAdd = $this->createForm(DocumentAddType::class, $DocumentNew);
        $formDocumentAdd->handleRequest($request);

        if($formDocumentAdd->isSubmitted() && $formDocumentAdd->isValid())
        {
            // On récupère les images transmises
            $files = $formDocumentAdd->get('files')->getData();

            // On boucle sur les images
            foreach($files as $file){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$file->guessExtension();

                // On copie le fichier dans le dossier uploads
                $file->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $img = new Files();
                $img->setTitleFile($fichier);
                $img->setDescription($fichier);
                $img->setFileUpload($fichier);
                $img->setDate(new DateTime());
                $DocumentNew->addFile($img);
            }

            $user = $this->getUser();
            //* Ajout de la date now
            $DocumentNew->setDate(new DateTime());

            //! Ajout d'un nom de fichier temporaire
            $DocumentNew->setFileTitle('0');

            /** @var User $user */
            $DocumentNew->setUser($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($DocumentNew);
            $manager->flush();

//            $this->addFlash('success', 'Le document a bien été ajouté !');

            return $this->redirectToRoute('oneViewDocument', [
                "id" => $DocumentNew->getId()
            ]);
        }

        return $this->render('documents/documentAdd.html.twig', [
            'controller_name' => 'Ajouter un document',
            'formDocumentAdd' => $formDocumentAdd->createView(),
            'editMode' => $DocumentNew->getId(),
            'document' => $DocumentNew
        ]);
    }

    /**
     * @Route("/supprime/image/{id}", name="annonces_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Files $file, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$file->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $file->getTitleFile();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    // Suppression d'un document
    /**
     * @Route("/documentDelete/{id}", name="documentDelete")
     */
    public function documentDelete(Documents $DocumentDelete, EntityManagerInterface $manager): RedirectResponse
    {
        $manager->remove($DocumentDelete);
        $manager->flush();
        $this->addFlash('success', "Le document a bien été supprimé !");
        return $this->redirectToRoute('viewDocuments');
    }

    // Vue de tout les documents par utilisateur
    /**
     * @Route("/viewDocuments", name="viewDocuments")
     */
    public function viewDocuments(DocumentsRepository $repo): Response
    {
        $user = $this->getUser();
        // https://symfony.com/doc/current/doctrine/associations.html

        // On appel getManager pour récupérer le noms des champs et des colonnes
//        $em = $this->getDoctrine()->getManager();
        // récupération des champs
//        $colonnes = $em->getClassMetadata(Documents::class)->getFieldNames();
        // dump($colonnes);

        $documents = $repo->findBy(array("user" => $user));
        return $this->render('documents/documents.html.twig', [
            'Documents' => $documents,
            'controller_name' => 'Vos documents',
//            'colonnes' => $colonnes
        ]);
    }

    // Vue entière d'un document
    /**
     * @Route("/oneViewDocument/{id}", name="oneViewDocument")
     */
    public function oneViewDocument(Documents $documents, FilesRepository $files): Response
    {

        return $this->render('documents/DocumentView.html.twig', [
            'documents' => $documents,
            'controller_name' => 'Votre document'
        ]);
    }

    /**
     * @Route("/fileAdd", name="fileAdd")
     */
    public function FileAdd(): Response
    {
        return $this->render('documents/fileAdd.html.twig', [
            'controller_name' => 'Ajouter un fichier',
        ]);
    }

}
