<?php

namespace Oaattia\RoleBasedGameBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Oaattia\RoleBasedGameBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListUsersCommand extends ContainerAwareCommand
{
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

    protected function configure()
    {
        $this
            ->setName('role-based-game:list-users')
            ->setDescription('This command to list all the users in our app')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Get limit users returned')
            ->addOption('offset', null, InputOption::VALUE_OPTIONAL, 'Get offset users returned')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = null;
        $offset = null;

        if ($input->getOption('limit')) {
            $limit = $input->getOption('limit');
        }

        if ($input->getOption('offset')) {
            $offset = $input->getOption('offset');
        }

        $rows = $this->getUsers($limit, $offset);

        $this->renderTable($output, $rows);

    }

    /**
     * Render the output users
     *
     * @param OutputInterface $output
     * @param $rows
     */
    protected function renderTable(OutputInterface $output, $rows):void
    {
        $table = new Table($output);

        $table
            ->setHeaders(['id', 'email'])
            ->setRows($rows);


        $table->render();
    }

    /**
     * Get the users
     *
     * @param $limit
     * @param $offset
     * @return array
     */
    protected function getUsers($limit = null , $offset = null):array
    {
        $users = $this->entityManager->getRepository(User::class)->findBy(
            [],
            ['id' => 'ASC'],
            $limit,
            $offset
        );

        $rows = [];

        foreach ($users as $key => $user) {
            $rows[$key]['id'] = $user->getId();
            $rows[$key]['email'] = $user->getEmail();
        }

        return $rows;
    }

}
