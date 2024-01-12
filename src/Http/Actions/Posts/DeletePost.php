<?php

namespace my\Http\Actions\Posts;

use my\Exceptions\HttpException;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\Repositories\PostsRepository;

class DeletePost implements ActionInterface
{

    public function __construct(
        private PostsRepository $postRepository
    ) { }

    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid');
            $this->postRepository->delete($uuid);
            return new SuccessResponse(['message' => 'Post deleted successfully']);
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }
    }
}