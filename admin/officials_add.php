<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: /login.php');
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $position = $conn->real_escape_string($_POST['position']);

    // Upload gambar
    $imagePath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../Images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('official_') . '.' . $ext;
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $imagePath = 'Images/' . $fileName;
        } else {
            $error = "Gagal upload gambar.";
        }
    }

    if (!$error) {
        $sql = "INSERT INTO village_officials (name, position, image) VALUES ('$name', '$position', '$imagePath')";
        if ($conn->query($sql)) {
            header('Location: officials_admin.php');
            exit;
        } else {
            $error = "Gagal menambah data: " . $conn->error;
        }
    }
}

$pageTitle = 'Tambah Aparatur Desa';
include_once __DIR__ . '/../../templates/header_admin.php';
?>
<main class="flex-grow">
    <div class="container mx-auto px-4 py-10 max-w-xl">
        <h2 class="text-2xl font-bold mb-4">Tambah Aparatur Desa</h2>
        <?php if (!empty($error)): ?>
            <div class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="name" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label>Jabatan</label>
                <input type="text" name="position" class="border p-2 w-full" required>
            </div>
            <div class="mb-4">
                <label>Foto</label>
                <input type="file" name="photo" accept="image/*" class="border p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="officials_admin.php" class="ml-2">Kembali</a>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>