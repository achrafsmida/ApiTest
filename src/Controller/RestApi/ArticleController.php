<?php

namespace App\Controller\RestApi;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class ArticleController extends FOSRestController
{
    /**
     * ArticleController constructor.
     */
    public function __construct(ArticleRepository $articleRepository , EntityManagerInterface $entityManage)
    {
        $this->articleRespository =  $articleRepository ;
        $this->em =  $entityManage ;
    }


    /**
     * Creates an Article resource
     * @Rest\Post("/articles")
     * @param Request $request
     * @return View
     */
    public function postArticle(Request $request): View
    {
        //var_dump($request->get('title')) ; die();
        $article = new Article();
        $article->setTitle($request->get('title'));
        $article->setContent($request->get('content'));
        $this->em->persist($article) ;
        $this->em->flush();
        $this->em->flush();
       // var_dump($article) ; die();
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($article, Response::HTTP_CREATED);
    }


    /**
     * Retrieves an Article resource
     * @Rest\Get("/articles/{articleId}")
     */
    public function getArticle(int $articleId): View
    {
        $article = $this->articleRespository->findOneById($articleId);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($article, Response::HTTP_OK);
    }
}
