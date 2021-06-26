<?php

namespace App\Controller;

use App\Entity\Tweet;
use App\Entity\TweetArticle;
use App\Form\TweetType;
use App\Repository\TweetRepository;
use App\Repository\TweetArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Monolog\DateTimeImmutable;

/**
 * @Route("")
 */
class TweetController extends AbstractController
{
    /**
     * @Route("/", name="tweet_index", methods={"GET"})
     */
    public function index(TweetRepository $tweetRepository, TweetArticleRepository $tweetArticleRepository  ): Response
    {
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('tweet/index.html.twig', [
            'tweets' => $tweetRepository->findAll(),
            'tweet_articles' => $tweetArticleRepository->findAll(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/new", name="tweet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tweet = new Tweet();
        $form = $this->createForm(TweetType::class, $tweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $tweet->setCreatedAt(
                new DateTimeImmutable('today')
            );

            $tweet->setAuthor($this->getUser());

            $entityManager->persist($tweet);
            $entityManager->flush();

            return $this->redirectToRoute('tweet_index');
        }

        return $this->render('tweet/new.html.twig', [
            'tweet' => $tweet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reply", name="tweet_reply", methods={"GET", "POST"})
     */
    public function reply(TweetRepository $tweetRepository, Request $request): Response {
        $tweet = new Tweet();
        $form = $this->createForm(TweetType::class, $tweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $tweet->setCreatedAt(
                new DateTimeImmutable('today')
            );

            $tweet->setAuthor($this->getUser());

            $tweetsWithMatchingIds = $tweetRepository->findById($request->query->get('parent', ''));
            $tweetParent = array_pop($tweetsWithMatchingIds);
            $tweet->setParent($tweetParent);

            $entityManager->persist($tweet);
            $entityManager->flush();

            return $this->redirectToRoute('tweet_index');
        }

        return $this->render('tweet/new.html.twig', [
            'tweet' => $tweet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tweet_show", methods={"GET"})
     */
    public function show(Tweet $tweet): Response
    {
        return $this->render('tweet/show.html.twig', [
            'tweet' => $tweet
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tweet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tweet $tweet): Response
    {
        $form = $this->createForm(TweetType::class, $tweet);
        $form->handleRequest($request);

        $tweetAuthor = $tweet->getAuthor();
        $currentUser = $this->getUser();
        $isAuthorOfTweet = $tweetAuthor == $currentUser;

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tweet_index');
        }

        return $this->render('tweet/edit.html.twig', [
            'tweet' => $tweet,
            'form' => $form->createView(),
            'isAuthorOfTweet' => $isAuthorOfTweet
        ]);
    }

    /**
     * @Route("/{id}", name="tweet_delete", methods={"POST"})
     */
    public function delete(Request $request, Tweet $tweet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tweet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tweet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tweet_index');
    }
}
