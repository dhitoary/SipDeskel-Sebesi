<?php
// session_start(); // session_start() sudah dipanggil di header_admin.php
$pageTitle = 'Admin Ecowisata - Pulau Sebesi';
$cssFile = '../../Public/Wisata.css';
include_once __DIR__ . '/../../templates/header_admin.php';
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);
$result = $conn->query("SELECT * FROM tourism_articles ORDER BY id DESC");
?>

<div class="container-gelombang-png">
            <div class="gelombang-png gelombang1"></div>
            <div class="gelombang-png gelombang2"></div>
            <div class="gelombang-png gelombang3"></div>
            <div class="gelombang-png gelombang4"></div>
        </div>
<main class="flex-grow bg-white py-10">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-blue-800 mb-8 text-center">Kelola Artikel Ecowisata</h2>
        <a href="add_wisata.php" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 mb-6 inline-block">Tambah Artikel Baru</a>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="bg-white rounded shadow p-4 flex flex-col">
                        <img src="../<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="h-32 object-cover rounded mb-2">
                        <h3 class="font-bold text-lg text-blue-800"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="text-gray-600 mb-1"><?php echo htmlspecialchars($row['location']); ?></p>
                        <div class="flex gap-2 mt-2">
                            <a href="edit_wisata.php?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="delete_wisata.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-gray-500 col-span-full">Belum ada artikel wisata.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>