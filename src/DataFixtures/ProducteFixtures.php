<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Products;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProducteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 4; $i++) { {
                $product = new Products();
                $product->setName('name' . $i);
                $product->setMaker('maker' . $i);
                $product->setPrice($i);
                $product->setDateCreate(new \DateTime());
                $product->setSumm($i);
                $product->setUserAdd($this->getReference('user'));
                $manager->persist($product);
                $this->setReference('product', $product);
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
