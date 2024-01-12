<?php

namespace RepositoriesTests;

use my\Comments;
use my\Exceptions\CommentNotFoundException;
use my\Repositories\CommentsRepository;
use my\UUID;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class CommentsRepositoryTests extends TestCase
{
    private $pdoMock;
    private $stmtMock;
    private $repo;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->repo = new CommentsRepository($this->pdoMock);
    }

    public function testSaveComment(): void {
        $uuid = UUID::random();
        $authorUuid = UUID::random();
        $articleUuid = UUID::random();
        $text = 'Test Text';
        $comment = new Comments($uuid, $authorUuid, $articleUuid, $text);

        $expectedParams = [
            ':uuid' => $uuid,
            ':author_uuid' => $authorUuid,
            ':post_uuid' => $articleUuid,
            ':text' => $text
        ];

        $this->pdoMock->method('prepare')
            ->willReturn($this->stmtMock);
        $this->stmtMock->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expectedParams));

        $this->repo->save($comment);
    }

    public function testFindCommentByUuid(): void {
        $uuid = UUID::random();
        $authorUuid = UUID::random();
        $articleUuid = UUID::random();
        $text = 'Test Text';

        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->stmtMock->method('fetch')->willReturn([
            'uuid' => $uuid,
            'author_uuid' => $authorUuid,
            'post_uuid' => $articleUuid,
            'text' => $text
        ]);

        $comment = $this->repo->get($uuid);

        $this->assertNotNull($comment);
        $this->assertEquals($uuid, $comment->getUuid());
    }

    public function testThrowsExceptionIfCommentNotFound(): void {
        $nonExistentUuid = UUID::random();

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage("Comment UUID $nonExistentUuid not found");

        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $this->stmtMock->method('fetch')->willReturn(false);

        $this->repo->get($nonExistentUuid);
    }
}