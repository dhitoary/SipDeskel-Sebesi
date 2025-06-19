<?php
// DHITOPEMWEB/App/api/admin/tourism_crud.php
header('Content-Type: application/json');
require_once __DIR__ . '/../../App/config/database.php'; // Pastikan file koneksi

$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Tambah data wisata
    $input = json_decode(file_get_contents('php://input'), true);
    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
        exit;
    }
    // Ambil data dari $input
    $title = $input['title'] ?? '';
    $image = $input['image'] ?? '';
    $description = $input['description'] ?? '';
    $location = $input['location'] ?? '';
    $rating = $input['rating'] ?? 0;
    $map_embed = $input['map_embed'] ?? '';
    $category = $input['category'] ?? '';

    // Validasi sederhana
    if (!$title || !$image || !$description || !$location || !$rating) {
        echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi']);
        exit;
    }

    // Query insert
    $stmt = $conn->prepare("INSERT INTO tourism (title, image, description, location, rating, map_embed, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssiss",
        $title,
        $image,
        $description,
        $location,
        $rating,
        $map_embed,
        $category
    );
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Artikel wisata berhasil ditambahkan']);
    exit;
}

if ($method === 'PUT') {
    // Edit artikel
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("UPDATE tourism SET title=?, image=?, description=?, location=?, rating=?, map_embed=?, category=? WHERE id=?");
    $stmt->bind_param(
        "ssssissi",
        $data['title'],
        $data['image'],
        $data['description'],
        $data['location'],
        $data['rating'],
        $data['map_embed'],
        $data['category'],
        $data['id']
    );
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Artikel wisata berhasil diupdate']);
    exit;
}

if ($method === 'DELETE') {
    // Hapus artikel
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM tourism WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Artikel wisata berhasil dihapus']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID artikel tidak ditemukan']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Metode tidak didukung']);
exit;