<?php

use my\Commands\Arguments;
use my\Commands\CreateUserCommand;
use my\Exceptions\CommandException;
use my\Repositories\UsersRepository;

require_once __DIR__ . '/vendor/autoload.php';

$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

$userRepository = new UsersRepository($connection);

$command = new CreateUserCommand($userRepository);

try {
    $command->handle(Arguments::fromArgv($argv));
} catch (CommandException $error) {
    echo "{$error->getMessage()}\n";
}