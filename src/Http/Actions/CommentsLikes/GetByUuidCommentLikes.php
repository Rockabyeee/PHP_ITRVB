<?php

namespace my\Http\Actions\CommentsLikes;

use my\CommentsLikes;
use my\Exceptions\CommentLikeNotFoundException;
use my\Exceptions\HttpException;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\Repositories\CommentsLikesRepository;
use my\UUID;

class GetByUuidCommentLikes implements ActionInterface
{

    public function __construct(
        private CommentsLikesRepository $commentLikeRepository
    ) { }

    public function handle(Request $request): Response
    {
        try {
            $commentUuid = $request->query('uuid');
        } catch (HttpException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        try {
            $commentLikes = $this->commentLikeRepository->getByCommentUuid(new UUID($commentUuid));
        } catch (CommentLikeNotFoundException $ex) {
            return new ErrorResponse($ex->getMessage());
        }

        $likesData = array_map(function (CommentsLikes $like) {
            return [
                'uuid' => (string)$like->getUuid(),
                'user_uuid' => (string)$like->getUserUuid()
            ];
        }, $commentLikes);

        return new SuccessResponse([
            'comment' => $commentUuid,
            'likes' => $likesData
        ]);
    }
}