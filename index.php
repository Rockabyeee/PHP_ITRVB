<?php

abstract class Product
{
    public function __construct(
        protected $price
    ) { }

    abstract public function getFinalPrice();
}

class DigitalProduct extends Product
{
    public function getFinalPrice(): int
    {
        return $this->price / 2;
    }
}

class LogicProduct extends Product
{
    public function __construct(
        $price,
        protected $quantity
    ) {
        parent::__construct($price);
    }

    public function getFinalPrice(): int
    {
        return $this->price * $this->quantity;
    }
}

class SmartProduct extends Product
{
    public function __construct(
        $price,
        protected $weight
    ) {
        parent::__construct($price);
    }

    public function getFinalPrice(): int
    {
        return $this->price * $this->weight;
    }
}