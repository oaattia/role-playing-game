<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/app/AppKernel.php';

use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

$kernel = new AppKernel('test', true);
$kernel->boot();

$application = new Application($kernel);

// drop database if found
$command = new DropDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput(
    [
        'command' => 'doctrine:database:drop',
        '--force' => true
    ]
);
$command->run($input, new ConsoleOutput());

// create database
$command = new CreateDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput(
    [
        'command' => 'doctrine:database:create',
        '--if-not-exists' => true
    ]
);
$command->run($input, new ConsoleOutput());

 //create the schema
$command = new UpdateSchemaDoctrineCommand();
$application->add($command);
$input = new ArrayInput([
    'command' => 'doctrine:schema:update',
    '--force' => true
]);
$command->run($input, new ConsoleOutput());
