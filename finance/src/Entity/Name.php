<?php

namespace App\Entity;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
class Name
{
    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $first;

    #[ORM\Column(type: Types::STRING, length: 100, nullable: true)]
    private ?string $second;

    #[ORM\Column(type: Types::STRING, length: 100)]
    private string $last;

    public function __construct(string $first, ?string $second, string $last)
    {
        Assert::notEmpty($first);
        Assert::notEmpty($last);

        $this->first = $first;
        $this->second = $second;
        $this->last = $last;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getSecond(): ?string
    {
        return $this->second;
    }

    public function getLast(): string
    {
        return $this->last;
    }

    public function getFull(): string
    {
        return $this->last . ' ' . $this->first . ' ' . $this->second;
    }

    public function __toString()
    {
        return $this->getFull();
    }
}