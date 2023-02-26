<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class Persister
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ){}

    public function add($entity): void
    {
        $this->em->persist($entity);
    }

}