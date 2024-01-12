<?php

namespace HttpTests;

use my\Http\Actions\Posts\CreatePost;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Http\SuccessResponse;
use my\Repositories\PostsRepository;
use my\UUID;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class CreatePostTest extends TestCase
{
    private PDO $pdoMock;
    private PDOStatement $stmtMock;
    private PostsRepository $postRepository;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->stmtMock = $this->createMock(PDOStatement::class);
        $this->postRepository = new PostsRepository($this->pdoMock);
    }

    public function testItSuccess(): void
    {
        $request = new Request(
            [],
            ['author_uuid' => UUID::random(), 'title' => 'Test Title', 'text' => 'Test Text'],
            []
        );

        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $createPostAction = new CreatePost($this->postRepository);
        $response = $createPostAction->handle($request);
        $this->assertInstanceOf(SuccessResponse::class, $response);
    }

    public function testItIncorrectUuid(): void
    {
        $request = new Request(
            [],
            ['author_uuid' => 'incorrect_uuid', 'title' => 'Test Title', 'text' => 'Test Text'],
            []
        );

        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(true);
        $createPostAction = new CreatePost($this->postRepository);
        $response = $createPostAction->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
    }

    public function testItEmptyAuthorUuid(): void
    {
        $request = new Request(
            [],
            ['title' => 'Test Title', 'text' => 'Test Text'],
            []
        );
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(false);
        $createPostAction = new CreatePost($this->postRepository);
        $response = $createPostAction->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);

        $responseBody = $response->getBody();
        $responseBodyString = json_encode(json_decode($responseBody), JSON_UNESCAPED_UNICODE);
        $this->assertSame('"Incorrect param for body: author_uuid"', $responseBodyString);
    }

    public function testItEmptyTitle(): void
    {
        $request = new Request(
            [],
            ['author_uuid' => UUID::random(), 'text' => 'Test Text'],
            []
        );
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(false);
        $createPostAction = new CreatePost($this->postRepository);
        $response = $createPostAction->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);

        $responseBody = $response->getBody();
        $responseBodyString = json_encode(json_decode($responseBody), JSON_UNESCAPED_UNICODE);
        $this->assertSame('"Incorrect param for body: title"', $responseBodyString);
    }

    public function testItEmptyText(): void
    {
        $request = new Request(
            [],
            ['author_uuid' => 'Test Title', 'title' => 'Test Text'],
            []
        );
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('execute')->willReturn(false);
        $createPostAction = new CreatePost($this->postRepository);
        $response = $createPostAction->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);

        $responseBody = $response->getBody();
        $responseBodyString = json_encode(json_decode($responseBody), JSON_UNESCAPED_UNICODE);
        $this->assertSame('"Incorrect param for body: text"', $responseBodyString);
    }
}