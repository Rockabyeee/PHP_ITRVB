<?php

namespace my\Http\Actions\CommentsLikes;

use my\CommentsLikes;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\Repositories\CommentsLikesRepository;
use my\UUID;

class CreateCommentLike implements ActionInterface
{

    public function __construct(
        private CommentsLikesRepository $commentLikeRepository
    ) { }

    public function handle(Request $request): Response
    {
        try {
            $data = $request->body(['comment_uuid', 'user_uuid']);
            $uuid = UUID::random();
            $commentUuid = new UUID($data['comment_uuid']);
            $userUuid = new UUID($data['user_uuid']);

            $comment = new CommentsLikes($uuid, $commentUuid, $userUuid);
            $this->commentLikeRepository->save($comment);

            return new SuccessResponse(['message' => 'Post like created successfully']);
        } catch (\Exception $ex) {
            return new ErrorResponse($ex->getMessage());
        }
    }
}