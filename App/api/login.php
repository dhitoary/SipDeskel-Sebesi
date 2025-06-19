<?php
// app/api/login.php
header('Content-Type: application/json');
session_start();
require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';

    $conn = connectDB();

    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password yang di-hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $response['success'] = true;
            $response['message'] = 'Login berhasil!';
        } else {
            $response['message'] = 'Username atau password salah.';
        }
    } else {
        $response['message'] = 'Username atau password salah.';
    }

    $stmt->close();
    $conn->close();
} else {
    $response['message'] = 'Metode request tidak valid.';
}

echo json_encode($response);
?>