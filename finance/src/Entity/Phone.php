<?php

namespace App\Entity;

use IsoCodes\PhoneNumber;
use Webmozart\Assert\Assert;

class Phone
{
    private int $value;

    public const MAX_LENGTH = 15;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $value = preg_replace("/[^0-9]/", "", $value);
        $this->validate($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }

    private function validate(string $phone): void
    {
        if (mb_strlen($phone) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf(
                'Phone too long. Limit is "%s" characters',
                Phone::MAX_LENGTH
            ));
        }

        if (false === PhoneNumber::validate($phone, 'RU')) {
            throw new \InvalidArgumentException('The phone format is wrong');
        }
    }
}