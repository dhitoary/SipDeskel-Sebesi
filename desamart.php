<?php
$pageTitle = 'Desamart Tejang Pulau Sebesi';
$cssFile = 'Desamart.css'; // Pastikan CSS ini ada di public/
include_once __DIR__ . '/../templates/header.php'; // Path relatif ke header.php
require_once __DIR__ . '/../App/config/database.php';
$conn = connectDB();
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

        <div class="container-gelombang-png">
            <div class="gelombang-png gelombang1"></div>
            <div class="gelombang-png gelombang2"></div>
            <div class="gelombang-png gelombang3"></div>
            <div class="gelombang-png gelombang4"></div>
        </div>

    <main class="flex-grow">
        <section id="desamart" class="py-10 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-blue-800 mb-8">Desamart Tejang Pulau Sebesi</h2>

                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div class="w-full md:w-1/4">
                        <label for="category-filter" class="sr-only">Kategori</label>
                        <select id="category-filter" class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">Semua Kategori</option>
                            <option value="makanan">Makanan & Minuman</option>
                            <option value="kerajinan">Kerajinan Tangan</option>
                            <option value="pertanian">Hasil Pertanian</option>
                            <option value="perikanan">Hasil Perikanan</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/2 relative">
                        <input type="text" id="search-input" placeholder="Cari di Desamart..." class="block w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 002 8z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>

                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center hover:shadow-lg transition">
                            <img src="<?php echo htmlspecialchars($row["image"]); ?>" alt="<?php echo htmlspecialchars($row["name"]); ?>" class="w-32 h-32 object-cover rounded mb-2">
                            <h3 class="font-bold text-lg text-center mb-1 text-blue-800"><?php echo htmlspecialchars($row["name"]); ?></h3>
                            <p class="uppercase text-xs text-gray-500 mb-1"><?php echo htmlspecialchars($row["category"]); ?></p>
                            <p class="text-green-600 font-bold mb-2">Rp <?php echo number_format($row["price"],0,',','.'); ?></p>
                            <p class="mb-1 text-xs text-gray-600 flex items-center gap-1"><span>📍</span><?php echo htmlspecialchars($row["location"]); ?></p>
                            <p class="mb-2 text-xs text-gray-600 flex items-center gap-1"><span>👤</span><?php echo htmlspecialchars($row["seller"]); ?></p>
                            <form action="https://wa.me/6281540958720" method="get" target="_blank" class="w-full mt-2">
                                <input type="hidden" name="text" value="Halo, saya ingin memesan <?php echo htmlspecialchars($row["name"]); ?> dari Desamart Pulau Sebesi.">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full text-sm font-semibold">
                                    Pesan via WhatsApp
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center text-gray-500 col-span-full">Tidak ada produk.</p>
                <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Detail Produk -->
    <dialog id="product-detail-modal" class="modal">
        <div class="modal-content">
            <span class="close-button product-modal-close">&times;</span>
            <div id="product-detail-content"></div>
        </div>
    </dialog>
    <?php
    // Ambil ulang data produk untuk dikirim ke JS
    $allProducts = [];
    if ($result && $result->num_rows > 0) {
        // Reset pointer dan ambil ulang data
        $result->data_seek(0);
        while($row = $result->fetch_assoc()) {
            $allProducts[] = $row;
        }
    }
    ?>
    <script>
        // Data produk sudah diambil dari PHP
        const products = <?php echo json_encode($allProducts); ?>;

        // Render produk ke grid
        function renderProducts(filteredProducts) {
            const grid = document.getElementById('product-grid');
            if (!filteredProducts.length) {
                grid.innerHTML = '<p class="text-center text-gray-500 col-span-full">Tidak ada produk.</p>';
                return;
            }
            grid.innerHTML = filteredProducts.map(product => `
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center hover:shadow-lg transition">
                    <img src="${product.image}" alt="${product.name}" class="w-32 h-32 object-cover rounded mb-2">
                    <h3 class="font-bold text-lg text-center mb-1 text-blue-800">${product.name}</h3>
                    <p class="uppercase text-xs text-gray-500 mb-1">${product.category}</p>
                    <p class="text-green-600 font-bold mb-2">Rp ${Number(product.price).toLocaleString('id-ID')}</p>
                    <p class="mb-1 text-xs text-gray-600 flex items-center gap-1"><span>📍</span>${product.location}</p>
                    <p class="mb-2 text-xs text-gray-600 flex items-center gap-1"><span>👤</span>${product.seller}</p>
                    <form action="https://wa.me/6281540958720" method="get" target="_blank" class="w-full mt-2">
                        <input type="hidden" name="text" value="Halo, saya ingin memesan ${product.name} dari Desamart Pulau Sebesi.">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full text-sm font-semibold">
                            Pesan via WhatsApp
                        </button>
                    </form>
                </div>
            `).join('');
        }

        // Filter dan cari produk
        function filterAndSearchProducts() {
            const categoryFilter = document.getElementById('category-filter');
            const searchInput = document.getElementById('search-input');
            const selectedCategory = categoryFilter.value;
            const searchTerm = searchInput.value.toLowerCase();

            const filtered = products.filter(product => {
                const matchesCategory = selectedCategory === 'all' || product.category === selectedCategory;
                const matchesSearch =
                    product.name.toLowerCase().includes(searchTerm) ||
                    (product.description && product.description.toLowerCase().includes(searchTerm)) ||
                    product.seller.toLowerCase().includes(searchTerm);
                return matchesCategory && matchesSearch;
            });

            renderProducts(filtered);
        }

        // Event listener untuk filter dan search
        document.getElementById('category-filter').addEventListener('change', filterAndSearchProducts);
        document.getElementById('search-input').addEventListener('input', filterAndSearchProducts);

        // Tampilkan semua produk saat halaman pertama kali dibuka
        renderProducts(products);
    </script>

<?php include_once __DIR__ . '/../templates/footer.php'; ?>