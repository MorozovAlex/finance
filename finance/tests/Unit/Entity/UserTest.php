<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Phone;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetAndSetUser(): void
    {
        $user = new User();

        $user->setName(new Name('Tom', 'Mark', 'Sawyer'))
            ->setPhone(new Phone('+79181234567'))
            ->setEmail(new Email('123@mail.com'))
            ->setEducation(1)
            ->setIsPersonalData(false)
            ->setScore(10);

        self::assertEquals(new Name('Tom', 'Mark', 'Sawyer'), $user->getName());
        self::assertEquals(new Phone('+79181234567'), $user->getPhone());
        self::assertEquals(new Email('123@mail.com'), $user->getEmail());
        self::assertSame(1, $user->getEducation());
        self::assertSame(false, $user->isPersonalData());
        self::assertSame(10, $user->getScore());
    }
}