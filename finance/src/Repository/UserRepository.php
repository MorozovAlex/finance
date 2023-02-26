<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class UserRepository
{
    private ObjectRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly PaginatorInterface $paginator,
    )
    {
        $this->repository = $em->getRepository(User::class);
    }

    public function findAll()
    {
        return $this->paginator->paginate($this->repository->findAll(), 1, 25);
    }

}