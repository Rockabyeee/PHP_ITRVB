<?php

namespace my;

class Users
{
    public function __construct(
        private $id,
        private $name,
        private $surname
    )
    {

    }
}