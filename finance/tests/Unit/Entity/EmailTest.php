<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testGetAndSetEmail()
    {
        $email = new Email('123@mail.com');

        self::assertSame('123@mail.com', $email->getValue());
    }
}