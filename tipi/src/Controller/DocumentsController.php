<?php

// $user->getDocuments()
// $categoryDocument->getDocuments()

// $documents->getFiles()

namespace App\Controller;

use App\Entity\CategoryDocument;
use App\Form\CategoryDocumentAddType;
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
     * @Route("/CategoryDocumentAdd", name="CategoryDocumentAdd")
     */
    public function CategoryDocumentAdd(Request $request, EntityManagerInterface $manager, CategoryDocumentRepository $CategoryDocumentRepository): Response
    {
        $CategoryDocumentNew = new CategoryDocument();
        //! erreur ici ?
        $formCategoryDocumentAdd = $this->createForm(formCategoryDocumentAddType::class, $CategoryDocumentNew);
        $formCategoryDocumentAdd->handleRequest($request);

        dump($request);

        dump($CategoryDocumentRepository);

        dump($formCategoryDocumentAdd);

        if($formCategoryDocumentAdd->isSubmitted() && $formCategoryDocumentAdd->isValid())
        {
            $CategoryDocumentNew->setTitleCategoryDocument($titleCategoryDocument);

            $manager->persist($CategoryDocumentNew);

            $manager->flush();

            return $this->redirectToRoute('documents');
        }

        return $this->render('documents/CategoryDocumentAdd.html.twig', [
            'controller_name' => 'Ajouter une catégorie de document',
            'formCategoryDocumentAdd' => $formCategoryDocumentAdd->createView(),
        ]);
    }

    /**
     * @Route("/DocumentAdd", name="DocumentAdd")
     */
    public function DocumentAdd(): Response
    {
        return $this->render('documents/DocumentAdd.html.twig', [
            'controller_name' => 'Ajouter un document',
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
