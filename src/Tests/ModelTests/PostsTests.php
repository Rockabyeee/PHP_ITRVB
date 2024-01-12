<?php

namespace ModelTests;

use my\Posts;
use my\UUID;
use PHPUnit\Framework\TestCase;

class PostsTests extends TestCase
{
    public function testGetData(): void {
        $uuid = UUID::random();
        $authorUuid = UUID::random();
        $title = 'Title1';
        $text = 'Text';
        $article = new Posts(
            $uuid,
            $authorUuid,
            $title,
            $text
        );

        $this->assertEquals($uuid, $article->getUuid());
        $this->assertEquals($authorUuid, $article->getAuthorUuid());
        $this->assertEquals($title, $article->getTitle());
        $this->assertEquals($text, $article->getText());
    }
}