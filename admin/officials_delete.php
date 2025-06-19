<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: /login.php');
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $conn->query("DELETE FROM village_officials WHERE id=$id");
}
header('Location: officials_admin.php');
exit;
?>