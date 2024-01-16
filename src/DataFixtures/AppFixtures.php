<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {

        $user1 = new User();
        $user1->setEmail('nataliagalicka96@gmail.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);



        $userProfile1 = new UserProfile();
        $userProfile1->setName('Natalia96');
        $userProfile1->setGroomName('Mariusz');
        $userProfile1->setBrideName('Natalia');
        $dateTime = new \DateTime('2024-12-16 16:00:00');
        $userProfile1->setWeddingDate($dateTime);
        $userProfile1->setUser($user1);
        $manager->persist($userProfile1);



        /*
        $user1 = new User();
        $user1->setEmail('test1@test.com');

        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )


        );
        $manager->persist($user1);


        $user2 = new User();
        $user2->setEmail('test2@test.com');

        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                '12345678'
            )


        );
        $manager->persist($user2);*/

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
