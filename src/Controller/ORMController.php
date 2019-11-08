<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Form\AlbumType;
use App\Form\ArtistType;
use App\Form\SongType;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ORMController extends AbstractController
{
    /**
     * @Route("/orm",
     *     name="orm")
     */
    public function index()
    {
        return $this->render('orm/index.html.twig', [
            'controller_name' => 'ORMController',
        ]);
    }

    /**
     * @Route("/orm/add",
     *     name="orm-add")
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
     * @Route("/test",
     *     name="test")
     */
    public function test()
    {
        return new Response("test response");
    }

    /**
     * @Route("/orm/showAllArtists",
     *     name="showAllArtists")
    */
    public function showAllArtists(EntityManagerInterface $em, ArtistRepository $artistRep)
    {
        $artistRepository = $em->getRepository(Artist::class);
        $artists = $artistRepository->findAll();
        //$artists = $em->getRepository(Artist::class)->findAll();

        //$artists = $artistRep->findAll();

        return $this->render('orm/showArtists.html.twig', [
            'artists' => $artists,
            'controller_name' => 'ORM Controller',
        ]);
    }

    /**
     * @Route("/orm/showArtistAlbums/{artistId}",
     *     name="artistAlbums",
     *     defaults={"artistId": 59})
     */
    public function showArtistAlbums(ArtistRepository $artistRepository, AlbumRepository $albumRepository, int $artistId)
    {
        //$artistAlbums = $albumRepository->findAll();

        //first arguement is the 'WHERE' (can be empty, ALL)
        //second orguement is ORDER ('DESC' or 'ASC')
        $artistAlbums = $albumRepository->findBy(
            ['artist' => $artistId],
            ['year' => 'ASC']
        );

        $artist = $artistRepository->findOneBy([
            'id' => $artistId,
        ]);

        return $this->render('orm/showArtistAlbum.html.twig',  [
            'artstId' => $artistId,
            'artistName' => $artist->getName(),
            'artistAlbums' => $artistAlbums,
        ]);
    }

    /**
     * @Route("/orm/showAlbumSongs/{albumId}",
     *     name="albumSongs",
     *     defaults={"albumId": 66})
     */
    public function showAlbumSongs(AlbumRepository $albumRepository, SongRepository $songRepository, int $albumId)
    {
        $albumSongs = $songRepository->findBy(
          ['album' => $albumId],
          ['number' => 'ASC']
        );

        $album = $albumRepository->findOneBy([
            'id' => $albumId,
        ]);

        return $this->render('orm/showAlbumSong.html.twig', [
            'albumId' => $albumId,
            'albumName' => $album->getName(),
            'albumSongs' => $albumSongs,
        ]);
    }

    /**
     * @Route("/orm/addArtist",
     *      name="addArtist")
     */
    public function addArtist(Request $request, EntityManagerInterface $em, ArtistRepository $artistRepository)
    {
        $artist = new Artist();
        $artist->setName("artist name");

        $artistForm = $this->createForm(ArtistType::class, $artist);
        $artistForm->handleRequest($request);

        if($artistForm->isSubmitted() && $artistForm->isValid()) {
            $artist = $artistForm->getData();

            //no duplicate names
            //not used anymore bc validation
            $entity = $artistRepository->findOneBy([
                'name' => $artist->getName(),
            ]);

            if(!$entity) {
            }

            $em->persist($artist);
            $em->flush();

            return $this->redirectToRoute('success');
        }

        return $this->render('orm/addArtist.html.twig', [
            'artistForm' => $artistForm->createView(),
        ]);
    }

    /**
     * @Route("/orm/addAlbum",
     *      name="addAlbum")
     */
    public function addAlbum(Request $request, EntityManagerInterface $em, AlbumRepository $albumRepository)
    {
        $album = new Album();
        $album->setName("new Album");

        $albumForm = $this->createForm(AlbumType::class, $album);
        $albumForm->handleRequest($request);

        if($albumForm->isSubmitted() && $albumForm->isValid()) {
            $album = $albumForm->getData();

            $em->persist($album);
            $em->flush();

            return $this->redirectToRoute('success');
        }

        return $this->render('orm/addAlbum.html.twig', [
            'albumForm' => $albumForm->createView(),
        ]);
    }

    /**
     * @Route("/orm/addSong",
     *      name="addSong")
     */
    public function addSong(Request $request, EntityManagerInterface $em, SongRepository $songRepository)
    {
        $song = new Song();
        $song->setName("new song");

        $songForm = $this->createForm(SongType::class, $song);
        $songForm->handleRequest($request);

        if($songForm->isSubmitted() && $songForm->isValid()) {
            $song = $songForm->getData();

            $em->persist($song);
            $em->flush();

            $flsh = $song->getName();

            $this->addFlash('success', 'added song: '.$flsh);
            return $this->redirectToRoute('showAllArtists');
        }

        return $this->render('orm/addSong.html.twig', [
            'songForm' => $songForm->createView(),
        ]);
    }

    /**
     * @Route("/orm/success",
     *      name="success")
     */
    public function success()
    {
        return $this->render('orm/sussess.html.twig');
    }
}
