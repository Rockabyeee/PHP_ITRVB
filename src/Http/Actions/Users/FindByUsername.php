<?php

namespace my\Http\Actions\Users;

use my\Exceptions\HttpException;
use my\Exceptions\UserNotFoundException;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\Repositories\UsersRepository;

class FindByUsername implements ActionInterface
{
    public function __construct(
        private UsersRepository $userRepository
    ) {}

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        try {
            $user = $this->userRepository->getByUsername($username);
        } catch (UserNotFoundException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        return new SuccessResponse([
            'username' => $user->getUsername(),
            'name' => (string)$user->getName()
        ]);
    }
}