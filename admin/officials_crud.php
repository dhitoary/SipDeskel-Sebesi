<?php
// DHITOPEMWEB/App/api/admin/officials_crud.php
header('Content-Type: application/json');
session_start();
require_once '../../config/database.php';

$response = ['success' => false, 'message' => ''];

// Pastikan hanya admin yang bisa mengakses API ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $response['message'] = 'Akses ditolak. Anda bukan admin.';
    echo json_encode($response);
    exit;
}

$conn = connectDB();

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST': // CREATE
        $name = $input['name'] ?? null;
        $position = $input['position'] ?? null;
        $phone = $input['phone'] ?? null;
        $email = $input['email'] ?? null;
        $image = $input['image'] ?? null;

        if ($name && $position && $image) { // Phone dan email bisa null
            $stmt = $conn->prepare("INSERT INTO village_officials (name, position, phone, email, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $position, $phone, $email, $image);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Aparatur desa berhasil ditambahkan.';
            } else {
                $response['message'] = 'Gagal menambahkan aparatur desa: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Data aparatur desa tidak lengkap (Nama, Jabatan, atau Gambar kosong).';
        }
        break;

    case 'PUT': // UPDATE
        $id = $input['id'] ?? null;
        $name = $input['name'] ?? null;
        $position = $input['position'] ?? null;
        $phone = $input['phone'] ?? null;
        $email = $input['email'] ?? null;
        $image = $input['image'] ?? null;

        if ($id && $name && $position && $image) {
            $stmt = $conn->prepare("UPDATE village_officials SET name = ?, position = ?, phone = ?, email = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $name, $position, $phone, $email, $image, $id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Data aparatur desa berhasil diperbarui.';
            } else {
                $response['message'] = 'Gagal memperbarui data aparatur desa: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Data aparatur desa tidak lengkap atau ID tidak ditemukan.';
        }
        break;

    case 'DELETE': // DELETE
        $id = $_GET['id'] ?? ($input['id'] ?? null);

        if ($id) {
            $stmt = $conn->prepare("DELETE FROM village_officials WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Data aparatur desa berhasil dihapus.';
            } else {
                $response['message'] = 'Gagal menghapus data aparatur desa: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'ID aparatur desa tidak ditemukan.';
        }
        break;

    default:
        $response['message'] = 'Metode request tidak valid.';
        break;
}

$conn->close();
echo json_encode($response);
?>