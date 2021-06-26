<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TweetsFeedController extends AbstractController
{
    /**
     * @Route("/tweets/feed", name="tweets_feed")
     */
    public function index(): Response
    {
        return $this->render('tweets_feed/index.html.twig', [
            'controller_name' => 'TweetsFeedController',
        ]);
    }
}
