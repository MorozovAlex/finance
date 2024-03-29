<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\UseCase\CreateUser\CreteUserForm;
use App\UseCase\CreateUser\Handler;
use App\UseCase\EditeUser\EditeUserForm;
use App\UseCase\EditeUser\EditUserDto;
use App\UseCase\UserList\UserListForm;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly UserRepository $repository,
    )
    {}

    #[Route(path: '/create', name: 'create')]
    public function create(Request $request, Handler $handler): Response
    {
        $form = $this->createForm(CreteUserForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command = $form->getData();
                $user = $handler->handle($command);

                return $this->redirectToRoute('edite', ['id' => $user->getId()]);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/{id}/edite', name: 'edite')]
    public function edite(User $user, Request $request, \App\UseCase\EditeUser\Handler $handler): Response
    {
        $form = $this->createForm(EditeUserForm::class, EditUserDto::create($user));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command = $form->getData();
                $handler->handle($user, $command);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/list', name: 'list')]
    public function show(Request $request): Response
    {
        $form = $this->createForm(UserListForm::class);
        $form->handleRequest($request);

        return $this->render('index.html.twig', [
            'pagination' => $this->repository->findAllWithPagination(),
            'form' => $form->createView(),
        ]);
    }
}