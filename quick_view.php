<?php
require_once 'config/config.php';
require_once 'classes/Product.php';

header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = new Product();
$info = $product->getProductById($id);

if (!$info) {
    echo json_encode(['success' => false]);
    exit;
}

$image = Product::getImagePath($info);
$finalPrice = ($info['discount_percentage'] > 0)
    ? $info['price'] * (1 - $info['discount_percentage'] / 100)
    : $info['price'];

$description = strip_tags($info['description']);
$description = substr($description, 0, 200);

echo json_encode([
    'success' => true,
    'id' => $info['id'],
    'name' => $info['name'],
    'description' => $description,
    'price' => (float)$info['price'],
    'discount_percentage' => (float)$info['discount_percentage'],
    'final_price' => (float)$finalPrice,
    'image' => $image
]);
