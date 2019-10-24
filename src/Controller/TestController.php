<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/test/getartists", name="getartists")
     */
    public function getartists()
    {
        return $this->render('test/getArtists.html.twig', [
           'artist' => 'booooo!!!',
        ]);
    }
}
