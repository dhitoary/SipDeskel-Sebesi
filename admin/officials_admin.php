<?php
// session_start(); // session_start() sudah dipanggil di header_admin.php
$pageTitle = 'Admin Aparatur Desa - Pulau Sebesi';
$cssFile = '../../Public/Beranda.css'; // Gunakan CSS Beranda karena Aparatur Desa ada di sana
include_once __DIR__ . '/../../templates/header_admin.php';
?>

    <main class="flex-grow">
        <div class="container-gelombang-png">
            <div class="gelombang-png gelombang1"></div>
            <div class="gelombang-png gelombang2"></div>
            <div class="gelombang-png gelombang3"></div>
            <div class="gelombang-png gelombang4"></div>
        </div>

        <section id="admin-officials" class="py-10 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-blue-800 mb-8">Kelola Data Aparatur Desa</h2>

                <a href="officials_add.php" class="bg-blue-600 text-white px-4 py-2 rounded mb-6 inline-block">Tambah Aparatur Desa</a>

                <div id="admin-official-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
                    if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);
                    $result = $conn->query("SELECT * FROM village_officials ORDER BY id DESC");
                    if ($result && $result->num_rows > 0):
                        while($row = $result->fetch_assoc()):
                    ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-4 relative text-center">
                            <?php
                            $photo = !empty($row['image']) ? htmlspecialchars($row['image']) : 'Public/Images/default.png';
                            ?>
                            <img src="../<?= $photo ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-full h-48 object-cover rounded mb-4 mx-auto">
                            <h3 class="text-xl font-semibold text-blue-700 mb-1"><?= htmlspecialchars($row['name']) ?></h3>
                            <p class="text-sm text-gray-500 mb-2"><?= htmlspecialchars($row['position']) ?></p>
                            <div class="flex justify-center gap-2 mt-2">
                                <a href="officials_edit.php?id=<?= $row['id'] ?>" class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
                                <form action="officials_delete.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <p class="text-center text-gray-500 col-span-full">Belum ada data aparatur desa.</p>
                    <?php endif; ?>
                </div>

                <div id="admin-no-officials-message" class="hidden text-center text-gray-600 mt-8">
                    <p class="text-xl">Tidak ada data aparatur desa yang ditemukan.</p>
                </div>
            </div>
        </section>
    </main>

    <dialog id="official-manage-modal" class="modal">
        <div class="modal-box w-full max-w-2xl">
            <h3 id="modal-title" class="font-bold text-lg mb-4">Tambah/Edit Aparatur Desa</h3>
            <form id="official-form" class="flex flex-col gap-4">
                <input type="hidden" id="official-id" name="id">
                <div>
                    <label for="official-name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="official-name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="official-position" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" id="official-position" name="position" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div>
                    <label for="official-phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="official-phone" name="phone" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="official-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="official-email" name="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="official-image" class="block text-sm font-medium text-gray-700">URL Gambar</label>
                    <input type="text" id="official-image" name="image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" placeholder="e.g., Images/official_photo.jpg" required>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" id="cancel-official-manage" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </dialog>


<?php include_once __DIR__ . '/../../templates/footer_admin.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const addOfficialButton = document.getElementById('add-official-button');
        const officialManageModal = document.getElementById('official-manage-modal');
        const cancelOfficialManageButton = document.getElementById('cancel-official-manage');
        const officialForm = document.getElementById('official-form');
        const modalTitle = document.getElementById('modal-title');
        const adminOfficialList = document.getElementById('admin-official-list');
        const adminNoOfficialsMessage = document.getElementById('admin-no-officials-message');

        let allOfficials = [];

        // Fungsi untuk mengambil data aparatur desa dari API
        const fetchAdminOfficials = async () => {
            try {
                const response = await fetch('/DHITOPEMWEB/App/api/officials.php'); // Menggunakan API publik untuk mengambil data
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                allOfficials = await response.json();
                renderAdminOfficials(allOfficials);
            } catch (error) {
                console.error('Gagal mengambil data aparatur desa untuk admin:', error);
                adminOfficialList.innerHTML = '<p class="text-center text-red-500 col-span-full">Gagal memuat data aparatur desa. Silakan coba lagi nanti.</p>';
            }
        };

        // Fungsi untuk merender aparatur desa di tampilan admin
        const renderAdminOfficials = (officialsToRender) => {
            adminOfficialList.innerHTML = '';
            if (officialsToRender.length === 0) {
                adminNoOfficialsMessage.classList.remove('hidden');
            } else {
                adminNoOfficialsMessage.classList.add('hidden');
            }

            officialsToRender.forEach(official => {
                const officialCard = `
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden p-4 relative text-center">
                        <img src="${official.image}" alt="${official.name}" class="w-full h-48 object-cover rounded mb-4 mx-auto">
                        <h3 class="text-xl font-semibold text-blue-700 mb-1">${official.name}</h3>
                        <p class="text-sm text-gray-500 mb-2">${official.position}</p>
                        <p class="text-sm text-gray-600">${official.phone || 'N/A'}</p>
                        <p class="text-sm text-gray-600 mb-4">${official.email || 'N/A'}</p>
                        <div class="flex justify-center gap-2">
                            <button class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 edit-official-btn" data-id="${official.id}">Edit</button>
                            <button class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 delete-official-btn" data-id="${official.id}">Hapus</button>
                        </div>
                    </div>
                `;
                adminOfficialList.insertAdjacentHTML('beforeend', officialCard);
            });

            // Tambahkan event listener untuk tombol Edit
            document.querySelectorAll('.edit-official-btn').forEach(button => {
                button.addEventListener('click', (event) => {
                    const officialId = parseInt(event.target.dataset.id);
                    const officialToEdit = allOfficials.find(o => o.id === officialId);
                    if (officialToEdit) {
                        modalTitle.textContent = 'Edit Aparatur Desa';
                        document.getElementById('official-id').value = officialToEdit.id;
                        document.getElementById('official-name').value = officialToEdit.name;
                        document.getElementById('official-position').value = officialToEdit.position;
                        document.getElementById('official-phone').value = officialToEdit.phone;
                        document.getElementById('official-email').value = officialToEdit.email;
                        document.getElementById('official-image').value = officialToEdit.image;
                        officialManageModal.showModal();
                    }
                });
            });

            // Tambahkan event listener untuk tombol Hapus
            document.querySelectorAll('.delete-official-btn').forEach(button => {
                button.addEventListener('click', async (event) => {
                    const officialId = parseInt(event.target.dataset.id);
                    if (confirm('Anda yakin ingin menghapus data aparatur desa ini?')) {
                        try {
                            const response = await fetch(`/DHITOPEMWEB/Public/admin/officials_crud.php?id=${officialId}`, {
                                method: 'DELETE'
                            });
                            const data = await response.json();
                            if (data.success) {
                                alert('Data aparatur desa berhasil dihapus!');
                                fetchAdminOfficials(); // Muat ulang daftar
                            } else {
                                alert('Gagal menghapus data aparatur desa: ' + (data.message || 'Terjadi kesalahan.'));
                            }
                        } catch (error) {
                            console.error('Error deleting official:', error);
                            alert('Terjadi kesalahan saat menghapus data aparatur desa.');
                        }
                    }
                });
            });
        };

        // Event listener untuk tombol "Tambah Aparatur Baru"
        addOfficialButton.addEventListener('click', () => {
            modalTitle.textContent = 'Tambah Aparatur Baru';
            officialForm.reset(); // Kosongkan formulir
            document.getElementById('official-id').value = ''; // Kosongkan ID untuk aparatur baru
            officialManageModal.showModal();
        });

        // Event listener untuk tombol "Batal" di modal
        cancelOfficialManageButton.addEventListener('click', () => {
            officialManageModal.close();
        });

        // Event listener untuk pengiriman formulir (Tambah/Edit)
        officialForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(officialForm);
            const officialId = formData.get('id');
            const method = officialId ? 'PUT' : 'POST'; // Jika ada ID, itu PUT (update), jika tidak, POST (create)

            const officialData = {
                id: officialId ? parseInt(officialId) : null,
                name: formData.get('name'),
                position: formData.get('position'),
                phone: formData.get('phone'),
                email: formData.get('email'),
                image: formData.get('image')
            };

            try {
                const response = await fetch('/DHITOPEMWEB/Public/admin/officials_crud.php', {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(officialData)
                });
                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    officialManageModal.close();
                    fetchAdminOfficials(); // Muat ulang daftar aparatur
                } else {
                    alert('Gagal menyimpan data aparatur desa: ' + (data.message || 'Terjadi kesalahan.'));
                }
            } catch (error) {
                console.error('Error saving official:', error);
                alert('Terjadi kesalahan saat menyimpan data aparatur desa.');
            }
        });

        fetchAdminOfficials(); // Panggil fungsi ini saat halaman dimuat
    });
</script>

<?php
$conn = new mysqli('localhost', 'root', '', 'pulau_Sebesi');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$result = $conn->query("SELECT * FROM village_officials ORDER BY id DESC");
?>