<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = factory::create();

        $numStudents = 10;
        for ($i=0; $i < $numStudents; $i++) {
            $name = $faker->firstNameMale;
            $student = new Student();
            $student->setName($name);
            $manager->persist($student);
        }

        $manager->flush();
    }
}
