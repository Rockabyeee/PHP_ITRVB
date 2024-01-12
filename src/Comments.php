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

    public function getUuid(): UUID {
        return $this->uuid;
    }

    public function getAuthorUuid(): UUID {
        return $this->authorUuid;
    }

    public function getArticleUuid(): UUID {
        return $this->postUuid;
    }

    public function getText(): string {
        return $this->text;
    }
}