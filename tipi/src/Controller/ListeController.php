<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\CategoryArticle;
use App\Form\CategoryArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListeController extends AbstractController
{

    public function allCategoryArticle(CategoryArticleRepository $repoCatArticle): Response 
    {
        $catsArticle = $repoCatArticle->findAll();

        return $this->render('category/categories.html.twig', [
            'catsArticle' => $catsArticle
        ]);
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function index(): Response
    {
        return $this->render('liste/index.html.twig', [
            'liste' => 'ListeController',
        ]);
    }


    /**
     * @Route("/article", name="article")
     */
    public function article(Request $request, EntityManagerInterface $manager, ArticleRepository $articleRepository, CategoryArticleRepository $categoryArticleRepository):Response
    {
        $article = new Article;
        $formArticle = $this->createForm(ArticleType::class, $article);
        $formArticle->handleRequest($request);

        // dd($article);
        if($formArticle->isSubmitted() && $formArticle->isValid())
        {
            $manager->persist($article);
            $manager->flush();
        }
        
        

        return $this->render('liste/article.html.twig', [
            'formArticle' => $formArticle->createView(),
        ]);
    }

}
