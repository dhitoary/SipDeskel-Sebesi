<?php
// app/api/products.php
header('Content-Type: application/json');
require_once '../config/database.php';

$conn = connectDB();

$sql = "SELECT id, name, category, price, location, seller, image, description FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Format harga agar sesuai dengan JS toLocaleString
        $row['price'] = (float)$row['price'];
        $products[] = $row;
    }
}

echo json_encode($products);

$conn->close();
?>