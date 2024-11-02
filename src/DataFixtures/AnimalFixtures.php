<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AnimalFixtures extends Fixture
{
    public function __construct( private EntityManagerInterface $entityManager)
    {
    }
    
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        $typesAndBreeds = Animal::TYPES_AND_BREED;
        $animals = [];
        foreach ($typesAndBreeds as $type => $breeds)
        {
            for ($i = 0; $i < 5; $i++) {
                foreach($breeds as $breed)
                {
                    for ($b = 0; $b < 3; $b++) {
                        $animal = new Animal();
                        $animal->setName($this->faker->firstName);
                        $animal->setAge($this->faker->numberBetween(1, 10));
                        $animal->setType($type);
                        $animal->setBreed($breed);
                        $animal->setDescription($this->faker->realText(200));
                        $animal->setPriceTTC($this->faker->randomFloat(2, 5000, 90000));
                        $animal->setPriceHT($animal->getPriceTTC() * 0.9);
                        for ($c = 0; $c <= 3; $c++) {
                            $mediaUrl = "/uploads/media/Animals/$type/$type.jpg";
                            $media = new Media();
                            $media->setPath($mediaUrl);
                            $media->setPosition($c);
                            $animal->addMedia($media);
                            $animals[] = $animal;
                        }
                    }
                }   
            }
        }

        shuffle($animals);
        foreach($animals as $animal) {
            $manager->persist($animal);
        }
        $manager->flush();
    }
}
