<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
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

    public function findAllWithPagination(): PaginationInterface
    {
        return $this->paginator->paginate($this->repository->findAll(), 1, 25);
    }

    public function findUser(string $id): ?User
    {
        return $this->repository->find($id);
    }

    public function findAllUser(): array
    {
        return $this->repository->findAll();
    }

}