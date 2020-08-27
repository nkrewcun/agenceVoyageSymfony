<?php

namespace App\DataFixtures;

use App\Entity\Sejour;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SejourFixtures extends Fixture implements DependentFixtureInterface
{
    private $categoryRepository;

    /**
     * SejourFixtures constructor.
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $categories = $this->categoryRepository->findAll();
        $categoriesCount = count($categories);
        for ($i = 0; $i < 50; $i++) {
            $sejour = new Sejour();
            $sejour->setNbPersonne(random_int(1, 15));
            $sejour->setTitre($faker->words(3, true));
            $sejour->setDescription($faker->paragraphs(3, true));
            $sejour->setTypeLogement($faker->word());
            $sejour->setCategory($categories[random_int(0, $categoriesCount-1)]);
            $manager->persist($sejour);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class
        );
    }
}
