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
    
    public static function createProduct(string $type, array $productsData) {
        $productType = ucfirst($type);
        return new $productType($productsData);
    }
    
    public static function deleteProduct(string $type, string $id) {
        $sql = '';
        $sql .= "DELETE FROM $type WHERE id = $id; ";
        
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