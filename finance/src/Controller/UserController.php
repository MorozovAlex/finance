<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\UseCase\CreateUser\CreateUserDto;
use App\UseCase\CreateUser\CreteUserForm;
use App\UseCase\CreateUser\Handler;
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

    #[Route(path: '/edite', name: 'edite')]
    public function edite(User $user, Request $request, Handler $handler): Response
    {
        $form = $this->createForm(CreteUserForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command = $form->getData();
                $handler->handle($command);

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

    #[Route(path: '/show', name: 'show')]
    public function show(): Response
    {
        return $this->render('show.html.twig', $this->repository->findAll());
    }
}