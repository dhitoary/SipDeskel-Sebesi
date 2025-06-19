<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /DHITOPEMWEB/Public/index.php'); 
    exit();
}

$_SESSION['is_admin'] = true;

$pageTitle = 'Admin Dashboard - Pulau Sebesi';
$cssFile = '../Beranda.css'; 
include_once __DIR__ . '/../../templates/header_admin.php';
?>

<main class="flex-grow">
    <div class="container-gelombang-png">
        <div class="gelombang-png gelombang1"></div>
        <div class="gelombang-png gelombang2"></div>
        <div class="gelombang-png gelombang3"></div>
        <div class="gelombang-png gelombang4"></div>
    </div>

    <section id="admin-dashboard" class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-blue-800 mb-8">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p class="text-center text-gray-600 mb-10">Pilih modul yang ingin Anda kelola:</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <a href="desamart_admin.php" class="block bg-green-600 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                    <h3 class="text-3xl font-bold mb-4">Kelola Desamart</h3>
                    <p class="text-lg">Tambah, Edit, Hapus Produk Unggulan.</p>
                </a>
                <a href="wisata_admin.php" class="block bg-blue-600 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                    <h3 class="text-3xl font-bold mb-4">Kelola Ecowisata</h3>
                    <p class="text-lg">Tambah, Edit, Hapus Artikel Wisata.</p>
                </a>
                <a href="officials_admin.php" class="block bg-purple-600 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                    <h3 class="text-3xl font-bold mb-4">Kelola Aparatur Desa</h3>
                    <p class="text-lg">Tambah, Edit, Hapus Data Aparatur.</p>
                </a>
            </div>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>
