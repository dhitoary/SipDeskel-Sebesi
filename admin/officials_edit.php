<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: /login.php');
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die("ID tidak valid.");

$error = '';
// Ambil data lama
$result = $conn->query("SELECT * FROM village_officials WHERE id=$id");
$row = $result ? $result->fetch_assoc() : null;
if (!$row) die("Data tidak ditemukan.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $position = $conn->real_escape_string($_POST['position']);
    $description = $conn->real_escape_string($_POST['description']);
    $photoPath = $row['photo'];

    // Proses upload foto baru (jika ada)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../Public/Images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('official_') . '.' . $ext;
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $photoPath = 'Public/Images/' . $fileName;
        } else {
            $error = "Gagal upload foto.";
        }
    }

    if (!$error) {
        $sql = "UPDATE village_officials SET name='$name', position='$position', photo='$photoPath', description='$description' WHERE id=$id";
        if ($conn->query($sql)) {
            header('Location: officials_admin.php');
            exit;
        } else {
            $error = "Gagal update data: " . $conn->error;
        }
    }
}

$pageTitle = 'Edit Aparatur Desa';
include_once __DIR__ . '/../../templates/header_admin.php';
?>
<main class="flex-grow">
    <div class="container mx-auto px-4 py-10 max-w-xl">
        <h2 class="text-2xl font-bold mb-4">Edit Aparatur Desa</h2>
        <?php if (!empty($error)): ?>
            <div class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="name" class="border p-2 w-full" value="<?= htmlspecialchars($row['name']) ?>" required>
            </div>
            <div class="mb-4">
                <label>Jabatan</label>
                <input type="text" name="position" class="border p-2 w-full" value="<?= htmlspecialchars($row['position']) ?>" required>
            </div>
            <div class="mb-4">
                <label>Foto</label>
                <?php if (!empty($row['photo'])): ?>
                    <img src="../../<?= htmlspecialchars($row['photo']) ?>" alt="Foto Aparatur" class="h-24 mb-2 rounded shadow">
                <?php endif; ?>
                <input type="file" name="photo" accept="image/*" class="border p-2 w-full">
                <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengganti foto.</p>
            </div>
            <div class="mb-4">
                <label>Deskripsi (opsional)</label>
                <textarea name="description" class="border p-2 w-full"><?= htmlspecialchars($row['description']) ?></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="officials_admin.php" class="ml-2">Kembali</a>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>