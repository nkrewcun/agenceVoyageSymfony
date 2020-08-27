<?php

namespace App\DataFixtures;

use App\Entity\Destination;
use App\Repository\SejourRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DestinationFixtures extends Fixture implements DependentFixtureInterface
{

    private $sejourRepository;
    /**
     * DestinationFixtures constructor.
     */
    public function __construct(SejourRepository $sejourRepository)
    {
        $this->sejourRepository = $sejourRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $sejours = $this->sejourRepository->findAll();

        for ($i = 0; $i < 50; $i++) {
            $destination = new Destination();
            $destination->setLieu($faker->city);
            $destination->setType($faker->word);
            $destination->setPays($faker->country);
            $destination->setDateOuverture($faker->dateTimeThisDecade($max = 'now', $timezone = null));
            $destination->setNbStar(random_int(1, 5));
            $sejoursCount = count($sejours);
            $sejour = random_int(0, $sejoursCount-1);
            $destination->setSejour($sejours[$sejour]);
            array_splice($sejours, $sejour, 1);
            $manager->persist($destination);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SejourFixtures::class
        );
    }
}
