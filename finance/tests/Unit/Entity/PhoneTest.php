<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testGetAndSetPhone(): void
    {
        $phone = new Phone('+79181234567');

        self::assertSame('79181234567', $phone->getValue());
    }

}