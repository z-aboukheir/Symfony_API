<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Animals;
use App\Entity\Country;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnimalsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $countries = $manager->getRepository(Country::class)->findAll();
        dump($countries);

        for ($i = 0; $i < 100; $i++) {
            $animal = new Animals();
            $animal
                ->setName($faker->name())
                ->setAverageSize($faker->numberBetween(10, 200))
                ->setAverageLife($faker->numberBetween(1, 200))
                ->setNumber($faker->phoneNumber())
                ->setMartialArt($faker->randomElement(['Karaté', 'Judo', 'Jiu-Jitsu brésilien', 'Kung Fu', 'Muay Thai']))
                ->setCountry($faker->randomElement($countries));

            $manager->persist($animal);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CountryFixtures::class];
    }
}
