<?php
$pageTitle = 'Ecowisata Tejang Pulau Sebesi';
$cssFile = 'Wisata.css';
include_once __DIR__ . '/../templates/header.php';

// Koneksi database (ganti sesuai konfigurasi)
$conn = new mysqli("localhost", "root", "", "pulau_sebesi");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data wisata
$sql = "SELECT id, title, image, description, location, rating, map_embed FROM tourism_articles";
$result = $conn->query($sql);

$tourismData = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tourismData[] = $row;
    }
}
$conn->close();
?>

        <div class="container-gelombang-png">
            <div class="gelombang-png gelombang1"></div>
            <div class="gelombang-png gelombang2"></div>
            <div class="gelombang-png gelombang3"></div>
            <div class="gelombang-png gelombang4"></div>
        </div>

    <main class="flex-grow">
        <section id="ecotourism" class="py-10 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-blue-800 mb-8">Ecowisata Tejang Pulau Sebesi</h2>

                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div class="w-full md:w-1/4">
                        <label for="location-filter" class="sr-only">Kategori</label>
                        <select id="location-filter" class="block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">Semua Kategori</option>
                            <option value="Pantai">Pantai</option>
                            <option value="Terumbu Karang">Bawah Laut</option>
                            <option value="Hutan Mangrove">Hutan</option>
                            <option value="Desa Tejang">Budaya</option>
                            <option value="Spot Sunset">Sunset</option>
                            <option value="Pulau Sebesi">Snorkeling</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/2 relative">
                        <input type="text" id="search-input" placeholder="Cari di Ecowisata..." class="block w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 002 8z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>

                <div id="tourism-articles" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>
                <div id="no-tourism-message" class="hidden text-center text-gray-500 mt-8">Tidak ada data wisata ditemukan.</div>
            </div>
        </section>
    </main>

<script>
const tourismData = <?php echo json_encode($tourismData, JSON_UNESCAPED_UNICODE); ?>;

document.addEventListener('DOMContentLoaded', function() {
    renderTourismArticles(tourismData);
});

    function capitalize(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function renderTourismArticles(data) {
        const container = document.getElementById('tourism-articles');
        container.innerHTML = '';
        if (data.length === 0) {
            document.getElementById('no-tourism-message').classList.remove('hidden');
            return;
        }
        document.getElementById('no-tourism-message').classList.add('hidden');
        data.forEach(item => {
            const article = document.createElement('article');
            article.className = "bg-white rounded-lg shadow-md overflow-hidden";
            article.innerHTML = `
    <img src="${item.image}" alt="${item.title}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-xl font-semibold mb-2">${item.title}</h3>
        <p class="text-gray-600 mb-2"><b>Lokasi:</b> ${capitalize(item.location)}</p>
        <p class="text-gray-700 mb-2">${item.description}</p>
        <p class="mb-2"><b>Rating:</b> ${'★'.repeat(item.rating)}${'☆'.repeat(5 - item.rating)}</p>
    </div>
`;
            container.appendChild(article);
        });
    }

    function filterTourism() {
        const location = document.getElementById('location-filter').value.trim().toLowerCase();
        const search = document.getElementById('search-input').value.toLowerCase();
        let filtered = tourismData.filter(item => 
            (location === 'all' || (item.location && item.location.trim().toLowerCase() === location)) &&
            (item.title.toLowerCase().includes(search) || item.description.toLowerCase().includes(search))
        );
        renderTourismArticles(filtered);
    }


    document.getElementById('location-filter').addEventListener('change', filterTourism);
    document.getElementById('search-input').addEventListener('input', filterTourism);


    // Render awal
    filterTourism();
</script>

<?php include_once __DIR__ . '/../templates/footer.php'; ?>