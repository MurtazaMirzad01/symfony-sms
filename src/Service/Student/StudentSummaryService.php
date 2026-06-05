<?php

namespace App\Service\Student;

use App\Entity\Student;
use App\DTO\StudentSummary;

class StudentSummaryService
{
    public function create(
        Student $student,
    ): StudentSummary
    {
        return new StudentSummary(
            id: $student->getId(),
            name: strtoupper(
                $student->getName()
            ),
            email: $student->getEmail(),
            phone: $student->getPhone(),
            createdAt:
                $student
                    ->getCreatedAt()
                        ->format('Y-m-d'),
            imageName: $student->getImageName()
        );
    }
}
