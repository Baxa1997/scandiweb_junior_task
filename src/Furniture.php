<?php 

class Furniture extends Product {
    private string $width;
    private string $height;
    private string $length;
    
    public function __construct(string $sku, string $name, string $price, string $width, string $height, string $length) {
            parent::__construct($sku, $name, $price);
            $this->width = $width;
            $this->height = $height;
            $this->length = $length;
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
