<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\OrderItems;

class OrderItemsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 8; $i++) { 
            {
                $orderItems = new OrderItems();
                $orderItems->setOrderId($this->getReference('order'));
                $orderItems->setProduct($this->getReference('product'));
                $orderItems->setQuantity(rand(1, 10));
                $manager->persist($orderItems);
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            OrderFixtures::class,
            ProducteFixtures::class,
        ];
    }
}
