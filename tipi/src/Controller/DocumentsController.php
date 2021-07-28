<?php

namespace App\Controller;

use App\Entity\CategoryDocument;
use App\Entity\Documents;
use App\Entity\User;
use App\Form\CategoryDocumentAddType;
use App\Form\DocumentAddType;
use App\Repository\CategoryDocumentRepository;
use App\Repository\DocumentsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    /**
     * @Route("/categoryDocumentDelete/{id}", name="categoryDocumentDelete")
     */
    public function categoryDocumentDelete(CategoryDocument $CategoryDocumentDelete, EntityManagerInterface $manager): \Symfony\Component\HttpFoundation\RedirectResponse
    {
         $manager->remove($CategoryDocumentDelete);
         $manager->flush();
         $this->addFlash('success', "La catégorie a bien été supprimée !");
         return $this->redirectToRoute('viewCategoryDocument');
     }

    /**
     * @Route("/viewCategoryDocument", name="viewCategoryDocument")
     * * VUE ALL CATEGORY
     */
    public function viewCategoryDocument(CategoryDocumentRepository $repo): Response
    {
        // On appel getManager pour récupérer le noms des champs et des colonnes
        $em = $this->getDoctrine()->getManager();
        // récupération des champs
        $colonnes = $em->getClassMetadata(CategoryDocument::class)->getFieldNames();
        // dump($colonnes);
        $categoryDocument = $repo->findAll();
        // dump($categoryDocument);
        return $this->render('documents/categoryDocument.html.twig', [
            'categoryDocument' => $categoryDocument,
            'colonnes' => $colonnes
        ]);
    }

    // Ajouter / Editer un document
    /**
     * @Route("/documentAdd", name="documentAdd")
     * @Route("/documentEdit/{id}", name="documentEdit")
     */
    public function DocumentAddEdit(Documents $DocumentNew = null, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$DocumentNew)
        {
            $DocumentNew = new Documents();
        }

        $formDocumentAdd = $this->createForm(DocumentAddType::class, $DocumentNew);
        $formDocumentAdd->handleRequest($request);

        if($formDocumentAdd->isSubmitted() && $formDocumentAdd->isValid())
        {
            $user = $this->getUser();
            //* Ajout de la date now
            $DocumentNew->setDate(new DateTime());

            //! Ajout d'un nom de fichier temporaire
            $DocumentNew->setFileTitle('0');

            /** @var User $user */
            $DocumentNew->setUser($user);
            $manager->persist($DocumentNew);
            $manager->flush();

            $this->addFlash('success', 'Le document a bien été ajouté !');

            return $this->redirectToRoute('viewDocuments');
        }

        return $this->render('documents/documentAdd.html.twig', [
            'controller_name' => 'Ajouter un document',
            'formDocumentAdd' => $formDocumentAdd->createView(),
            'editMode' => $DocumentNew->getId() !== null
        ]);
    }

    // Suppression d'un document
    /**
     * @Route("/documentDelete/{id}", name="documentDelete")
     */
    public function documentDelete(Documents $DocumentDelete, EntityManagerInterface $manager): \Symfony\Component\HttpFoundation\RedirectResponse
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
        // On appel getManager pour récupérer le noms des champs et des colonnes
        $em = $this->getDoctrine()->getManager();
        // récupération des champs
        $colonnes = $em->getClassMetadata(Documents::class)->getFieldNames();
        // dump($colonnes);
        $documents = $repo->findAll();
        // dump($categoryDocument);
        return $this->render('documents/documents.html.twig', [
            'Documents' => $documents,
            'controller_name' => 'Vos documents',
            'colonnes' => $colonnes
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
