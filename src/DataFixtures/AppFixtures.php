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
        // $product = new Product();
        // $manager->persist($product);



        $nin = new Artist();
        $nin->setName("Nine Inch Nails");
        $manager->persist($nin);

        $phm = new Album();
        $phm->setArtist($nin);
        $phm->setName("Pretty Hate Machine");
        $manager->persist($phm);

        $hlh = new Song();
        $hlh->setName("Head Like a Hole");
        $hlh->setAlbum($phm);
        $hlh->setNumber(1);
        $hlh->setLength(500);
        $manager->persist($hlh);




        $manager->flush();
    }
}
