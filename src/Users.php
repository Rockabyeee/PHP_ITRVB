<?php

namespace my;

class Users
{
    public function __construct(
        private UUID $uuid,
        private string $name,
        private string $surname
    )
    {

    }
}