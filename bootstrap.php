<?php

use my\Container\DIContainer;
use my\Repositories\CommentsLikesRepository;
use my\Repositories\CommentsLikesRepositoryInterface;
use my\Repositories\CommentsRepository;
use my\Repositories\CommentsRepositoryInterface;
use my\Repositories\PostsLikesRepository;
use my\Repositories\PostsLikesRepositoryInterface;
use my\Repositories\PostsRepository;
use my\Repositories\PostsRepositoryInterface;
use my\Repositories\UsersRepository;
use my\Repositories\UsersRepositoryInterface;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$container = new DIContainer;

$container->bind(PDO::class, new PDO('sqlite:' . __DIR__ . '/blog.sqlite'));
$container->bind(UsersRepositoryInterface::class, UsersRepository::class);
$container->bind(CommentsLikesRepositoryInterface::class, CommentsLikesRepository::class);
$container->bind(CommentsRepositoryInterface::class, CommentsRepository::class);
$container->bind(PostsLikesRepositoryInterface::class, PostsLikesRepository::class);
$container->bind(PostsRepositoryInterface::class, PostsRepository::class);

return $container;

