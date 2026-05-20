<?php

namespace App\Event;
use App\Entity\Student;

class StudentDeletedEvent
{
    public function __construct( private readonly Student $student)
    {

    }
    public function getStudent(): Student
    {
        return $this->student;
    }

}
