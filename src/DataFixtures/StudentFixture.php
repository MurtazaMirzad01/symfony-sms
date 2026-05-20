<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StudentFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create();

       for ($i = 0; $i < 100; $i++) {
           $student = new Student();
           $student->setName(
               $faker->name
           );
           $student->setEmail(
               $faker->email
           );
           $student->setPhone(
               $faker->phoneNumber()
           );
           $manager->persist($student);
       }

        $manager->flush();
    }
}
