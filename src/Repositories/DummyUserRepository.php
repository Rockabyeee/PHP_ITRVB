<?php

namespace my\Repositories;

use my\Exceptions\UserNotFoundException;
use my\Users;
use my\UUID;

class DummyUserRepository implements UsersRepositoryInterface
{
    private array $users = [];

    public function save(Users $user): void
    {
        $this->users[] = $user;
    }

    public function get(UUID $uuid): Users
    {
        foreach ($this->users as $user) {
            if ((string)$user->uuid() === (string)$uuid) {
                return $user;
            }
        }

        throw new UserNotFoundException("User not found: $uuid");
    }

    public function getByUsername(string $username): Users
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }

        throw new UserNotFoundException("User not found: $username");
    }
}