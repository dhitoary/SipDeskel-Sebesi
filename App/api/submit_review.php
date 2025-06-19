<?php
// app/api/submit_review.php
header('Content-Type: application/json');
session_start(); // Jika review dikaitkan dengan user yang login, Anda akan butuh sesi
require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $article_id = $input['article_id'] ?? null;
    $rating = $input['rating'] ?? null;
    $review_text = $input['review_text'] ?? '';

    if ($article_id === null || $rating === null || empty($review_text)) {
        $response['message'] = 'Data tidak lengkap (article_id, rating, atau review_text kosong).';
        echo json_encode($response);
        exit;
    }

    $conn = connectDB();

    // Untuk saat ini, kita hanya mengembalikan sukses tanpa menyimpan data
    $response['success'] = true; // Untuk demo tanpa penyimpanan persisten
    $response['message'] = 'Review berhasil dikirim (simulasi)!';


    $conn->close();
} else {
    $response['message'] = 'Metode request tidak valid.';
}

echo json_encode($response);
?>