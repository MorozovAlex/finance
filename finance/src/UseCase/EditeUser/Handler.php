<?php

namespace App\UseCase\EditeUser;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Phone;
use App\Entity\User;
use App\Service\Flusher;
use App\Service\Persister;
use App\Service\ScoreManager;
use App\UseCase\CreateUser\CreateUserDto;

class Handler
{
    public function __construct(
        private readonly Persister $persister,
        private readonly Flusher $flusher,
        private readonly ScoreManager $scoreManager,
    ) {}

    public function handle(User $user): EditUserDto
    {
//        $user = new User();

//        $user->setName(new Name($dto->getFirstName(), $dto->getSecondName(), $dto->getLastName()))
//            ->setPhone(new Phone($dto->getPhone()))
//            ->setEmail(null !== $dto->getEmail() ? new Email($dto->getEmail()) : null)
//            ->setEducation($dto->getEducation())
//            ->setIsPersonalData($dto->getIsPersonalData())
//            ->setScore($this->scoreManager->getScore($dto->getPhone(), $dto->getEmail(), $dto->getEducation(), $dto->getIsPersonalData()))
//        ;

        $editUserDto =
            new EditUserDto(
                $user->getName()->getLast(),
                $user->getName()->getFirst(),
                $user->getPhone(),
                $user->getName()->getSecond(),
                $user->getEmail(),
                $user->getEducation(),
                $user->isPersonalData(),
                $user->getScore()
            );

//        $this->persister->add($user);
//        $this->flusher->flush();

        return $editUserDto;
    }
}