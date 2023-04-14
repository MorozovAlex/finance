<?php

namespace App\UseCase\EditeUser;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class EditUserDto
{
    public function __construct(
        #[Assert\NotNull]
        private readonly ?string $lastName,

        #[Assert\NotNull]
        private readonly ?string $firstName,

        #[Assert\NotNull]
        private readonly ?string $phone,

        private readonly ?string $secondName = null,

        private readonly ?string $email = null,

        private readonly ?int $education = null,

        #[Assert\NotNull]
        private readonly ?bool $isPersonalData = false,

        private readonly ?int $score = null,
    ) {}

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getEducation(): ?int
    {
        return $this->education;
    }

    public function getIsPersonalData(): ?bool
    {
        return $this->isPersonalData;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public static function create(User $user): EditUserDto
    {
        return new EditUserDto($user->getName()->getLast(),
            $user->getName()->getFirst(),
            $user->getPhone(),
            $user->getName()->getSecond(),
            $user->getEmail(),
            $user->getEducation(),
            $user->isPersonalData(),
            $user->getScore());
    }
}