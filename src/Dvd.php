<?php 

class Dvd extends Product {
    private string $size;
    
    public function __construct(array $productsData) {
        parent::__construct($productsData['sku'], $productsData['name'], $productsData['price']);
        $this->size = $productsData['size'];
    }
    
    public function insertIntoDatabase(PDO $conn): bool {
        $sql = 'INSERT INTO `dvd`(id, sku, name, price, size) VALUES (null, :sku, :name, :price, :size)';
        $statement = $conn->prepare($sql);
        $statement->bindParam(':sku', $this->sku);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':price', $this->price);
        $statement->bindParam(':size', $this->size);
        
        return $statement->execute();
    }
}

