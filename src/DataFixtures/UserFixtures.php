<?php

namespace App\DataFixtures;

use App\Entity\OrderItems;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;
use App\Entity\Products;
use App\Entity\Orders;

class UserFixtures extends Fixture
{
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const SALESMAN = 'salesman';
    const CUSTOMER = 'customer';

    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadProduct($manager);
        $this->loadOrder($manager);
        $this->loadOrderItems($manager);
    }

    public function loadUser(ObjectManager $manager): void
    {
        //create 2 users! before start check Email - its Unique!!!
        for ($i = 0; $i < 2; $i++) { {
                $user = new Users();
                $user->setFirstName('firstName' . $i);
                $user->setLastName('lastName' . $i);
                $user->setEmail('exampleDev' . $i . '@gmail.com');
                $user->setRole($this->getUserRole(mt_rand(0, 3)));
                $manager->persist($user);
            }

            $manager->flush();
        }
    }

    private function getUserRole($i)
    {
        $boxRole = [
            self::ADMIN,
            self::MANAGER,
            self::SALESMAN,
            self::CUSTOMER
        ];

        return $boxRole[$i];
    }

    public function loadProduct(ObjectManager $manager): void
    {
        //create 4 products! 
        for ($i = 0; $i < 4; $i++) { {
                $userId = $manager->getRepository(Users::class)->find(rand(1, 2));
                $product = new Products();
                $product->setName('name' . $i);
                $product->setMaker('maker' . $i);
                $product->setPrice($i);
                $product->setDateCreate(new \DateTime());
                $product->setSumm($i);
                $product->setUserAdd($userId);
                $manager->persist($product);
            }

            $manager->flush();
        }
    }

    public function loadOrder(ObjectManager $manager): void
    {
        //create 8 orders! 
        for ($i = 0; $i < 8; $i++) { {
                $userId = $manager->getRepository(Users::class)->find(rand(1, 2));
                $order = new Orders();
                $order->setSeller('seller' . $i);
                $order->setDateSold(new \DateTime());
                $order->setIsPaid(rand(TRUE, FALSE));
                $order->setCustomer($userId);
                $manager->persist($order);
            }

            $manager->flush();
        }
    }

    public function loadOrderItems(ObjectManager $manager): void
    {
        //create 8 order items! 
        for ($i = 0; $i < 8; $i++) { {
                $producteId = $manager->getRepository(Products::class)->find(rand(1, 4));
                $orderId = $manager->getRepository(Orders::class)->find(rand(1, 8));
                $orderItems = new OrderItems();
                $orderItems->setOrderId($orderId);
                $orderItems->setProduct($producteId);
                $orderItems->setNumber(rand(1,10));
                $manager->persist($orderItems);
            }

            $manager->flush();
        }
    }
}
