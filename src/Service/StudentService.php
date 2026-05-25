<?php

namespace App\Service;

use App\DTO\StudentCreateDTO;
use App\Entity\Student;

class StudentService
{
    public function create(
        StudentCreateDTO $dto
    ): Student
    {
        $student = new Student();
        $student->setName($dto->name);
        $student->setEmail($dto->email);
        return $student;
    }

}
