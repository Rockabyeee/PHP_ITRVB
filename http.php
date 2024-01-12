<?php

use my\Http\Actions\Comments\CreateComment;
use my\Http\Actions\Posts\CreatePost;
use my\Http\Actions\Posts\DeletePost;
use my\Http\Actions\Users\FindByUsername;
use my\Http\ErrorResponse;
use my\Http\Request;
use my\Repositories\CommentsRepository;
use my\Repositories\PostsRepository;
use my\Repositories\UsersRepository;

require 'vendor/autoload.php';

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
        '/users/show' => new FindByUsername(
            new UsersRepository(
                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
            )
        )
    ],
    'POST' => [
        '/posts/comment' => new CreateComment(
            new CommentsRepository(
                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
            )
        ),
        '/posts/create' => new CreatePost(
            new PostsRepository(
                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
            )
        )
    ],
    'DELETE' => [
        '/posts' => new DeletePost(
            new PostsRepository(
                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
            )
        )
    ]
];

if (!array_key_exists($method, $routs) || !array_key_exists($path, $routs[$method])) {
    (new ErrorResponse('Not found path'))->send();
    return;
}

$action = $routs[$method][$path];

try {
    $response = $action->handle($request);
} catch (Exception $ex) {
    (new ErrorResponse($ex->getMessage()))->send();
    return;
}

$response->send();