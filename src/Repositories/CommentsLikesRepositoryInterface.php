<?php

namespace my\Repositories;

use my\CommentsLikes;
use my\UUID;

interface CommentsLikesRepositoryInterface
{
    public function save(CommentsLikes $commentLike);
    public function getByCommentUuid(UUID $commentUuid);
}