<?php
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $rating = $_POST['rating'];
    $map_embed = $_POST['map_embed'];

    // Proses upload gambar baru (jika ada)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../Public/Images/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        $imagePath = 'Images/' . $imageName;
        $stmt = $conn->prepare("UPDATE tourism_articles SET title=?, image=?, description=?, location=?, rating=?, map_embed=? WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $imagePath, $description, $location, $rating, $map_embed, $id);
    } else {
        $stmt = $conn->prepare("UPDATE tourism_articles SET title=?, description=?, location=?, rating=?, map_embed=? WHERE id=?");
        $stmt->bind_param("sssssi", $title, $description, $location, $rating, $map_embed, $id);
    }
    $stmt->execute();
    header("Location: wisata_admin.php");
    exit;
} else {
    $result = $conn->query("SELECT * FROM tourism_articles WHERE id=$id");
    $row = $result->fetch_assoc();
}

$pageTitle = 'Edit Artikel Wisata - Admin';
$cssFile = '../../Public/Wisata.css';
include_once __DIR__ . '/../../templates/header_admin.php';
?>
<main class="flex-grow bg-white py-10">
    <div class="container mx-auto px-4 max-w-xl">
        <h2 class="text-3xl font-bold text-blue-800 mb-8 text-center">Edit Artikel Wisata</h2>
        <form method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 flex flex-col gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                <?php if (!empty($row['image'])): ?>
                    <img src="../../<?php echo htmlspecialchars($row['image']); ?>" alt="Gambar Wisata" class="h-24 mb-2 rounded shadow">
                <?php endif; ?>
                <input type="file" name="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
                <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm"><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <input type="number" name="rating" min="1" max="5" value="<?php echo htmlspecialchars($row['rating']); ?>" required class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Embed Map</label>
                <input type="text" name="map_embed" value="<?php echo htmlspecialchars($row['map_embed']); ?>" class="w-full p-2 border border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700">Simpan</button>
                <a href="wisata_admin.php" class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
</main>
<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>