<?php
// app/api/check_session.php
header('Content-Type: application/json');
session_start();

$isLoggedIn = isset($_SESSION['user_id']);

echo json_encode(['isLoggedIn' => $isLoggedIn]);
?>