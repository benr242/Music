<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ORMController extends AbstractController
{
    /**
     * @Route("/o/r/m", name="o_r_m")
     */
    public function index()
    {
        return $this->render('orm/index.html.twig', [
            'controller_name' => 'ORMController',
        ]);
    }
}
