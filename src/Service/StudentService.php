<?php

namespace App\Service;

use App\DTO\StudentCreateDTO;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class StudentService
{
    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {

    }
    public function create(
        StudentCreateDTO $dto
    ): Student
    {
        $student = new Student();
        $student->setName($dto->name);
        $student->setEmail($dto->email);
        $this->em->persist($student);
        $this->em->flush();
        return $student;
    }
    public function save(
        Student $student
    ): void
    {
     $this->em->persist($student);
     $this->em->flush();
    }
    public function delete(Student $student): void
    {
        $this->em->remove($student);
        $this->em->flush();
    }

}
