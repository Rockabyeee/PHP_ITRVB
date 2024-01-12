<?php

class Product {
    public function __construct(
        private int $id,
        private string $name,
        private int $price,
        private string $description,
        private string $category) {
    }

    public function getInfo(): string {
        return "Product: " . $this->name . ", Price: $" . $this->price;
    }

    public function setPrice($price): void {
        $this->price = $price;
    }
}

class DiscountedProduct extends Product {
    public function __construct(
        $id, $name, $price, $description, $category, private int $discount
    ) {
        parent::__construct($id, $name, $price, $description, $category);
    }

    public function getPriceWithDiscount(): int {
        return $this->price * (1 - $this->discount);
    }
}

class Cart {
    private $products = [];

    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }

    public function removeProduct($productId): void {
        // logic to remove product by ID
    }

    public function getTotalPrice(): int {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }
}

class Review {

    public function __construct(
        private int $id,
        private string $user,
        private string $text,
        private int $rating
    ) {}

    public function getReviewInfo() {
        // logic for review information
    }
}

class User {

    public function __construct(
        private int $id,
        private string $name,
        private string $email
    ) { }

    public function register(): void {
        // user registration logic
    }

    public function login(): void {
        // user login logic
    }
}

class FeedbackForm {
    public function __construct(
        private string $user,
        private string $message
    ) { }

    public function send(): void {
        // logic to send feedback
    }
}
