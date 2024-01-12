<?php

namespace ModelTests;

use my\Names;
use my\Users;
use my\UUID;
use PHPUnit\Framework\TestCase;

class UsersTests extends TestCase
{
    public function testGetData(): void {
        $uuid = UUID::random();
        $username = 'username';
        $name = new Names('fN', 'lN');
        $user = new Users($uuid, $username, $name);

        $this->assertEquals($uuid, $user->getUuid());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($name, $user->getName());
    }
}