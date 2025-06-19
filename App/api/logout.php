<?php
// App/api/logout.php
session_start();
$_SESSION = [];
session_destroy();

header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Logout berhasil']);
?>
