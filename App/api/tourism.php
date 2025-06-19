<?php
// app/api/tourism.php
header('Content-Type: application/json');
require_once '../config/database.php';

$conn = connectDB();

$sql = "SELECT id, title, image, description, location, rating, map_embed FROM tourism_articles ORDER BY id DESC";
$result = $conn->query($sql);

$articles = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row['rating'] = (int)$row['rating'];
        $articles[] = $row;
    }
}

echo json_encode($articles);

$conn->close();
?>
