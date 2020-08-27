<?php

namespace App\DataFixtures;

use App\Entity\Activite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActiviteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $activity = new Activite();
            $activity->setNom($faker->words(2, true));
            $activity->setImage($faker->imageUrl());
            $manager->persist($activity);
        }
        $manager->flush();
    }
}
