<?php

namespace my\Repositories;

use my\Users;
use my\UUID;

interface UsersRepositoryInterface
{
    public function save(Users $user): void;
    public function get(UUID $uuid): Users;
    public function getByUsername(string $username): Users;
}