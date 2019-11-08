<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class GeneralController extends AbstractController
{
    /**
     * @Route("/general", name="general")
     */
    public function index()
    {
        return $this->render('general/index.html.twig', [
            'controller_name' => 'GeneralController',
        ]);
    }
}
