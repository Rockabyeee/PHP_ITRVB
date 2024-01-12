<?php

namespace my\Http\Actions\PostsLikes;

use my\Exceptions\HttpException;
use my\Exceptions\PostLikeNotFoundException;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\PostsLikes;
use my\Repositories\PostsLikesRepository;
use my\UUID;

class GetByUuidPostLikes implements ActionInterface
{

    public function __construct(
        private PostsLikesRepository $postLikeRepository
    )
    {

    }
    public function handle(Request $request): Response
    {
        try {
            $postUuid = $request->query('uuid');
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        try {
            $postLikes = $this->postLikeRepository->getByPostUuid(new UUID($postUuid));
        } catch (PostLikeNotFoundException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        $likesData = array_map(function (PostsLikes $like) {
            return [
                'uuid' => (string)$like->getUuid(),
                'user_uuid' => (string)$like->getUserUuid()
            ];
        }, $postLikes);

        return new SuccessResponse([
            'post' => $postUuid,
            'likes' => $likesData
        ]);
    }
}