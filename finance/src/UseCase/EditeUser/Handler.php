<?php

namespace App\UseCase\EditeUser;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Phone;
use App\Entity\User;
use App\Service\Flusher;
use App\Service\ScoreManager;

class Handler
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly ScoreManager $scoreManager,
    ) {}

    public function handle(User $user, EditUserDto $dto): User
    {
        $user->setName(new Name($dto->getFirstName(), $dto->getSecondName(), $dto->getLastName()))
            ->setPhone(new Phone($dto->getPhone()))
            ->setEmail(new Email($dto->getEmail()))
            ->setEducation($dto->getEducation())
            ->setIsPersonalData($dto->getIsPersonalData())
            ->setScore($this->scoreManager->getScore($dto->getPhone(), $dto->getEmail(), $dto->getEducation(), $dto->getIsPersonalData()));

        $this->flusher->flush();

        return $user;
    }

    public function createEditUserDtoByEntity(User $user): EditUserDto
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