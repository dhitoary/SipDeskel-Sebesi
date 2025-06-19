<?php
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $seller = $_POST['seller'];
    $description = $_POST['description'];

    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../Public/Images/'; // arahkan ke folder Images di root
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
    }
    $stmt = $conn->prepare("INSERT INTO products (name, category, price, location, seller, image, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $imagePath = $imageName ? 'Images/' . $imageName : null;
    $stmt->bind_param("sssssss", $name, $category, $price, $location, $seller, $imagePath, $description);
    $stmt->execute();
    header("Location: desamart_admin.php");
    exit;
}

// Setelah proses simpan di atas, baru include header dan tampilkan form
$pageTitle = 'Tambah Produk - Admin Desamart';
$cssFile = '../../Public/Desamart.css';
include_once __DIR__ . '/../../templates/header_admin.php';
?>

<main class="flex-grow bg-white py-10">
    <div class="container mx-auto px-4 max-w-xl">
        <h2 class="text-3xl font-bold text-blue-800 mb-8 text-center">Tambah Produk Baru</h2>
        <form method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 flex flex-col gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="name" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Makanan & Minuman">Makanan & Minuman</option>
                    <option value="Kerajinan Tangan">Kerajinan Tangan</option>
                    <option value="Hasil Pertanian">Hasil Pertanian</option>
                    <option value="Hasil Perikanan">Hasil Perikanan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="price" required min="0" class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penjual</label>
                <input type="text" name="seller" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                <input type="file" name="image" accept="image/*" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700">Tambah</button>
                <a href="desamart_admin.php" class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
</main>

<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>