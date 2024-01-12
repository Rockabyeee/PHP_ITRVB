<?php

namespace my;

class Users
{
    public function __construct(
        private UUID $uuid,
        private string $username,
        private Names $name
    ) {
    }

    public function getUuid(): UUID {
        return $this->uuid;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getName(): Names {
        return $this->name;
    }
}