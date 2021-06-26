<?php

namespace App\Controller;

use App\Entity\TweetArticle;
use App\Form\TweetArticleType;
use App\Repository\TweetArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tweet/article")
 */
class TweetArticleController extends AbstractController
{
    /**
     * @Route("/", name="tweet_article_index", methods={"GET"})
     */
    public function index(TweetArticleRepository $tweetArticleRepository): Response
    {
        return $this->render('tweet_article/index.html.twig', [
            'tweet_articles' => $tweetArticleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tweet_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tweetArticle = new TweetArticle();
        $form = $this->createForm(TweetArticleType::class, $tweetArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tweetArticle);
            $entityManager->flush();

            return $this->redirectToRoute('tweet_article_index');
        }

        return $this->render('tweet_article/new.html.twig', [
            'tweet_article' => $tweetArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tweet_article_show", methods={"GET"})
     */
    public function show(TweetArticle $tweetArticle): Response
    {
        return $this->render('tweet_article/show.html.twig', [
            'tweet_article' => $tweetArticle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tweet_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TweetArticle $tweetArticle): Response
    {
        $form = $this->createForm(TweetArticleType::class, $tweetArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tweet_index');
        }

        return $this->render('tweet_article/edit.html.twig', [
            'tweet_article' => $tweetArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tweet_article_delete", methods={"POST"})
     */
    public function delete(Request $request, TweetArticle $tweetArticle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tweetArticle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tweetArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tweet_article_index');
    }
}
