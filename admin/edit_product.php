<?php
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = intval($_GET['id'] ?? 0);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $seller = $_POST['seller'];
    $description = $_POST['description'];

    // Cek jika ada upload gambar baru
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../Public/Images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);

        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, location=?, seller=?, image=?, description=? WHERE id=?");
        $imagePath = 'Images/' . $imageName;
        $stmt->bind_param("ssissssi", $name, $category, $price, $location, $seller, $imagePath, $description, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, location=?, seller=?, description=? WHERE id=?");
        $stmt->bind_param("ssisssi", $name, $category, $price, $location, $seller, $description, $id);
    }
    $stmt->execute();
    header("Location: desamart_admin.php");
    exit;
}

// Ambil data produk untuk diedit
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $result->fetch_assoc();

$pageTitle = 'Edit Produk - Admin Desamart';
$cssFile = '../../Public/Desamart.css';
include_once __DIR__ . '/../../templates/header_admin.php';
?>

<main class="flex-grow bg-white py-10">
    <div class="container mx-auto px-4 max-w-xl">
        <h2 class="text-3xl font-bold text-blue-800 mb-8 text-center">Edit Produk</h2>
        <form method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 flex flex-col gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <input type="text" name="category" value="<?php echo htmlspecialchars($row['category']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required min="0" class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penjual</label>
                <input type="text" name="seller" value="<?php echo htmlspecialchars($row['seller']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                <?php if (!empty($row['image'])): ?>
                    <img src="../<?php echo htmlspecialchars($row['image']); ?>" alt="Gambar Produk" class="h-24 mb-2 rounded shadow">
                <?php endif; ?>
                <input type="file" name="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
                <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm"><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700">Simpan</button>
                <a href="desamart_admin.php" class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>