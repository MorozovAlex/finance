<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testGetAndSetName(): void
    {
        $name = new Name('Tom', 'Mark', 'Sawyer');

        self::assertSame('Tom', $name->getFirst());
        self::assertSame('Mark', $name->getSecond());
        self::assertSame('Sawyer', $name->getLast());
    }
}