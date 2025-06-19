<?php
// session_start(); // session_start() sudah dipanggil di header_admin.php
$pageTitle = 'Admin Desamart - Pulau Sebesi';
$cssFile = '../../Public/Desamart.css'; // Gunakan CSS Desamart yang sudah ada
include_once __DIR__ . '/../../templates/header_admin.php';

// Koneksi database (ganti sesuai konfigurasi Anda)
$conn = new mysqli('localhost', 'root', '', 'pulau_sebesi');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM products"; // Ganti 'products' sesuai nama tabel Anda
$result = $conn->query($sql);
?>

    <main class="flex-grow">
        <div class="container-gelombang-png">
            <div class="gelombang-png gelombang1"></div>
            <div class="gelombang-png gelombang2"></div>
            <div class="gelombang-png gelombang3"></div>
            <div class="gelombang-png gelombang4"></div>
        </div>

        <section id="admin-desamart" class="py-10 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-blue-800 mb-8">Kelola Produk Desamart</h2>

                <button onclick="window.location.href='add_product.php'" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 mb-6">Tambah Produk Baru</button>

                <div id="admin-product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <div class="bg-white rounded shadow p-4 flex flex-col">
                                <?php
                                // Cek apakah key ada
                                $gambar = isset($row['image']) ? $row['image'] : 'default.jpg';
                                $nama_produk = isset($row['name']) ? $row['name'] : '';
                                ?>
                                <img 
                                    src="../<?php echo $gambar; ?>"
                                    alt="<?php echo htmlspecialchars($nama_produk); ?>"
                                    class="h-32 object-cover rounded mb-2">
                                <h3 class="font-bold text-lg"><?php echo $row['name']; ?></h3>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($row['category']); ?></p>
                                <p class="text-blue-700 font-semibold">Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                                <div class="flex gap-2 mt-2">
    <a href="edit_product.php?id=<?= $row['id']; ?>"
       class="bg-yellow-500 text-white px-4 py-1 rounded text-center hover:bg-yellow-600 transition">
       Edit
    </a>
    <form method="post" action="delete_product.php" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <button type="submit"
            class="bg-red-500 text-white px-4 py-1 rounded text-center hover:bg-red-600 transition">
            Hapus
        </button>
    </form>
</div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500 col-span-full">Tidak ada produk yang ditemukan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <dialog id="product-manage-modal" class="modal">
        <div class="modal-box w-full max-w-2xl">
            <h3 id="modal-title" class="font-bold text-lg mb-4">Tambah/Edit Produk</h3>
            <form id="product-form" class="flex flex-col gap-4">
                <input type="hidden" id="product-id" name="id">
                <div>
                    <label for="product-name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" id="product-name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="product-category" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="product-category" name="category" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
                        <option value="makanan">Makanan & Minuman</option>
                        <option value="kerajinan">Kerajinan Tangan</option>
                        <option value="pertanian">Hasil Pertanian</option>
                        <option value="perikanan">Hasil Perikanan</option>
                    </select>
                </div>
                <div>
                    <label for="product-price" class="block text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" id="product-price" name="price" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required min="0">
                </div>
                <div>
                    <label for="product-location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                    <input type="text" id="product-location" name="location" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="product-seller" class="block text-sm font-medium text-gray-700">Penjual</label>
                    <input type="text" id="product-seller" name="seller" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="product-image" class="block text-sm font-medium text-gray-700">URL Gambar</label>
                    <input type="text" id="product-image" name="image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" placeholder="e.g., Images/my_product.jpg" required>
                </div>
                <div>
                    <label for="product-description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="product-description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm resize-y" required></textarea>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" id="cancel-product-manage" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </dialog>

<?php
$conn->close();
include_once __DIR__ . '/../../templates/footer_admin.php';
?>