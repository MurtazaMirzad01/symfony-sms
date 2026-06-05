<?php

namespace App\DTO;

readonly class StudentSummary
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $phone,
        public string $createdAt,
        public ?string $imageName,

    )
    {

    }
}
