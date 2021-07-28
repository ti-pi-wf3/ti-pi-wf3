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
     * @Route("/index", name="index")
     */
    public function index(): Response
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        // dd($articles);

        return $this->render('liste/index.html.twig', [
            'articles' => $articles,
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

        /**
     * @Route("/category", name="category")
     */
    public function categoryAdd(Request $request, EntityManagerInterface $manager, ArticleRepository $articleRepository, CategoryArticleRepository $categoryArticleRepository):Response
    {
        $category = new CategoryArticle;
        $formCategory = $this->createForm(CategoryArticleType::class, $category);
        $formCategory->handleRequest($request);

        // dd($category);
        if($formCategory->isSubmitted() && $formCategory->isValid())
        {
            $manager->persist($category);
            $manager->flush();
        }
        
        return $this->render('liste/categoryArticle.html.twig', [
            'formCategory' => $formCategory->createView(),
        ]);
    }

    /**
     * @Route("/viewArticle", name="viewArticle")
     * 
     */

    public function viewAll(CategoryArticleRepository $categoryArticleRepository, ArticleRepository $articleRepository, Request $request)
    {
        $cat = $categoryArticleRepository->findAll();
    
        dump($cat);
        dump($request);
    

        return $this->render('liste/liste.html.twig', [
            'catBDD' => $cat,
            // 'formList' => $formList->createView()
        ]);
    }
}