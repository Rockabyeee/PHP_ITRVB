<?php

namespace my\Repositories;

use my\Posts;

interface PostsRepositoryInterface
{
    public function get(string $uuid): Posts;
    public function save(Posts $post): void;
}