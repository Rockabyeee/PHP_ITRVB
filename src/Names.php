<?php

namespace my;

class Names
{
    public function __construct(
        private string $firstName,
        private string $lastName
    ) {

    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function __toString() {
        return $this->firstName . ' ' . $this->lastName;
    }
}