<?php

namespace my\Repositories;

use my\PostsLikes;
use my\UUID;

interface PostsLikesRepositoryInterface
{
    public function save(PostsLikes $postLike);
    public function getByPostUuid(UUID $postUuid);
}