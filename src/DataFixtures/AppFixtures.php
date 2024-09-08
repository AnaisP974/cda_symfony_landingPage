<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 10; $i++) { 
            $person = new Person();
            $person
                ->setName($faker->firstName())
                ->setLastname($faker->lastName())
                ;

            $manager->persist($person);
        }

        $manager->flush();
    }
}
