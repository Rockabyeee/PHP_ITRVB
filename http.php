<?php

use my\Http\Actions\Comments\CreateComment;
use my\Http\Actions\CommentsLikes\CreateCommentLike;
use my\Http\Actions\CommentsLikes\GetByUuidCommentLikes;
use my\Http\Actions\Posts\CreatePost;
use my\Http\Actions\Posts\DeletePost;
use my\Http\Actions\PostsLikes\CreatePostLike;
use my\Http\Actions\PostsLikes\GetByUuidPostLikes;
use my\Http\Actions\Users\FindByUsername;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Repositories\CommentsRepository;
use my\Repositories\PostsRepository;
use my\Repositories\UsersRepository;

$container = require __DIR__ . '/bootstrap.php';

try {
    $request = new Request($_GET, $_POST, $_SERVER);
} catch (Exception $ex) {
    (new ErrorResponse($ex->getMessage()))->send();
    return;
}

try {
    $path = $request->path();
} catch (Exception $ex) {
    (new ErrorResponse($ex->getMessage()))->send();
    return;
}

try {
    $method = $request->method();
} catch (Exception $ex) {
    (new ErrorResponse($ex->getMessage()))->send();
    return;
}

$routs = [
    'GET' => [
        '/users/show' => FindByUsername::class,
        '/likes/comment' => GetByUuidCommentLikes::class,
        '/likes/post' => GetByUuidPostLikes::class,
    ],
    'POST' => [
        '/posts/comment' => CreateComment::class,
        '/posts/' => CreatePost::class,
        '/likes/post/' => CreatePostLike::class,
        '/likes/comment/' => CreateCommentLike::class
    ],
    'DELETE' => [
        '/posts' => DeletePost::class
    ]
];

if (!array_key_exists($method, $routs) || !array_key_exists($path, $routs[$method])) {
    (new ErrorResponse('Not found path'))->send();
    return;
}

$actionClassName = $routs[$method][$path];

$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (Exception $ex) {
    (new ErrorResponse($ex->getMessage()))->send();
    return;
}

$response->send();