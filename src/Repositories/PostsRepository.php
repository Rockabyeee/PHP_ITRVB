<?php

namespace my\Repositories;

use my\Exceptions\PostIncorrectDataException;
use my\Exceptions\PostNotFoundException;
use my\Posts;
use my\Repositories\PostsRepositoryInterface;
use my\UUID;
use PDO;
use PDOException;

class PostsRepository implements PostsRepositoryInterface
{

    public function __construct(private PDO $pdo) {
    }

    public function get(UUID $uuid): Posts {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE uuid = :uuid");

        try {
            $stmt->execute([
                ":uuid" => $uuid
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                throw new PostNotFoundException("Posts with UUID $uuid not found");
            }
        } catch (PDOException $e) {
            throw new PostIncorrectDataException("Error with get: " . $e->getMessage());
        }

        return new Posts(
            new UUID($result['uuid']),
            new UUID($result['author_uuid']),
            $result['title'],
            $result['text']
        );
    }

    public function save(Posts $posts): void {
        $stmt = $this->pdo->prepare("INSERT INTO posts (uuid, author_uuid, title, text) 
            VALUES (:uuid, :author_uuid, :title, :text)");

        try {
            $stmt->execute([
                ':uuid' => $posts->getUuid(),
                ':author_uuid' => $posts->getAuthorUuid(),
                ':title' => $posts->getTitle(),
                ':text' => $posts->getText()
            ]);
        } catch (PDOException $e) {
            throw new PostIncorrectDataException("Error to save: " . $e->getMessage());
        }
    }

    public function delete(string $uuid): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE uuid = :uuid");
        $stmt->execute([':uuid' => $uuid]);

        if ($stmt->rowCount() === 0) {
            throw new PostNotFoundException("Post with UUID $uuid not found");
        }
    }
}