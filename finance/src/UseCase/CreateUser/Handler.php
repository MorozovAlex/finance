<?php

namespace App\UseCase\CreateUser;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Phone;
use App\Entity\User;
use App\Service\Flusher;
use App\Service\Persister;

class Handler
{
    public function __construct(
        private readonly Persister $persister,
        private readonly Flusher $flusher,
    ) {}

    public function handle(CreateUserDto $dto): User
    {
        $user = new User();

        $user->setName(new Name($dto->getFirstName(), $dto->getSecondName(), $dto->getLastName()))
            ->setPhone(new Phone($dto->getPhone()))
            ->setEmail(null !== $dto->getEmail() ? new Email($dto->getEmail()) : null)
            ->setEducation($dto->getEducation())
            ->setIsPersonalData($dto->getIsPersonalData())
        ;

        $this->persister->add($user);
        $this->flusher->flush();

        return $user;
    }
}