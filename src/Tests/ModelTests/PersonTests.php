<?php

namespace ModelTests;

use my\Names;
use my\Person;
use PHPUnit\Framework\TestCase;

class PersonTests extends TestCase
{
    public function testToString(): void {
        $name = new Names('fN', 'lN');
        $date = new \DateTimeImmutable('now');
        $person = new Person($name, $date);

        $this->assertEquals("fN lN (on the site with " . $date->format('Y-m-d') . ')',
            $person);
    }
}