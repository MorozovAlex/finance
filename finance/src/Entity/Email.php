<?php

namespace App\Entity;

use Webmozart\Assert\Assert;

class Email
{
    private ?string $value;

    public function __construct(?string $value)
    {
        Assert::notEmpty($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Incorrect email.');
        }

        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    public function __toString()
    {
        return $this->getValue();
    }
}