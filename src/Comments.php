<?php

namespace my;

class Comments
{
    public function __construct(
        private $id,
        private $authorId,
        private $articleId,
        private $text
    )
    {

    }
}