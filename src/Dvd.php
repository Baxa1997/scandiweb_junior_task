<?php 

class Dvd extends Product {
    private string $size;
    
    public function __construct(string $sku, string $name, string $price, string $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
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

