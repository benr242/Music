<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $nin = new Artist();
        $nin->setName("Nine Inch Nails");
        $manager->persist($nin);

        $phm = new Album();
        $phm->setArtist($nin);
        $phm->setName("Pretty Hate Machine");
        $manager->persist($phm);

        $song = new Song();
        $song->setName("Head Like a Hole");
        $song->setAlbum($phm);
        $song->setNumber(1);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Terrible Lie");
        $song->setAlbum($phm);
        $song->setNumber(2);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Down In It");
        $song->setAlbum($phm);
        $song->setNumber(3);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Sancttified");
        $song->setAlbum($phm);
        $song->setNumber(4);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Something I Can Never Have");
        $song->setAlbum($phm);
        $song->setNumber(5);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Kinda I Want To");
        $song->setAlbum($phm);
        $song->setNumber(6);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Sin");
        $song->setAlbum($phm);
        $song->setNumber(7);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("That's What I Get");
        $song->setAlbum($phm);
        $song->setNumber(8);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("The Onlf Time");
        $song->setAlbum($phm);
        $song->setNumber(9);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Ringfinger");
        $song->setAlbum($phm);
        $song->setNumber(10);
        $song->setLength(500);
        $manager->persist($song);

        $manager->flush();
    }
}
