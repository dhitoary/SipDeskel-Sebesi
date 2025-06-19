<?php
$pageTitle = 'Login';
include_once __DIR__ . '/../templates/header.php';
?>

<main class="flex-grow flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form id="login-form" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div id="login-error" class="text-red-600 text-sm hidden"></div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">Login</button>
        </form>
    </div>
</main>

<script>
document.getElementById('login-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const loginError = document.getElementById('login-error');
    loginError.classList.add('hidden');
    loginError.textContent = '';

    const username = this.username.value.trim();
    const password = this.password.value.trim();

    try {
        const response = await fetch('/DHITOPEMWEB/App/api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        });
        const data = await response.json();
        if (data.success) {
            window.location.href = '/DHITOPEMWEB/Public/admin/dashboard.php';
        } else {
            loginError.textContent = data.message || 'Login gagal';
            loginError.classList.remove('hidden');
        }
    } catch (error) {
        loginError.textContent = 'Terjadi kesalahan saat login';
        loginError.classList.remove('hidden');
        console.error('Login error:', error);
    }
});
</script>

<?php include_once __DIR__ . '/../templates/footer.php'; ?>
