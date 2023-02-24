<?php

namespace App\Entity;

use Doctrine\DBAL\Types\SmallIntType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity]
#[ORM\Table(name: "user_users",
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'email'),
        new ORM\UniqueConstraint(name: 'phone')
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\Column(name: 'user_user_id', type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?int $id = null;

    #[ORM\Column(name: 'datetime_immutable')]
    private \DateTimeImmutable $date;

    #[ORM\Embedded(class: Name::class)]
    private ?string $name = null;

    #[ORM\Embedded(class: Phone::class)]
    private ?Phone $phone = null;

    #[ORM\Column(nullable: true)]
    private ?Email $email;

    #[ORM\Column(type: SmallIntType::class)]
    private ?int $education;

    #[ORM\Column]
    private bool $isPersonalData;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


}