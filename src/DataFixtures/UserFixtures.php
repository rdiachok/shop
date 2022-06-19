<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //create 2 users! before start check Email - its Unique!!!
        for ($i = 0; $i < 2; $i++) { 
            {
                $user = new Users();
                $user->setFirstName('firstName' . $i);
                $user->setLastName('lastName' . $i);
                $user->setEmail('exampleDev' . $i . '@gmail.com');
                $user->setRole($user->getRoleUserFixtures(mt_rand(0, 3)));
                $manager->persist($user);
                $this->setReference('user', $user);
            }
        }
        $manager->flush();
    }
}
