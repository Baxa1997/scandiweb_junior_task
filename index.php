<?php 

declare(strict_types=1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");


spl_autoload_register(function ($class) {
  $path = __DIR__ . '/./src/' . str_replace('\\', '/', $class) . '.php';
  if(file_exists($path)) {
      require $path;
  } 
});
 
$objDb = new DbConnection();
$conn = $objDb->connect();
$method = $_SERVER['REQUEST_METHOD'];
$productsData = json_decode(file_get_contents('php://input'), true);



switch($method) {
  case 'GET':
    $products = ProductFactory::getAllProducts($conn);
    echo json_encode($products);
    break;

  case 'POST': 
    var_dump($productsData);
    $product = ProductFactory::createProduct($productsData['type'], $productsData);
    if ($product !== null && $product->insertIntoDatabase($conn)) {
        $response = ['status' => 1, 'message' => 'Product created'];
    }
    echo json_encode($response);
    break;
    
    case 'DELETE':
        $sql = '';
        foreach($productsData as $product) {
            if(ProductFactory::deleteProduct($product['type'], $product['id'])) {
                $response = ['status' => 1, 'message' => 'Products are deleted'];
            } else {
                $response = ['status' => 0, 'message' => 'Error in deleting products'];
            }
        }
        echo json_encode($response);
        break;
    
} 
?>
