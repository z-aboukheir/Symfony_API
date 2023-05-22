<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Country;
use Faker\Factory;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $country = new Country();
            $country
                ->setName($faker->name())
                ->setCountryCode($faker->countryCode());
                
                $manager->persist($country);
            }

        $manager->flush();
    }
}