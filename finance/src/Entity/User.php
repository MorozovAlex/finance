<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'users',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'phone')
    ]
)]
class User
{
    private const SECONDARY = 1;
    private const SPECIAL = 2;
    private const HIGH = 3;
    public const EDUCATION = [
        self::SECONDARY,
        self::SPECIAL,
        self::HIGH,
    ];

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'Ramsey\Uuid\Doctrine\UuidGenerator')]
    private string $id;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Column(type: 'user_phone', length: 15)]
    private Phone $phone;

    #[ORM\Column(type: 'user_email', length: 100, nullable: true)]
    private ?Email $email;

    #[Assert\Choice(self::EDUCATION)]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $education;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isPersonalData = false;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $score;

    public function getId(): string
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

    public function isPersonalData(): bool
    {
        return $this->isPersonalData;
    }

    public function setIsPersonalData(bool $isPersonalData): self
    {
        $this->isPersonalData = $isPersonalData;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }
}