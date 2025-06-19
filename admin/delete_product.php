<?php
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: desamart_admin.php");
exit;