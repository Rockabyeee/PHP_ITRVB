<?php

namespace my;

class Person
{
    public function __construct(
        private Names $name,
        private \DateTimeImmutable $regiseredOn
    ) {

    }

    public function __toString(): string {
        return $this->name . ' (on the site with ' . $this->regiseredOn->format('Y-m-d') . ')';
    }
}