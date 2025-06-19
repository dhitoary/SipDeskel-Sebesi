<?php
// Hapus session_start() karena sudah dipanggil di halaman yang include header ini
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $pageTitle ?? 'Pulau Sebesi - Informasi Desa'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $cssFile ?? '../Beranda.css'; ?>" />
    <link rel="shortcut icon" href="../Images/18_01_16_2014_logo_desa.jpg" type="image/x-icon" sizes="36x48" />
</head>
<body class="flex flex-col min-h-screen">

<header class="sticky top-0 z-50">
<nav class="hidden lg:flex bg-blue-700 text-white shadow-md w-full items-center justify-center p-2">
    <div class="flex items-center gap-8">
        <a href="dashboard.php" class="flex items-center gap-3">
            <img src="../Images/18_01_16_2014_logo_desa.jpg" alt="Logo SIPDeskel" class="h-10 w-10 rounded-full" />
            <div class="flex flex-col">
                <p class="text-xl font-semibold">SIPDeskel</p>
                <p class="text-xs">Sistem Informasi Pulau Sebesi</p>
            </div>
        </a>

        <ul id="desktop-nav-links" class="flex items-center gap-2">
            <li>
                <a href="dashboard.php" class="nav-link flex items-center justify-center gap-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 hover:bg-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="desamart_admin.php" class="nav-link flex items-center justify-center gap-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 hover:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/></svg>
                    <span>Desamart</span>
                </a>
            </li>
            <li>
                <a href="wisata_admin.php" class="nav-link flex items-center justify-center gap-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 hover:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.72 6 7.92 6 9c0 1.08.512 3.28 1.668 2.679.998-.517 1.05-1.933 1.286-3.352.236-1.419.26-2.903.034-4.322a6.012 6.012 0 012.706-1.912c.72.635 1.22 1.954 1.22 3.221 0 1.267-.5 2.586-1.22 3.221a6.012 6.012 0 01-2.706 1.912c-.226 1.42-.204 2.933.034 4.352.236 1.419.288 2.835 1.286 3.352C13.488 14.72 14 12.52 14 11.44c0-1.08-.512-3.28-1.668-2.679-.998.517-1.05 1.933-1.286 3.352.236-1.419.26-2.903.034-4.322a6.012 6.012 0 01-2.706-1.912c-.72.635-1.22 1.954-1.22 3.221 0 1.267.5 2.586 1.22 3.221z" clip-rule="evenodd"/></svg>
                    <span>Ecowisata</span>
                </a>
            </li>
            <li>
                <a href="officials_admin.php" class="nav-link flex items-center justify-center gap-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 hover:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"/></svg>
                    <span>Aparatur Desa</span>
                </a>
            </li>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): // Tampilkan hanya jika admin login ?>
            <li>
                <a href="/DHITOPEMWEB/Public/admin/dashboard.php" class="nav-link flex items-center justify-center gap-2 py-2 px-6 rounded-full font-semibold transition-all duration-300 hover:bg-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Admin</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div id="auth-buttons" class="flex items-center gap-4">
        <button id="login-button" class="bg-white text-blue-700 font-semibold py-2 px-4 rounded hover:bg-gray-100 <?php echo isset($_SESSION['user_id']) ? 'hidden' : ''; ?>">Login</button>
        <button id="logout-button" class="bg-white text-blue-700 font-semibold py-2 px-4 rounded hover:bg-gray-100 <?php echo isset($_SESSION['user_id']) ? '' : 'hidden'; ?>">Logout</button>
    </div>
</nav>
</header>

<script>
document.getElementById('login-button').addEventListener('click', function() {
    window.location.href = '/DHITOPEMWEB/Public/admin/login.php';
});
document.getElementById('logout-button').addEventListener('click', async function() {
    try {
        const response = await fetch('/DHITOPEMWEB/App/api/logout.php', {
            method: 'POST'
        });
        const data = await response.json();
        if (data.success) {
            window.location.href = '/DHITOPEMWEB/Public/index.php';
        } else {
            alert('Logout gagal');
        }
    } catch (error) {
        alert('Terjadi kesalahan saat logout');
        console.error('Logout error:', error);
    }
});
</script>
</body>
</html>
