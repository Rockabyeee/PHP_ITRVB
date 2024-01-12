<?php

namespace my\Http\Actions\PostsLikes;

use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\PostsLikes;
use my\Repositories\PostsLikesRepository;
use my\UUID;

class CreatePostLike implements ActionInterface
{

    public function __construct(
        private PostsLikesRepository $postLikeRepository
    )
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $data = $request->body(['post_uuid', 'user_uuid']);
            $uuid = UUID::random();
            $postUuid = new UUID($data['post_uuid']);
            $userUuid = new UUID($data['user_uuid']);

            $post = new PostsLikes($uuid, $postUuid, $userUuid);
            $this->postLikeRepository->save($post);

            return new SuccessResponse(['message' => 'Post like created successfully']);
        } catch (\Exception $ex) {
            return new ErrorResponse($ex->getMessage());
        }
    }
}