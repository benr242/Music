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
use Symfony\Component\HttpFoundation\Session\Session;

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
        $em = $this->getDoctrine()->getManager();
        $artistRepository = $em->getRepository(Artist::class);
        $artist = $artistRepository->findOneBy([
            'slug' => 'nun',
        ]);

        $em->remove($artist);
        $em->flush();

        return new Response("test response");
    }

    /**
     * @Route("/orm/showAllArtists",
     *     name="showAllArtists")
    */
    public function showAllArtists(EntityManagerInterface $em, ArtistRepository $artistRepo)
    {
        //injected repository
        //$artistRepository = $em->getRepository(Artist::class);
        $artists = $artistRepo->findAll();
        //$artists = $em->getRepository(Artist::class)->findAll();

        //$artists = $artistRep->findAll();

        return $this->render('orm/showArtists.html.twig', [
            'artists' => $artists,
            'controller_name' => 'ORM Controller',
            'testkey' => "test value",
        ]);
    }

    /**
         * @Route("/orm/showArtistAlbums/{artistId}",
     *     name="artistAlbums",
     *     defaults={"artistId": 0})
     */
    public function showArtistAlbums(ArtistRepository $artistRepository, AlbumRepository $albumRepository, int $artistId)
    {
        if(!$artistId) {
            return $this->render('orm/index.html.twig', [
                'controller_name' => 'ORMController',
            ]);
        }

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
            'artistId' => $artist->getId(),
            'artistName' => $artist->getName(),
            'artistAlbums' => $artistAlbums,
        ]);
    }

    /**
     * @Route("/orm/showAlbumSongs/{artistId}/{albumId}",
     *     name="albumSongs",
     *     defaults={"albumId": 0})
     */
    public function showAlbumSongs(AlbumRepository $albumRepository, SongRepository $songRepository, int $albumId)
    {
        if(!$albumId) {
            return $this->render('orm/index.html.twig', [
                'controller_name' => 'ORMController',
            ]);
        }

        $album = $albumRepository->findOneBy([
            'id' => $albumId,
        ]);

        $albumSongs = $songRepository->findBy(
          ['album' => $album],
          ['number' => 'ASC']
        );

        $artist = $album->getArtist();
        $artistId = $artist->getId();

        return $this->render('orm/showAlbumSong.html.twig', [
            'artistId' => $artistId,
            'artistName' => $album->getArtist()->getName(),
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
                $em->persist($artist);
                $em->flush();
                $flash = $artist->getName();
                $this->addFlash('success', 'added artist: ' . $flash);
            }


            return $this->redirectToRoute('showAllArtists');
        }

        return $this->render('orm/addArtist.html.twig', [
            'artistForm' => $artistForm->createView(),
        ]);
    }

    /**
     * @Route("/orm/addAlbum/{artistId}",
     *          defaults={"artistId" = 0},
     *          name="addAlbum")
     */
    public function addAlbum(Request $request, EntityManagerInterface $em, AlbumRepository $albumRepository, int $artistId)
    {
        $album = new Album();
        $album->setName("new Album");

        $albumForm = $this->createForm(AlbumType::class, $album);
        $albumForm->handleRequest($request);

        if($albumForm->isSubmitted() && $albumForm->isValid()) {
            $album = $albumForm->getData();

            //$album->setName("DUMMY");

            $em->persist($album);
            $em->flush();

            dump($album);

            $artist = $album->getArtist();
            $artistId = $artist->getId();
            $artistName = $artist->getName();

            $flash = $album->getName().", ";
            $this->addFlash('success', 'added album: '.$flash."<".$artistName.">");

            return $this->redirectToRoute('artistAlbums', ['artistId' => $artistId]);
        }

        return $this->render('orm/addAlbum.html.twig', [
            'albumForm' => $albumForm->createView(),
            'artistId' => $artistId,

        ]);
    }

    /**
     * @Route("/orm/artistAddAlbum/{artistId}",
     *      defaults={"artistId" = 0},
     *      name="artistAddAlbum")
    */
    public function artistAddAlbum(Request $request, int $artistId, EntityManagerInterface $em, ArtistRepository $ar, AlbumRepository $albumRepository)
    {
        $album = new Album();
        $album->setName("new Album");

        $artist = $ar->findOneBy([
            'id' => $artistId,
        ]);

        if ($artist) {
            $album->setArtist($artist);
        }

        $albumForm = $this->createForm(AlbumType::class, $album);
        $albumForm->handleRequest($request);

        if($albumForm->isSubmitted() && $albumForm->isValid()) {
            $album = $albumForm->getData();

            //$album->setName("DUMMY");

            $em->persist($album);
            $em->flush();

            dump($album);

            $artist = $album->getArtist();
            $artistId = $artist->getId();
            $artistName = $artist->getName();

            $flash = $album->getName().", ";
            $this->addFlash('success', 'added album: '.$flash."<".$artistName.">");

            return $this->redirectToRoute('artistAlbums', ['artistId' => $artistId]);
        }

        return $this->render('orm/addAlbum.html.twig', [
            'albumForm' => $albumForm->createView(),
            'artistId' => $artistId,
        ]);
    }

    /**
     * @Route("/orm/albumAddSong/{albumId}",
     *     defaults={"albumId" = 0},
     *     name="albumAddSong")
     */
    public function albumAddSong(Request $request, int $albumId, EntityManagerInterface $em, AlbumRepository $ar, SongRepository $sr)
    {
        $song = new Song();
        $song->setName("new Song");

        $album = $ar->findOneBy([
            'id' => $albumId,
        ]);
        $song->setAlbum($album);
        $artistEntity = $album->getArtist();

        $songForm = $this->createForm(SongType::class, $song);
        $songForm->handleRequest($request);

        if ($songForm->isSubmitted() && $songForm->isValid()) {
            $song = $songForm->getData();

            $em->persist($song);
            $em->flush();

            $album = $song->getAlbum();
            $albumId = $album->getId();
            $artist = $album->getArtist();
            $artistId = $artist->getId();

            $albumName = $album->getName();

            $flash = $albumName.", ".$song->getName();
            $this->addFlash('success', 'added song: '.$flash);

            return $this->redirectToRoute('albumSongs', [
                'artistId' => $artistId,
                'albumId' => $albumId,
            ]);
            //artistId albumId
        }

        return $this->render('orm/addSong.html.twig', [
            'songForm' => $songForm->createView(),
            'albumId' => $albumId,
            'artistId' => $artistEntity->getId(),
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

            $album = $song->getAlbum();
            $albumName = $album->getName();
            $artist = $album->getArtist();
            $artistName = $artist->getName();
            $arAl = $artistName.":".$albumName;

            $flash = $song->getName();
            $this->addFlash('success', 'added song: '.$flash." <".$artistName.">:<".$albumName.">");

            return $this->redirectToRoute('albumSongs', [
                'artistId' => $artist->getId(),
                'albumId' => $album->getId()
            ]);
        }

        return $this->render('orm/addSong.html.twig', [
            'songForm' => $songForm->createView(),
        ]);
    }

    /**
     * @Route("/orm/removeSong/{songId}",
     *     name="removeSong")
     */
    public function removeSong(int $songId, EntityManagerInterface $em, SongRepository $sr)
    {
        $song = $sr->find($songId);
        $album = $song->getAlbum();
        $artist = $album->getArtist();

        $album->removeSong($song);

        $em->remove($song);
        $em->flush();

        return $this->redirectToRoute('albumSongs', [
            'artistId' => $artist->getId(),
            'albumId' => $album->getId()
        ]);
    }

    /**
     * @Route("/orm/removeAlbum/{albumId}",
     *     name="removeAlbum")
     */
    public function removeAlbum(int $albumId, EntityManagerInterface $em, AlbumRepository $ar)
    {
        $album = $ar->find($albumId);
        $artist = $album->getArtist();

        $artist->removeAlbum($album);

        $em->remove($album);
        $em->flush();

        return $this->redirectToRoute('artistAlbums', [
            'artistId' => $artist->getId(),
        ]);
    }

    /**
     * @Route("/orm/removeArtist/{artistId}",
     *    name="removeArtist")
     */
    public function removeArtist(int $artistId, EntityManagerInterface $em, ArtistRepository $ar)
    {
        $artist = $ar->find($artistId);

        $em->remove($artist);
        $em->flush();

        return $this->redirectToRoute('showAllArtists');
    }

    /**
     * @Route("/orm/clearAll",
     *  name="clearAll")
     */
    public function clearAll(EntityManagerInterface $em, ArtistRepository $ar)
    {
        $artists = $ar->findAll();

        foreach ($artists as $artist) {
            $em->remove($artist);
        }
        $em->flush();

        return $this->redirectToRoute('showAllArtists');
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
