<?php
// app/api/officials.php
header('Content-Type: application/json');
require_once '../config/database.php';

$conn = connectDB();

$sql = "SELECT id, name, position, phone, email, image FROM village_officials";
$result = $conn->query($sql);

$officials = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $officials[] = $row;
    }
}

echo json_encode($officials);

$conn->close();
?>