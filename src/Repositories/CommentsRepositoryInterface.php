<?php

namespace my\Repositories;

use my\Comments;
use my\UUID;

interface CommentsRepositoryInterface
{
    public function get(UUID $uuid): Comments;
    public function save(Comments $comment): void;
}