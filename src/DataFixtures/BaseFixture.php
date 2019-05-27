<?php
/**
 * Created by PhpStorm.
 * User: benr242
 * Date: 5/16/19
 * Time: 2:25 PM
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

//https://symfonycasts.com/screencast/symfony-doctrine/fixtures
abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadData($manager);
    }

    abstract protected function loadData(ObjectManager $manager);

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }

        $this->manager->flush();
    }
}