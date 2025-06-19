<?php
// DHITOPEMWEB/App/api/admin/products_crud.php
header('Content-Type: application/json');
session_start();
require_once '../../config/database.php';

$response = ['success' => false, 'message' => ''];

// Debug session
error_log('Session user_id: ' . ($_SESSION['user_id'] ?? 'null'));
error_log('Session role: ' . ($_SESSION['role'] ?? 'null'));

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
        $category = $input['category'] ?? null;
        $price = $input['price'] ?? null;
        $location = $input['location'] ?? null;
        $seller = $input['seller'] ?? null;
        $image = $input['image'] ?? null;
        $description = $input['description'] ?? null;

        if ($name && $category && $price !== null && $location && $seller && $image && $description) {
            $stmt = $conn->prepare("INSERT INTO products (name, category, price, location, seller, image, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssss", $name, $category, $price, $location, $seller, $image, $description);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Produk berhasil ditambahkan.';
            } else {
                $response['message'] = 'Gagal menambahkan produk: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Data produk tidak lengkap.';
        }
        break;

    case 'PUT': // UPDATE
        $id = $input['id'] ?? null;
        $name = $input['name'] ?? null;
        $category = $input['category'] ?? null;
        $price = $input['price'] ?? null;
        $location = $input['location'] ?? null;
        $seller = $input['seller'] ?? null;
        $image = $input['image'] ?? null;
        $description = $input['description'] ?? null;

        if ($id && $name && $category && $price !== null && $location && $seller && $image && $description) {
            $stmt = $conn->prepare("UPDATE products SET name = ?, category = ?, price = ?, location = ?, seller = ?, image = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssdssssi", $name, $category, $price, $location, $seller, $image, $description, $id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Produk berhasil diperbarui.';
            } else {
                $response['message'] = 'Gagal memperbarui produk: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Data produk tidak lengkap atau ID tidak ditemukan.';
        }
        break;

    case 'DELETE': // DELETE
        // Untuk DELETE, ID biasanya datang dari query string atau body
        $id = $_GET['id'] ?? ($input['id'] ?? null);

        if ($id) {
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Produk berhasil dihapus.';
            } else {
                $response['message'] = 'Gagal menghapus produk: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'ID produk tidak ditemukan.';
        }
        break;

    default:
        $response['message'] = 'Metode request tidak valid.';
        break;
}

$conn->close();
echo json_encode($response);
?>