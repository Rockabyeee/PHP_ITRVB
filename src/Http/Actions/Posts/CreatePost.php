<?php

namespace my\Http\Actions\Posts;

use my\Exceptions\InvalidArgumentException;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\Posts;
use my\Repositories\PostsRepository;
use my\UUID;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepository $postRepository
    ) { }
    public function handle(Request $request): Response
    {
        try {
            $data = $request->body(['author_uuid', 'title', 'text']);
            $uuid = UUID::random();
            $authorUuid = new UUID($data['author_uuid']);
            $title = $data['title'];
            $text = $data['text'];

            if (empty($title) || empty($text)) {
                throw new InvalidArgumentException('Title or text cannot be empty');
            }

            $post = new Posts($uuid, $authorUuid, $title, $text);
            $this->postRepository->save($post);


            return new SuccessResponse(['message' => 'Post created successfully']);
        } catch (\Exception $ex) {
            return new ErrorResponse($ex->getMessage());
        }
    }
}