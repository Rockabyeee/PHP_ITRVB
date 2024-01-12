<?php

namespace my;

class Comments
{
    public function __construct(
        private UUID $uuid,
        private UUID $authorUuid,
        private UUID $postUuid,
        private $text
    )
    {

    }
}