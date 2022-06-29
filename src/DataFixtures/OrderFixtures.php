<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Orders;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //create 8 orders! 
        for ($i = 0; $i < 8; $i++) { 
            {
                $order = new Orders();
                $order->setSeller('seller' . $i);
                $order->setDateSold(new \DateTime());
                $order->setIsPaid(rand(TRUE, FALSE));
                $order->setCustomer($this->getReference('user'));
                $order->setPdfRout('/public/PDF/seller/' . $i);
                $manager->persist($order);
                $this->setReference('order', $order);
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
