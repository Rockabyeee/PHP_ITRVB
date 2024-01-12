<?php

namespace my\Http\Actions\Comments;

use my\Comments;
use my\Http\Actions\ActionInterface;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\Response;
use my\Http\SuccessResponse;
use my\Repositories\CommentsRepository;
use my\UUID;

class CreateComment implements ActionInterface
{

    public function __construct(
        private CommentsRepository $commentRepository
    ) { }
    public function handle(Request $request): Response
    {
        try {
            $data = $request->body(['author_uuid', 'post_uuid', 'text']);
            $authorUuid = new UUID($data['author_uuid']);
            $postUuid = new UUID($data['post_uuid']);
            $text = $data['text'];

            if (empty($text)) {
                throw new \InvalidArgumentException('Text cannot be empty');
            }

            $comment = new Comments(UUID::random(), $authorUuid, $postUuid, $text);

            $this->commentRepository->save($comment);

            return new SuccessResponse(['message' => 'Comment created successfully']);
        } catch (\Exception $ex) {
            return new ErrorResponse($ex->getMessage());
        }
    }
}