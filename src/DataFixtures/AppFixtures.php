<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $finder = new Finder():
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
