<?php 

class ProductFactory {
    
    public static function getAllProducts(PDO $conn) {
        $sql = "SELECT 'book' AS type, id, sku, name, price, weight, NULL AS size, NULL AS height, NULL AS width, NULL AS length 
        FROM book
        UNION
        SELECT 'dvd' AS type, id, sku, name, price, NULL AS weight, size, NULL AS height, NULL AS width, NULL AS length 
        FROM dvd
        UNION
        SELECT 'furniture' AS type, id, sku, name, price, NULL AS weight, NULL AS size, height, width, length 
        FROM furniture";
        $statm = $conn->prepare($sql);
        $statm->execute();
        $products = $statm->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
    
    public static function createProduct(string $type, string $sku, string $name, string $price, string $size=null, string $weight=null, string $width=null, string $height=null, string $length=null) {
        switch ($type) {
            case 'book':
                return new Book($sku, $name, $price, $weight);
                break;
            case 'dvd':
                return new Dvd($sku, $name, $price, $size);
                break;
            case 'furniture':
                return new Furniture($sku, $name, $price, $width, $height, $length);
                break;
        }
    }
    
    public static function deleteProduct(string $type, string $id) {
        $sql = '';
        switch ($type) {
            case 'book':
                $sql .= "DELETE FROM book WHERE id = $id; ";
                break;
            case 'dvd':
                $sql .= "DELETE FROM dvd WHERE id = $id; ";
                break;
            case 'furniture':
                $sql .= "DELETE FROM furniture WHERE id = $id; ";
                break;
        }
        
       if(!empty($sql)) {
            $objDb = new DbConnection();
            $conn = $objDb->connect();
            $statement = $conn->prepare($sql);
            if ($statement->execute()) {
                return true;
            }
       }
    }
}