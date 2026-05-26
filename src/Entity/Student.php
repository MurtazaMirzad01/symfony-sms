<?php

namespace App\Entity;

use App\EventListener\StudentEntityListener;
use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{

    public function __construct()
    {
        $this->createdAt =
            new \DateTimeImmutable();
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        ['student:list']
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Name is required'
    )]
    #[Assert\Length(
        min: 3,
        minMessage: 'Name must be at least {{ limit }} characters'
    )]
    #[Groups(
        [
            'student:list',
            'student:detail'
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Email is required'
    )]
    #[Assert\Email(
        message: 'Please enter a valid email'
    )]
    #[Groups(
        [
            'student:list',
            'student:detail'
        ]
    )]
    private ?string $email = null;

    #[ORM\Column(
        nullable: true
    )]
    #[Assert\Regex(
        pattern: '/^(\\+93|0)?7[0-9]{8}$/',
        message: 'Invalid phone number'
    )]
    #[Assert\Length(
        min: 10,
        max: 15,
        minMessage: 'Phone number is too short',
        maxMessage: 'Phone number is too long'
    )]
    #[Groups(["student.detail"])]
    private ?string $phone = null;

    #[ORM\Column]
    #[Groups(
        ['student:detail']
    )]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
