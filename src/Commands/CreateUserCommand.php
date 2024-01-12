<?php

namespace my\Commands;

use my\Exceptions\CommandException;
use my\Exceptions\UserNotFoundException;
use my\Names;
use my\Repositories\UsersRepositoryInterface;
use my\Users;
use my\UUID;

class CreateUserCommand
{
    public function __construct(
        private UsersRepositoryInterface $userRepository
    ) {
    }

    public function userExist(string $username): bool {
        try {
            $this->userRepository->getByUsername($username);
        } catch (UserNotFoundException) {
            return false;
        }

        return true;
    }

    public function handle(Arguments $arguments): void {
        $username = $arguments->get('username');

        if ($this->userExist($username)) {
            throw new CommandException(
                "User already exists: $username"
            );
        }

        $this->userRepository->save(new Users(
            UUID::random(),
            $username,
            new Names(
                $arguments->get('first_name'),
                $arguments->get('last_name')
            )
        ));
    }
}