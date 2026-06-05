<?php

namespace App\Service;
use App\Entity\Student;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StudentImageManager
{
    public function __construct(
        private readonly FileUploader $uploader
    ) {
    }

    public function uploadImage(
        Student $student,
        UploadedFile $file
    ): void
    {
        $fileName = $this->uploader
                        ->upload($file);
        $student->setImageName($fileName);
    }

    public function replaceImage(Student $student, UploadedFile $file): void
    {
        $this->uploader
                    ->delete($student->getImageName());
        $fileName = $this->uploader
            ->upload($file);
        $student->setImageName($fileName);
    }

}
