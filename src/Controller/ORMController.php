<?php

namespace App\Controller;

use App\Entity\Artist;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ORMController extends AbstractController
{
    /**
     * @Route("/orm", name="orm")
     */
    public function index()
    {
        return $this->render('orm/index.html.twig', [
            'controller_name' => 'ORMController',
        ]);
    }

    /**
     * @Route("/orm/add", name="orm-add")
     */
    public function addDummy()
    {
        $nin = new Artist();
        $nin->setName("Nine Inch Nails");

        $em = $this->getDoctrine()->getManager();
        $em->persist($nin);
        $em->flush();

        return new Response('Saved NIN');
    }
}
