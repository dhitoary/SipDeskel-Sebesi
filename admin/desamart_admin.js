document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded event dipicu');
    const addProductButton = document.getElementById('add-product-button');
    const productManageModal = document.getElementById('product-manage-modal');
    const cancelProductManageButton = document.getElementById('cancel-product-manage');
    const productForm = document.getElementById('product-form');
    const modalTitle = document.getElementById('modal-title');
    const adminProductList = document.getElementById('admin-product-list');
    const adminNoProductsMessage = document.getElementById('admin-no-products-message');

    let allProducts = [];

    // Fungsi untuk mengambil data produk dari API
    const fetchAdminProducts = async () => {
        adminProductList.innerHTML = '<p class="text-center text-gray-500 col-span-full">Memuat produk untuk admin...</p>';
        adminNoProductsMessage.classList.add('hidden');
        try {
            // Tambahkan logging URL fetch untuk debugging
            const fetchUrl = '/DHITOPEMWEB/App/api/products.php';
            console.log('Mengambil produk dari URL:', fetchUrl);
            const response = await fetch(fetchUrl, { credentials: 'include' });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            allProducts = await response.json();
            console.log('Data produk diterima:', allProducts);
            renderAdminProducts(allProducts);
        } catch (error) {
            console.error('Gagal mengambil produk untuk admin:', error);
            adminProductList.innerHTML = '<p class="text-center text-red-500 col-span-full">Gagal memuat produk. Silakan coba lagi nanti.</p>';
        }
    };

    // Fungsi untuk merender produk di tampilan admin
    const renderAdminProducts = (productsToRender) => {
        adminProductList.innerHTML = '';
        if (productsToRender.length === 0) {
            adminNoProductsMessage.classList.remove('hidden');
        } else {
            adminNoProductsMessage.classList.add('hidden');
        }

        productsToRender.forEach(product => {
            // Tambahkan prefix "Images/" jika belum ada
            let imagePath = product.image;
            if (!imagePath.startsWith('Images/')) {
                imagePath = 'Images/' + imagePath;
            }
            const productCard = `
                <div class="bg-white rounded-xl shadow-lg overflow-hidden p-4 relative">
                    <img src="${imagePath}" alt="${product.name}" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold text-blue-700 mb-1">${product.name}</h3>
                    <p class="text-sm text-gray-500 mb-2 uppercase">${product.category}</p>
                    <p class="text-lg font-bold text-green-600 mb-4">Rp ${product.price.toLocaleString('id-ID')}</p>
                    <div class="flex gap-2">
                        <button class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 edit-product-btn" data-id="${product.id}">Edit</button>
                        <button class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 delete-product-btn" data-id="${product.id}">Hapus</button>
                    </div>
                </div>
            `;
            adminProductList.insertAdjacentHTML('beforeend', productCard);
        });

        // Tambahkan event listener untuk tombol Edit
        document.querySelectorAll('.edit-product-btn').forEach(button => {
            button.addEventListener('click', (event) => {
                const productId = parseInt(event.target.dataset.id);
                const productToEdit = allProducts.find(p => p.id === productId);
                if (productToEdit) {
                    modalTitle.textContent = 'Edit Produk';
                    document.getElementById('product-id').value = productToEdit.id;
                    document.getElementById('product-name').value = productToEdit.name;
                    document.getElementById('product-category').value = productToEdit.category;
                    document.getElementById('product-price').value = productToEdit.price;
                    document.getElementById('product-location').value = productToEdit.location;
                    document.getElementById('product-seller').value = productToEdit.seller;
                    document.getElementById('product-image').value = productToEdit.image;
                    document.getElementById('product-description').value = productToEdit.description;
                    productManageModal.showModal();
                }
            });
        });

        // Tambahkan event listener untuk tombol Hapus
        document.querySelectorAll('.delete-product-btn').forEach(button => {
            button.addEventListener('click', async (event) => {
                const productId = parseInt(event.target.dataset.id);
                if (confirm('Anda yakin ingin menghapus produk ini?')) {
                    try {
                        const response = await fetch(`/Public/admin/products_crud.php?id=${productId}`, {
                            method: 'DELETE',
                            credentials: 'include'
                        });
                        const data = await response.json();
                        if (data.success) {
                            alert('Produk berhasil dihapus!');
                            fetchAdminProducts(); // Muat ulang daftar produk
                        } else {
                            alert('Gagal menghapus produk: ' + (data.message || 'Terjadi kesalahan.'));
                        }
                    } catch (error) {
                        console.error('Error deleting product:', error);
                        alert('Terjadi kesalahan saat menghapus produk.');
                    }
                }
            });
        });
    };

    // Event listener untuk tombol "Tambah Produk Baru"
    addProductButton.addEventListener('click', () => {
        modalTitle.textContent = 'Tambah Produk Baru';
        productForm.reset(); // Kosongkan formulir
        document.getElementById('product-id').value = ''; // Kosongkan ID untuk produk baru
        productManageModal.showModal();
    });

    // Event listener untuk tombol "Batal" di modal
    cancelProductManageButton.addEventListener('click', () => {
        productManageModal.close();
    });

    // Event listener untuk pengiriman formulir (Tambah/Edit)
    productForm.addEventListener('submit', async (event) => {
        console.log('Submit form produk dipicu');
        event.preventDefault();
        const formData = new FormData(productForm);
        const productId = formData.get('id');
        const method = productId ? 'PUT' : 'POST'; // Jika ada ID, itu PUT (update), jika tidak, POST (create)

        const productData = {
            id: productId ? parseInt(productId) : null,
            name: formData.get('name'),
            category: formData.get('category'),
            price: parseFloat(formData.get('price')),
            location: formData.get('location'),
            seller: formData.get('seller'),
            image: formData.get('image'),
            description: formData.get('description')
        };

        try {
            const response = await fetch('/DHITOPEMWEB/Public/admin/products_crud.php', {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(productData)
            });
            const data = await response.json();

            if (data.success) {
                alert(data.message);
                productManageModal.close();
                fetchAdminProducts(); // Muat ulang daftar produk
            } else {
                alert('Gagal menyimpan produk: ' + (data.message || 'Terjadi kesalahan.'));
            }
        } catch (error) {
            console.error('Error saving product:', error);
            alert('Terjadi kesalahan saat menyimpan produk.');
        }
    });

    fetchAdminProducts(); // Panggil fungsi ini saat halaman dimuat
});
