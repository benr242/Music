<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $nin = new Artist();
        $nin->setName("Nine Inch Nails");
        $nin->setSlug("nin");
        $manager->persist($nin);

        $phm = new Album();
        $phm->setArtist($nin);
        $phm->setName("Pretty Hate Machine");
        $phm->setYear(1989);
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

        $a23 = new Artist();
        $a23->setName("Assemblage 23");
        $a23->setSlug("a23");
        $manager->persist($a23);

        $storm = new Album();
        $storm->setArtist($a23);
        $storm->setName("Storm");
        $storm->setYear(2004);
        $manager->persist($storm);


        $song = new Song();
        $song->setName("Human");
        $song->setAlbum($storm);
        $song->setNumber(1);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Skin");
        $song->setAlbum($storm);
        $song->setNumber(2);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Ground");
        $song->setAlbum($storm);
        $song->setNumber(3);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Let the Wind Erase Me");
        $song->setAlbum($storm);
        $song->setNumber(4);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Infinite");
        $song->setAlbum($storm);
        $song->setNumber(5);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Complacent");
        $song->setAlbum($storm);
        $song->setNumber(6);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("You Haven't Earned It");
        $song->setAlbum($storm);
        $song->setNumber(7);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Regret");
        $song->setAlbum($storm);
        $song->setNumber(8);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("Apart");
        $song->setAlbum($storm);
        $song->setNumber(9);
        $song->setLength(500);
        $manager->persist($song);

        $song = new Song();
        $song->setName("30kft");
        $song->setAlbum($storm);
        $song->setNumber(10);
        $song->setLength(500);
        $manager->persist($song);

        $manager->flush();
    }
}
