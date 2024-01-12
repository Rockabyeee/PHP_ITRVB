<?php

namespace my;

class Posts
{
    public function __construct(
        private UUID $uuid,
        private UUID $authorUuid,
        private string $title,
        private string $text
    )
    {

    }
}