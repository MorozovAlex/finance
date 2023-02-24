<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity]
#[ORM\Table(name: "users",
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'phone')
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'Ramsey\Uuid\Doctrine\UuidGenerator')]
    private int $id;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Embedded(class: Phone::class)]
    private Phone $phone;

    #[ORM\Column(nullable: true)]
    private ?Email $email;

    #[ORM\Column(nullable: true)]
    private ?int $education;

    #[ORM\Column(nullable: true)]
    private ?bool $isPersonalData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function setPhone(Phone $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?Email
    {
        return $this->email;
    }

    public function setEmail(?Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEducation(): ?int
    {
        return $this->education;
    }

    public function setEducation(?int $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function isPersonalData(): ?bool
    {
        return $this->isPersonalData;
    }

    public function setIsPersonalData(?bool $isPersonalData): self
    {
        $this->isPersonalData = $isPersonalData;

        return $this;
    }
}