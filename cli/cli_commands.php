<?php

use Danack\Console\Application;
use Danack\Console\Command\Command;
use Danack\Console\Input\InputArgument;

/**
 * @param Application $console
 */
function add_console_commands(Application $console)
{
    addDebugCommands($console);
    addProcessCommands($console);
//    addSeedCommands($console);
//    addMiscCommands($console);
}

/**
 * @param Application $console
 */
function addDebugCommands(Application $console)
{
    $command = new Command('debug:hello', 'PhpOpenDocs\CliController\Debug::hello');
    $command->setDescription("Test cli commands are working.");
    $console->add($command);

//    $command = new Command('debug:debug', 'ASVoting\CliController\Debug::debug');
//    $command->setDescription("Debugging, customise this.");
//    $console->add($command);
}

/**
 * @param Application $console
 */
function addProcessCommands(Application $console)
{
//    $command = new Command('process:alive_check', 'ASVoting\CliController\AliveCheck::run');
//    $command->setDescription("Place holder command to make sure commands are running.");
//    $console->add($command);

    $command = new Command(
        'process:php_bugs:update_max_comment_id',
        'PhpOpenDocs\CliController\ProcessPhpBugs::updateMaxCommentId'
    );
    $command->setDescription("Update the max comment ID.");
    $console->add($command);

}

//function addSeedCommands(Application $console)
//{
//    $command = new Command('seed:initial', 'ASVoting\CliController\DataSeed::seedDatabase');
//    $command->setDescription("Seed the database");
//    $console->add($command);
//}
//
//function addMiscCommands(Application $console)
//{
//    $command = new Command(
//        'misc:wait_for_db',
//        'ASVoting\CliController\Misc::waitForDBToBeWorking'
//    );
//    $command->setDescription("Wait for the database to be online");
//    $console->add($command);
//}