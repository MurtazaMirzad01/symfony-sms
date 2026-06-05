<?php

namespace App\EventListener;
use App\Entity\Student;

use App\Service\FileUploader;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

use Doctrine\ORM\Events;
#[AsEntityListener(
    event: Events::postRemove,
    entity: Student::class
)]

class StudentImageListener
{
    public function __construct(
        private readonly FileUploader $uploader
    ) {
    }
    public function postRemove(
        Student $student
    ): void {

        $this->uploader->delete(

            $student
                ->getImageName()

        );
    }

}
