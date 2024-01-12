<?php

namespace my;

class Posts
{
    public function __construct(
        private $id,
        private $authorId,
        private $title,
        private $text
    )
    {

    }
}