<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class FileUploader
{
    public function __construct(
        private readonly string $uploadDir,
    )  {

    }

    public function upload(
        UploadedFile $file,
    ) : string
    {
        $filename = uniqid('student_') . '.' . $file->guessExtension();
        $file->move($this->uploadDir, $filename);
        return $filename;
    }
}
