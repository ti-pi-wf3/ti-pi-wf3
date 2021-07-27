<?php

// $user->getDocuments()
// $categoryDocument->getDocuments()

// $documents->getFiles()

namespace App\Controller;

use App\Entity\Documents;
use App\Form\DocumentAddType;
use App\Entity\CategoryDocument;
use App\Form\CategoryDocumentAddType;
use App\Repository\DocumentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryDocumentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     *
     * @Route("/CategoryDocumentAdd", name="CategoryDocumentAdd")
     * * AJOUTER UNE CATEGORIE pour les DOCUMENTS
     */
    public function CategoryDocumentAdd(Request $request, EntityManagerInterface $manager, CategoryDocumentRepository $CategoryDocumentRepository): Response
    {
        $CategoryDocumentNew = new CategoryDocument();
        $formCategoryDocumentAdd = $this->createForm(CategoryDocumentAddType::class, $CategoryDocumentNew);
        $formCategoryDocumentAdd->handleRequest($request);

        if($formCategoryDocumentAdd->isSubmitted() && $formCategoryDocumentAdd->isValid())
        {

            $manager->persist($CategoryDocumentNew);

            $manager->flush();

            return $this->redirectToRoute('CategoryDocumentAdd');
        }

        return $this->render('documents/CategoryDocumentAdd.html.twig', [
            'controller_name' => 'Ajouter une catégorie de document',
            'formCategoryDocumentAdd' => $formCategoryDocumentAdd->createView(),
        ]);
    }

    /**
     * @Route("/ViewCategoryDocument", name="ViewCategoryDocument")
     * * VUE ALL CATEGORY
     */
    public function adminCategoryDocument(CategoryDocumentRepository $repo)
    {
        // On appel getManager afin de récupérer le noms des champs et des colonnes
        $em = $this->getDoctrine()->getManager();
        // récupération des champs
        $colonnes = $em->getClassMetadata(CategoryDocument::class)->getFieldNames();
        // dump($colonnes);
        $categoryDocument = $repo->findAll();
        // dump($categoryDocument);
        return $this->render('documents/CategoryDocument.html.twig', [
        'categoryDocument' => $categoryDocument,
        'colonnes' => $colonnes
        ]);
    }


    /**
     * @Route("/documentAdd", name="DocumentAdd")
     * * AJOUTER UN DOCUMENT
     */
    public function DocumentAdd(Request $request, EntityManagerInterface $manager, DocumentsRepository $DocumentsRepository): Response
    {
        $DocumentNew = new Documents();
        $formDocumentAdd = $this->createForm(DocumentAddType::class, $DocumentNew);
        $formDocumentAdd->handleRequest($request);

        if($formDocumentAdd->isSubmitted() && $formDocumentAdd->isValid())
        {
            $user = $this->getUser();
            //* Ajout de la date now
            $DocumentNew->setDate(new \DateTime());
            
            //! Ajout d'un nom de fichier temporaire
            $DocumentNew->setFileTitle('temp');

            $DocumentNew->setUser($user);
            $manager->persist($DocumentNew);
            $manager->flush();

            return $this->redirectToRoute('DocumentAdd');
        }

        return $this->render('documents/DocumentAdd.html.twig', [
            'controller_name' => 'Ajouter un document',
            'formDocumentAdd' => $formDocumentAdd->createView()
        ]);
    }

    /**
     * @Route("/FileAdd", name="FileAdd")
     */
    public function FileAdd(): Response
    {
        return $this->render('documents/FileAdd.html.twig', [
            'controller_name' => 'Ajouter un fichier',
        ]);
    }
}
