<?php

namespace App\DataFixtures;

use App\Entity\CheckListCategory;
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

        $category1 = new CheckListCategory();
        $category1->setName('Etap planowania');
        $manager->persist($category1);

        $category2 = new CheckListCategory();
        $category2->setName('Sala weselna');
        $manager->persist($category2);

        $category3 = new CheckListCategory();
        $category3->setName('Fotograf');
        $manager->persist($category3);

        $category4 = new CheckListCategory();
        $category4->setName('Kamerzysta');
        $manager->persist($category4);

        $category5 = new CheckListCategory();
        $category5->setName('Oprawa muzyczna wesela');
        $manager->persist($category5);

        $category6 = new CheckListCategory();
        $category6->setName('Goście');
        $manager->persist($category6);

        $category7 = new CheckListCategory();
        $category7->setName('Podziękowania');
        $manager->persist($category7);

        $category8 = new CheckListCategory();
        $category8->setName('Panna Młoda');
        $manager->persist($category8);

        $category9 = new CheckListCategory();
        $category9->setName('Pan Młody');
        $manager->persist($category9);

        $category10 = new CheckListCategory();
        $category10->setName('Papeteria');
        $manager->persist($category10);

        $category11 = new CheckListCategory();
        $category11->setName('Obrączki');
        $manager->persist($category11);

        $category12 = new CheckListCategory();
        $category12->setName('Pierwszy taniec');
        $manager->persist($category12);

        $category13 = new CheckListCategory();
        $category13->setName('Kościół, USC');
        $manager->persist($category13);

        $category14 = new CheckListCategory();
        $category14->setName('Przygotowania');
        $manager->persist($category14);

        $category15 = new CheckListCategory();
        $category15->setName('Transport i nocleg');
        $manager->persist($category15);

        $category16 = new CheckListCategory();
        $category16->setName('Kwiaty i dekoracje');
        $manager->persist($category16);





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
