<?php

namespace App\Entity\DoctrineType;

use App\Entity\Phone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PhoneType extends StringType
{
    public const NAME = 'user_phone_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Phone ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Phone
    {
        return !empty($value) ? new Phone($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}