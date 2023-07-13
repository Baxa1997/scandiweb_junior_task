<?php 


class Book extends Product {
    private string $weight;

    public function __construct(string $sku, string $name, string $price, string $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
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