<?php

namespace Oaattia\RoleBasedGameBundle\Command;


use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

trait CommandHelper
{

    /**
     * Render the output users
     *
     * @param OutputInterface $output
     * @param array $headers
     * @param array $rows
     */
    protected function renderTable(OutputInterface $output, array $headers, array $rows)
    {
        $table = new Table($output);

        $table
            ->setHeaders($headers)
            ->setRows($rows);


        $table->render();
    }
}