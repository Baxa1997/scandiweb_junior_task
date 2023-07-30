<?php 


class Book extends Product {
    private string $weight;

    public function __construct(array $productsData) {
        parent::__construct($productsData['sku'], $productsData['name'], $productsData['price']);
        $this->weight = $productsData['weight'];
    }

    public function insertIntoDatabase(PDO $conn): bool {
        $sql = 'INSERT INTO `book`(id, sku, name, price, weight) VALUES (null, :sku, :name, :price, :weight)';
        $statement = $conn->prepare($sql);
        $statement->bindParam(':sku', $this->sku);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':price', $this->price);
        $statement->bindParam(':weight', $this->weight);
        
        return $statement->execute();
    }
    
}