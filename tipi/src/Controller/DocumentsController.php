<?php

namespace App\Controller;

use App\Entity\CategoryDocument;
use App\Entity\Documents;
use App\Entity\User;
use App\Form\CategoryDocumentAddType;
use App\Form\DocumentAddType;
use App\Repository\CategoryDocumentRepository;
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

    /**
     *
     * @Route("/CategoryDocumentAdd", name="CategoryDocumentAdd")
     * * AJOUTER UNE CATEGORIE pour les DOCUMENTS
     */
    public function CategoryDocumentAdd(Request $request, EntityManagerInterface $manager): Response
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
    public function viewCategoryDocument(CategoryDocumentRepository $repo): Response
    {
        // On appel getManager pour récupérer le noms des champs et des colonnes
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
    public function DocumentAdd(Request $request, EntityManagerInterface $manager): Response
    {
        $DocumentNew = new Documents();
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
