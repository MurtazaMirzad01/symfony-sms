<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
class StudentCreateDTO
{
    #[Assert\NotBlank]
    public ?string $name = null;
    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;
    public ?int $age = null;
}
