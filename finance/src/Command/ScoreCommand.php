<?php

namespace App\Command;

use App\Repository\UserRepository;
use App\Service\Flusher;
use App\Service\Persister;
use App\Service\ScoreManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:-score',
    description: 'Calculate score',
    hidden: false,
)]
class ScoreCommand extends Command
{
    public function __construct(
        private readonly Persister $persister,
        private readonly Flusher $flusher,
        private readonly ScoreManager $scoreManager,
        private readonly UserRepository $userRepository,
        $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->addArgument('id', InputArgument::OPTIONAL, 'User id')
        ;
    }

    protected function execute(?InputInterface $input, OutputInterface $output): int
    {
        $userId = $input->getArgument('id');
        $userList = is_null($userId) ? $this->userRepository->findAllUser() : $this->userRepository->findUser($userId);

        foreach ($userList as $user) {
            $user->setScore($this->scoreManager->getScore(intval($user->getPhone()->getValue()), $user->getEmail(), $user->getEducation(), $user->isPersonalData()));
            $this->persister->add($user);
        }

        $this->flusher->flush();

        return Command::SUCCESS;
    }
}