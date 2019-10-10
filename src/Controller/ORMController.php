<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
    public function addDummy(EntityManagerInterface $em)
    {
        $nin = new Artist();
        $nin->setName("Nine Inch Nails");

        $phm = new Album();
        $phm->setArtist($nin);
        $phm->setName("Pretty Hate Machine");

        $hlh = new Song();
        $hlh->setName("Head Like a Hole");
        $hlh->setAlbum($phm);
        $hlh->setNumber(1);
        $hlh->setLength(500);

        //$em = $this->getDoctrine()->getManager();
        //$em->persist($nin);
        //$em->flush();

        $em->persist($nin);
        $em->persist($phm);
        $em->persist($hlh);
        $em->flush();

        return new Response('Saved NIN');
    }

    /**
     * @Route("/orm/showArtists", name="showArtists")
     */
    public function showArtist(ArtistRepository $artistRepository)
    {

        return $this->render('orm/showArtists.html.twig', [
            'controller_name' => 'ORM Controller',
        ]);

        return $this->json(['name' => 'ben']);
    }
}
