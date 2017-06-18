<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

$kernel = new AppKernel('test', true);
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);

deleteDatabase();
executeCommand($application, "doctrine:database:create");
executeCommand($application, "doctrine:schema:create");

/**
 * Execute Commands
 *
 * @param $application
 * @param $command
 * @param array $options
 */
function executeCommand($application, $command, Array $options = array()) {
    $options["--env"] = "test";
    $options["--quiet"] = true;     // to remove verbose messages
    $options = array_merge($options, array('command' => $command));

    $application->run(new ArrayInput($options));
}

/**
 * Delete the current created database
 */
function deleteDatabase() {
    $folder = __DIR__ . '/var/cache/test/';
    foreach(array('test.db','test.db.bk') as $file){
        if(file_exists($folder . $file)){
            unlink($folder . $file);
        }
    }
}
