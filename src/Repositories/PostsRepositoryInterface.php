<?php

namespace my\Repositories;

use my\Posts;
use my\UUID;

interface PostsRepositoryInterface
{
    public function get(UUID $uuid): Posts;
    public function save(Posts $article): void;
}