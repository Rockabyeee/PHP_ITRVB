<?php

use my\Commands\Arguments;
use my\Commands\CreateUserCommand;
use my\Exceptions\CommandException;
use my\Exceptions\UserNotFoundException;
use my\Names;
use my\Repositories\UsersRepositoryInterface;
use my\Users;
use my\UUID;

class CreateUserCommandTests extends \PHPUnit\Framework\TestCase
{
    private $userRepository;
    private $createUserCommand;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UsersRepositoryInterface::class);
        $this->createUserCommand = new CreateUserCommand($this->userRepository);
    }

    public function testHandleCreatesUserWhenNotExists(): void
    {
        $this->userRepository
            ->method('getByUsername')
            ->will($this->throwException(new UserNotFoundException()));

        $arguments = $this->createMock(Arguments::class);
        $arguments->method('get')
            ->willReturnMap([
                ['username', 'testuser'],
                ['first_name', 'Test'],
                ['last_name', 'User']
            ]);

        $this->userRepository
            ->expects($this->once())
            ->method('save');

        $this->createUserCommand->handle($arguments);

        $this->assertTrue(true);
    }

    public function testHandleThrowsExceptionWhenUserExists(): void
    {
        $this->expectException(CommandException::class);
        $this->expectExceptionMessage("User already exists: testuser");

        $username = 'testuser';
        $uuid = UUID::random();
        $this->userRepository
            ->method('getByUsername')
            ->willReturn(new Users(
                $uuid,
                $username,
                new Names(
                    "firstName",
                    "lastName"
                )
            ));

        $arguments = $this->createMock(Arguments::class);
        $arguments->method('get')
            ->willReturn($username);

        $this->createUserCommand->handle($arguments);
    }
}