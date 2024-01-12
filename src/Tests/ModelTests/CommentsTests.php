<?php

namespace ModelTests;

use my\Comments;
use my\UUID;
use PHPUnit\Framework\TestCase;

class CommentsTests extends TestCase
{
    public function testGetData(): void {
        $uuid = UUID::random();
        $authorUuid = UUID::random();
        $articleUuid = UUID::random();
        $text = 'Text';
        $comment = new Comments(
            $uuid,
            $authorUuid,
            $articleUuid,
            $text
        );

        $this->assertEquals($uuid, $comment->getUuid());
        $this->assertEquals($authorUuid, $comment->getAuthorUuid());
        $this->assertEquals($articleUuid, $comment->getArticleUuid());
        $this->assertEquals($text, $comment->getText());
    }
}