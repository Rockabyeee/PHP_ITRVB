<?php

namespace my\Repositories;

use my\Comments;

interface CommentsRepositoryInterface
{
    public function get(string $uuid): Comments;
    public function save(Comments $comment): void;
}