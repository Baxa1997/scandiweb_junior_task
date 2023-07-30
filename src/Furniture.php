<?php 

class Furniture extends Product {
    private string $width;
    private string $height;
    private string $length;
    
    public function __construct(array $productsData) {
            parent::__construct($productsData['sku'], $productsData['name'], $productsData['price']);
            $this->width = $productsData['width'];
            $this->height = $productsData['height'];
            $this->length = $productsData['length'];
    }
    public function insertIntoDatabase(PDO $conn): bool {
        $sql = 'INSERT INTO `furniture`(id, sku, name, price, width, height, length) VALUES (null, :sku, :name, :price, :width, :height, :length)';
        $statement = $conn->prepare($sql);
        $statement->bindParam(':sku', $this->sku);
        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':price', $this->price);
        $statement->bindParam(':width', $this->width);
        $statement->bindParam(':height', $this->height);
        $statement->bindParam(':length', $this->length);
        
        return $statement->execute();
    }
}
