<?php

namespace my\Repositories;

use my\Comments;
use my\Exceptions\CommentIncorrectDataException;
use my\Exceptions\CommentNotFoundException;
use my\Repositories\CommentsRepositoryInterface;
use my\UUID;
use PDO;
use PDOException;

class CommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function get(UUID $uuid): Comments {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE uuid = :uuid");

        try {
            $stmt->execute([
                ":uuid" => $uuid
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                throw new CommentNotFoundException("Comment UUID $uuid not found");
            }
        } catch (PDOException $e) {
            throw new CommentIncorrectDataException("Error to get: " . $e->getMessage());
        }

        return new Comments(
            new UUID($result['uuid']),
            new UUID($result['author_uuid']),
            new UUID($result['post_uuid']),
            $result['text']
        );
    }

    public function save(Comments $comment): void {
        $stmt = $this->pdo->prepare("INSERT INTO comments (uuid, author_uuid, post_uuid, text) 
            VALUES (:uuid, :author_uuid, :post_uuid, :text)");

        try {
            $stmt->execute([
                ':uuid' => $comment->getUuid(),
                ':author_uuid' => $comment->getAuthorUuid(),
                ':post_uuid' => $comment->getArticleUuid(),
                ':text' => $comment->getText()
            ]);
        } catch (PDOException $e) {
            throw new CommentIncorrectDataException("Error to save: " . $e->getMessage());
        }
    }
}