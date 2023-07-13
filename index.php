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
$products = json_decode(file_get_contents('php://input'));



switch($method) {
  case 'GET':
    $products = ProductFactory::getAllProducts($conn);
    echo json_encode($products);
    break;

  case 'POST': 
    $product = ProductFactory::createProduct($products->type, $products->sku, $products->name, $products->price, $products->size, $products->weight, $products->width, $products->height, $products->length);

    if ($product !== null && $product->insertIntoDatabase($conn)) {
        $response = ['status' => 1, 'message' => 'Product created'];
    }
    echo json_encode($response);
    break;
    
    case 'DELETE':
        $sql = '';
        foreach($products as $product) {
            if(ProductFactory::deleteProduct($product->type, $product->id)) {
                $response = ['status' => 1, 'message' => 'Products are deleted'];
            } else {
                $response = ['status' => 0, 'message' => 'Error in deleting products'];
            }
        }
        echo json_encode($response);
        break;
    
} 
?>
