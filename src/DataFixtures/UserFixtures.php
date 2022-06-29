<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        //create 2 users! before start check Email - its Unique!!!
        for ($i = 0; $i < 2; $i++) { 
            {
                $user = new Users();
                $user->setFirstName('firstName' . $i);
                $user->setLastName('lastName' . $i);
                $user->setEmail('exampleDev' . $i . '@gmail.com');
                $user->setRoles([$user->getRoleUserFixtures(mt_rand(0, 3))]);
                $user->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    '1234'
                    )); 
                $manager->persist($user);
                $this->setReference('user', $user);
            }
        }
        $manager->flush();
    }
}
