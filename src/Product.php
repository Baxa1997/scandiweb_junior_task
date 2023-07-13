<?php 

abstract class Product {
    protected string $sku;
    protected string $name;
    protected float $price;

    public function __construct(string $sku, string $name, float $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function insertIntoDatabase(PDO $conn): bool;
}