<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TestFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        $testArtist = new Artist();
        $testAlbum = new Album();

        $testArtist->setName("Ben Rose");
        $testArtist->setSlug("ben");
        $testAlbum->setName("test album");
        $testAlbum->setYear(2019);
        $manager->persist($testArtist);
        $manager->persist($testAlbum);
        $testAlbum->setArtist($testArtist);

        $testSong1 = new Song();
        $testSong1->setName("test song 1");
        $testSong1->setNumber(1);
        $testSong1->setLength(69);
        $testSong1->setAlbum($testAlbum);
        $manager->persist($testSong1);
        
        $manager->flush();
    }
}
