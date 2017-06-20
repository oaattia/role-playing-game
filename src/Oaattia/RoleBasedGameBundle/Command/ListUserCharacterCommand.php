<?php

namespace Oaattia\RoleBasedGameBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Oaattia\RoleBasedGameBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUserCharacterCommand extends ContainerAwareCommand
{
    use CommandHelper;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ListUsersCommand constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    /**
     * Configure the command
     */
    protected function configure()
    {
        $this
            ->setName('role-base-game:list-user-character')
            ->setDescription('List the current characters for the user we want')
            ->addArgument(
                'user_id',
                InputArgument::REQUIRED,
                'The user id we want to fetch the corresponding characters'
            );
    }

    /**
     * Execute the commands
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $header = [
            'title',
            'attack',
            'defense',
        ];

        $userId = $input->getArgument('user_id');

        $character = $this->getUserCharacter($userId);

        if (is_null($character)) {
            $output->writeln("There is no character for the assigned used id");
            return;
        }

        return $this->renderTable($output, $header, $character);
    }

    /**
     * Get the character related to the user
     *
     * @param $userId
     * @return array|null
     */
    protected function getUserCharacter($userId)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneById($userId);

        if (empty($user->getCharacter())) {
            return null;
        }

        $row = [
            [
                'title' => $user->getCharacter()->getTitle(),
                'attack' => $user->getCharacter()->getAttack(),
                'defense' => $user->getCharacter()->getDefense(),
            ],
        ];

        return $row;
    }

}
