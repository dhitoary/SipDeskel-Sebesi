// Data Produk Simulasi (akan dihapus atau diganti dengan fetch dari API)
// --- LOGIKA UNTUK NAVBAR AKTIF ---

document.addEventListener('DOMContentLoaded', () => {
    // Fungsi untuk mengatur link aktif berdasarkan URL halaman
    const setActiveNavLinks = () => {
        const currentPage = window.location.pathname.split('/').pop();

        // Handle Desktop Navbar
        const desktopLinks = document.querySelectorAll('#desktop-nav-links a.nav-link');
        desktopLinks.forEach(link => {
            const linkPage = link.getAttribute('href').split('/').pop();
            link.classList.remove('active');
            if (currentPage === linkPage || (currentPage === '' && linkPage === 'index.php') || (currentPage === 'index.php' && linkPage === 'Beranda.html')) {
                link.classList.add('active');
            }
        });

        // Handle Mobile Navbar
        const mobileLinks = document.querySelectorAll('#mobile-nav-links a.nav-link-mobile');
        mobileLinks.forEach(link => {
            const linkPage = link.getAttribute('href').split('/').pop();
            link.classList.remove('active');
            if (currentPage === linkPage || (currentPage === '' && linkPage === 'index.php') || (currentPage === 'index.php' && linkPage === 'Beranda.html')) {
                link.classList.add('active');
            }
        });
    };

    setActiveNavLinks();

    const navToggle = document.getElementById('nav-toggle');
    const mainNav = document.getElementById('main-nav');
    if (navToggle && mainNav) {
        navToggle.addEventListener('click', () => {
            mainNav.classList.toggle('hidden');
        });
    }

    // Redirect to login.php on login button click
if (loginButton) {
    loginButton.addEventListener('click', () => {
        window.location.href = '/DHITOPEMWEB/Public/login.php'; // Arahkan ke halaman login.php
    });
}

    // Handle logout button click
    if (logoutButton) {
        logoutButton.addEventListener('click', () => {
            fetch('/DHITOPEMWEB/App/api/logout.php', { // PERBAIKAN: Tambahkan '/DHITOPEMWEB' di awal URL
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (logoutButton) logoutButton.classList.add('hidden');
                    if (loginButton) loginButton.classList.remove('hidden');
                    alert('Logout successful');
                    location.reload(); // Reload halaman untuk memperbarui status
                } else {
                    alert('Logout failed');
                }
            })
            .catch(error => {
                alert('Error during logout request');
                console.error('Logout error:', error);
            });
        });
    }

    const loginButton = document.getElementById('login-button');
    console.log('Login Button element:', loginButton); // Tambahkan baris ini
    // ... kode yang sudah ada ...

    // Redirect to login.php on login button click
    if (loginButton) {
        loginButton.addEventListener('click', () => {
            console.log('Login button clicked, redirecting...'); // Tambahkan baris ini
            window.location.href = '/DHITOPEMWEB/Public/login.php';
        });
    }
});

// --- AKHIR LOGIKA NAVBAR ---

// --- LOGIKA UNTUK JADWAL SHOLAT DINAMIS (DENGAN LOGIKA AKTIF YANG BENAR) ---
document.addEventListener('DOMContentLoaded', () => {
    const widget = document.getElementById('jadwal-sholat-widget');
    if (widget) {
        // Data jadwal sholat tetap statis di sini karena biasanya tidak berubah dari DB
        // atau bisa fetch dari API eksternal jika ada.
        // Untuk saat ini, asumsikan data ini cukup statis.
        const prayerTimesData = [
            { name: "Imsak", waktu: "04:29" },
            { name: "Shubuh", waktu: "04:39" },
            { name: "Terbit", waktu: "06:02" },
            { name: "Dzuhur", waktu: "11:56" },
            { name: "Ashar", waktu: "15:19" },
            { name: "Maghrib", waktu: "17:50" },
            { name: "Isya", waktu: "19:04" }
        ];

        const renderPrayerTimes = () => {
            const prayerTimesContainer = document.getElementById('prayer-times-container');
            if (!prayerTimesContainer) return;

            prayerTimesContainer.innerHTML = ''; // Kosongkan container

            prayerTimesData.forEach(p => {
                const div = document.createElement('div');
                div.classList.add('prayer-time');
                div.dataset.nama = p.name;
                div.dataset.waktu = p.waktu;
                div.innerHTML = `<p class="text-sm">${p.name}</p><h4 class="font-bold text-lg">${p.waktu}</h4>`;
                prayerTimesContainer.appendChild(div);
            });
        };

        const updateJadwalSholat = () => {
            let prayerTimeElements = document.querySelectorAll('#prayer-times-container .prayer-time'); // PASTIKAN INI 'let', BUKAN 'const'
            if (prayerTimeElements.length === 0) {
                renderPrayerTimes();
                prayerTimeElements = document.querySelectorAll('#prayer-times-container .prayer-time');
            }

            const getWIBTime = () => {
                const now = new Date();
                const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
                const wibOffset = 7 * 3600000;
                return new Date(utc + wibOffset);
            };

            const nowInWIB = getWIBTime();

            const prayerTimes = [];
            prayerTimeElements.forEach(el => {
                const waktu = el.dataset.waktu;
                const [jam, menit] = waktu.split(':');

                const prayerDate = new Date(nowInWIB);
                prayerDate.setHours(parseInt(jam), parseInt(menit), 0, 0);

                prayerTimes.push({
                    element: el,
                    date: prayerDate
                });
            });

            let activePrayerIndex = -1;
            for (let i = 0; i < prayerTimes.length; i++) {
                if (prayerTimes[i].date <= nowInWIB) {
                    activePrayerIndex = i;
                }
            }

            if (activePrayerIndex === -1) {
                activePrayerIndex = prayerTimes.length - 1;
            }

            prayerTimeElements.forEach(el => {
                el.classList.remove('jadwal-aktif');
            });

            if (prayerTimeElements[activePrayerIndex]) {
                prayerTimeElements[activePrayerIndex].classList.add('jadwal-aktif');
            }

            const tanggalElement = document.getElementById('tanggal-sekarang');
            if (tanggalElement) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Jakarta' };
                tanggalElement.textContent = new Date().toLocaleDateString('id-ID', options);
            }
        };

        updateJadwalSholat();
        setInterval(updateJadwalSholat, 60000);
    }
});
// --- AKHIR LOGIKA JADWAL SHOLAT ---

// Array untuk menyimpan data produk (akan diisi dari API)
let products = [];

// Fungsi untuk mengambil data produk dari API
async function fetchProducts() {
    try {
        const response = await fetch('/DHITOPEMWEB/App/api/products.php'); // PERBAIKAN: Tambahkan '/DHITOPEMWEB' di awal URL
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        products = await response.json();
        filterAndSearchProducts(); // Setelah data didapat, render produk
    } catch (error) {
        console.error('Failed to fetch products:', error);
        const productGrid = document.getElementById('product-grid');
        const noProductsMessage = document.getElementById('no-products-message');
        if (productGrid) productGrid.innerHTML = '<p class="text-center text-red-500">Gagal memuat produk. Silakan coba lagi nanti.</p>';
        if (noProductsMessage) noProductsMessage.classList.add('hidden'); // Sembunyikan pesan "tidak ada produk"
    }
}

// Fungsi untuk merender produk
function renderProducts(filteredProducts) {
    const productGrid = document.getElementById('product-grid');
    const noProductsMessage = document.getElementById('no-products-message');

    if (!productGrid || !noProductsMessage) {
        //console.log("Product grid or no products message element not found. Skipping product rendering.");
        return; // Hentikan jika elemen tidak ada di halaman ini
    }

    productGrid.innerHTML = '';
    if (filteredProducts.length === 0) {
        noProductsMessage.classList.remove('hidden');
    } else {
        noProductsMessage.classList.add('hidden');
    }

    filteredProducts.forEach(product => {
        const productCard = `
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300 cursor-pointer product-card" data-product-id="${product.id}">
                <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-blue-700 mb-2">${product.name}</h3>
                    <p class="text-sm text-gray-500 mb-1 uppercase">${product.category}</p>
                    <p class="text-lg font-bold text-green-600 mb-2">Rp ${product.price.toLocaleString('id-ID')}</p>
                    <p class="text-sm text-gray-600 flex items-center mb-1">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        ${product.location}
                    </p>
                    <p class="text-sm text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        ${product.seller}
                    </p>
                </div>
            </div>
        `;
        productGrid.insertAdjacentHTML('beforeend', productCard);
    });

    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', (event) => {
            const productId = parseInt(event.currentTarget.dataset.productId);
            showProductDetailModal(productId);
        });
    });
}

// Fungsi untuk melakukan filter dan pencarian
function filterAndSearchProducts() {
    const categoryFilter = document.getElementById('category-filter');
    const searchInput = document.getElementById('search-input');

    const selectedCategory = categoryFilter ? categoryFilter.value : 'all';
    const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';

    let filteredProducts = products.filter(product => {
        const matchesCategory = selectedCategory === 'all' || product.category === selectedCategory;
        const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                                    (product.description && product.description.toLowerCase().includes(searchTerm)) || // Pastikan description ada
                                    product.seller.toLowerCase().includes(searchTerm);
        return matchesCategory && matchesSearch;
    });

    renderProducts(filteredProducts);
}

// Array untuk menyimpan data artikel wisata (akan diisi dari API)
let tourismArticles = [];

// Fungsi untuk mengambil data artikel wisata dari API
async function fetchTourismArticles() {
    try {
        const response = await fetch('/DHITOPEMWEB/App/api/tourism.php'); // PERBAIKAN: Tambahkan '/DHITOPEMWEB' di awal URL
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        tourismArticles = await response.json();
        renderTourismArticles(tourismArticles); // Panggil render dengan data yang sudah difetch
    } catch (error) {
        console.error('Failed to fetch tourism articles:', error);
        const tourismArticlesContainer = document.getElementById('tourism-articles');
        const noTourismMessage = document.getElementById('no-tourism-message');
        if (tourismArticlesContainer) tourismArticlesContainer.innerHTML = '<p class="text-center text-red-500">Gagal memuat artikel wisata. Silakan coba lagi nanti.</p>';
        if (noTourismMessage) noTourismMessage.classList.add('hidden');
    }
}

// Fungsi untuk menampilkan detail artikel wisata di modal
function showArticleDetail(articleId) {
    const article = tourismArticles.find((a) => a.id === articleId);
    if (!article) return;

    const modal = document.getElementById("article-detail-modal");
    const modalContent = document.getElementById("article-detail-content");

    if (!modal || !modalContent) return; // Pastikan elemen modal ada

    modalContent.innerHTML = `
        <div class="p-4 flex flex-col gap-4">
            <h3 class="text-3xl font-bold mb-4">${article.title}</h3>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3 flex justify-center">
                    <img src="${article.image}" alt="${article.title}" class="w-full h-auto object-cover rounded max-h-64" />
                </div>
                <div class="md:w-2/3 flex flex-col">
                    <p class="mb-4">${article.description}</p>
                    <div class="aspect-w-16 aspect-h-9 mb-4">
                        <iframe src="${article.map_embed}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <hr class="border-t border-gray-300 my-4" />
                    <form id="review-form" class="w-full max-w-lg mx-auto">
                        <h4 class="text-xl font-semibold mb-2 text-center">Berikan Review Anda</h4>
                        <div class="flex justify-center mb-4">
                            <label for="rating" class="sr-only">Rating Bintang</label>
                            <select id="rating" name="rating" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled selected>Pilih Rating</option>
                                <option value="5">★★★★★</option>
                                <option value="4">★★★★☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="1">★☆☆☆☆</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="review" class="sr-only">Ulasan</label>
                            <textarea id="review" name="review" rows="4" placeholder="Tulis ulasan Anda di sini..." class="w-full border border-gray-300 rounded px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded hover:bg-blue-700 transition-colors duration-300">Kirim Review</button>
                        </div>
                    </form>
                    <div id="existing-reviews" class="mt-6">
                        <h4 class="text-xl font-semibold mb-2 text-center">Ulasan Pengguna</h4>
                        <ul id="review-list" class="list-disc list-inside text-gray-700 min-h-[50px]">
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    `;

    modal.style.display = "flex";
    modal.setAttribute("open", "");
    document.body.style.overflow = "hidden";

    document.getElementById("close-article-modal").addEventListener("click", () => {
        modal.style.display = "none";
        modal.removeAttribute("open");
        document.body.style.overflow = "auto";
    });

    // Add event listener for review form submission inside the modal
    const reviewForm = modalContent.querySelector("#review-form");
    if (reviewForm) {
        reviewForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const rating = reviewForm.querySelector("#rating").value;
            const reviewText = reviewForm.querySelector("#review").value.trim();

            if (!rating || !reviewText) {
                alert("Rating dan ulasan tidak boleh kosong.");
                return;
            }

            try {
                const response = await fetch('/DHITOPEMWEB/App/api/submit_review.php', { // PERBAIKAN: Tambahkan '/DHITOPEMWEB' di awal URL
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ article_id: articleId, rating, review_text })
                });
                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    const reviewList = modalContent.querySelector("#review-list");
                    if (reviewList) {
                        const reviewItem = document.createElement("li");
                        reviewItem.innerHTML = `<strong>${'★'.repeat(rating)}</strong> - ${reviewText}`;
                        reviewList.appendChild(reviewItem);
                    }
                    reviewForm.reset();
                } else {
                    alert('Gagal mengirim review: ' + (data.message || 'Terjadi kesalahan.'));
                }
            } catch (error) {
                console.error('Error submitting review:', error);
                alert('Terjadi kesalahan saat mengirim review.');
            }
        });
    }
}


// Array untuk menyimpan data aparatur desa (akan diisi dari API)
let villageOfficials = [];

// Fungsi untuk mengambil data aparatur desa dari API
async function fetchVillageOfficials() {
    try {
        const response = await fetch('/DHITOPEMWEB/App/api/officials.php'); // PERBAIKAN: Tambahkan '/DHITOPEMWEB' di awal URL
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        villageOfficials = await response.json();
        renderVillageOfficials(); // Setelah data didapat, render aparatur desa
    } catch (error) {
        console.error('Failed to fetch village officials:', error);
        // Menggunakan ID spesifik dari index.php untuk pesan error
        const officialsContainer = document.getElementById('main-official-card').parentElement; // Get parent of main-official-card
        if (officialsContainer) officialsContainer.innerHTML = '<p class="text-center text-red-500 col-span-full">Gagal memuat data aparatur desa.</p>';
    }
}

// Fungsi untuk merender aparatur desa
function renderVillageOfficials() {
    const mainOfficialContainer = document.getElementById('main-official-card'); // OK
    const otherOfficialsContainer = document.getElementById('other-officials-container'); // OK

    if (!mainOfficialContainer || !otherOfficialsContainer) {
        //console.log("Containers for officials not found. Skipping official rendering.");
        return;
    }

    // Membersihkan konten placeholder di main-official-card
    mainOfficialContainer.innerHTML = '';

    otherOfficialsContainer.innerHTML = ''; // Membersihkan kontainer lain

    // Temukan Kepala Desa dari data yang diambil (case-insensitive)
    const syamsiar = villageOfficials.find(official => official.position && official.position.toLowerCase() === 'kepala desa'); // PERBAIKAN: Cek official.position sebelum toLowerCase() dan jadikan case-insensitive

    if (syamsiar) {
        // Konten untuk Kepala Desa
        mainOfficialContainer.innerHTML = `
            <img class="w-full max-sm:aspect-[3/4] md:h-96 object-cover rounded-t-lg" alt="${syamsiar.name}" src="${syamsiar.image}" />
            <div class="flex flex-col items-center justify-center gap-1 p-4 overflow-hidden">
                <h4 class="text-lg font-bold line-clamp-1">${syamsiar.name}</h4>
                <h4 class="font-semibold badge badge-primary">${syamsiar.position}</h4>
                <p class="text-sm">
                    <i class="mr-1 icon-phone"></i>
                    ${syamsiar.phone || 'N/A'}
                </p>
                <p class="text-sm text-balance">
                    <i class="mr-1 icon-envelope"></i>
                    ${syamsiar.email || 'N/A'}
                </p>
            </div>
        `;
    } else {
        // Jika Kepala Desa tidak ditemukan, tampilkan pesan
        mainOfficialContainer.innerHTML = '<p class="text-center text-red-500 p-4 col-span-full">Data Kepala Desa tidak ditemukan.</p>';
    }

    // Filter out the 'Kepala Desa' (case-insensitive) for other officials
    const otherOfficials = villageOfficials.filter(official => official.position && official.position.toLowerCase() !== 'kepala desa'); // PERBAIKAN: Cek official.position sebelum toLowerCase() dan jadikan case-insensitive

    otherOfficials.forEach(official => {
        const officialCard = `
            <div class="w-48 h-64 md:h-full lg:h-auto relative flex rounded-lg shadow overflow-hidden">
                <img src="${official.image}" alt="${official.name}" class="inset-0 w-full h-full absolute object-cover">
                <div class="flex flex-col justify-center mt-auto w-full p-2 text-white bg-black/60 text-center hover:h-full h-16 group transition-all duration-300 backdrop-blur-sm">
                    <h4 class="font-semibold line-clamp-1 group-hover:line-clamp-none">${official.name}</h4>
                    <h4 class="text-sm font-light line-clamp-1 group-hover:line-clamp-none">${official.position}</h4>
                </div>
            </div>
        `;
        otherOfficialsContainer.insertAdjacentHTML('beforeend', officialCard);
    });
}

// Array untuk menyimpan data video (akan diisi dari API)
let videos = [];

// Fungsi untuk mengambil data video dari API
async function fetchVideos() {
    try {
        const response = await fetch('/DHITOPEMWEB/App/api/videos.php'); // PERBAIKAN: Tambahkan '/DHITOPEMWEB' di awal URL
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        videos = await response.json();
        console.log('Data video diterima:', videos);
        renderVideos(); // Setelah data didapat, render video
    } catch (error) {
        console.error('Failed to fetch videos:', error);
        const videosContainer = document.getElementById('videos-container'); // OK
        if (videosContainer) videosContainer.innerHTML = '<p class="text-center text-red-500">Gagal memuat video.</p>';
    }
}

// Fungsi untuk merender video
function renderVideos() {
    const videosContainer = document.getElementById('videos-container'); // OK
    if (!videosContainer) {
        //console.log("Videos container not found. Skipping video rendering.");
        return;
    }

    videosContainer.innerHTML = ''; // Kosongkan container

    videos.forEach(video => {
        const formattedDate = new Date(video.upload_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }).toUpperCase();
        const videoCard = `
            <div class="shadow rounded-lg overflow-hidden w-72 lg:w-80">
                <iframe class="w-full aspect-video object-center object-cover"
                        src="https://www.youtube.com/embed/${video.youtube_id}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe> <div class="h-24 content-shadow-video bg-white py-2 px-4">
                    <h4 class="mb-2 text-lg font-semibold line-clamp-1">${video.title}</h4>
                    <h5 class="text-xs font-light">${formattedDate}</h5>
                    <div class="flex justify-between"><h5 class="text-xs font-light"></h5><h5 class="text-xs font-light">${video.category}</h5></div>
                </div>
            </div>
        `;
        videosContainer.insertAdjacentHTML('beforeend', videoCard);
    });
}


// Initial setup on page load
document.addEventListener('DOMContentLoaded', () => {
    // Panggil fetch functions hanya jika elemen-elemen yang relevan ada di halaman saat ini
    if (document.getElementById('product-grid')) {
        fetchProducts(); // Untuk Desamart
        const categoryFilterElement = document.getElementById('category-filter');
        const searchInput = document.getElementById('search-input');
        if (categoryFilterElement) {
            categoryFilterElement.addEventListener('change', filterAndSearchProducts);
        }
        if (searchInput) {
            searchInput.addEventListener('keyup', filterAndSearchProducts);
        }
    }

    if (document.getElementById('tourism-articles')) {
        fetchTourismArticles(); // Untuk Wisata
        const tourismCategoryFilterElement = document.querySelector('#ecotourism #category-filter'); // Specific for tourism
        const tourismSearchInput = document.querySelector('#ecotourism #search-input'); // Specific for tourism
        if (tourismCategoryFilterElement) {
            tourismCategoryFilterElement.addEventListener('change', filterAndSearchTourismArticles);
        }
        if (tourismSearchInput) {
            tourismSearchInput.addEventListener('keyup', filterAndSearchTourismArticles);
        }
    }

    // Panggil fungsi untuk aparatur desa dan video di halaman Beranda
    // Memastikan elemen ada sebelum memanggil fungsi fetch
    if (document.getElementById('slideshow')) { // Indikator bahwa ini halaman Beranda
        fetchVillageOfficials();
        fetchVideos();
    }


    // JavaScript untuk Toggle Navigasi Mobile (sudah ada di bagian atas DOMContentLoaded)
    // ...

    // Smooth scrolling untuk link navigasi yang mengarah ke ID di halaman yang sama
    // (JANGAN HAPUS, ini penting untuk SPA-like behavior jika ada anchor di page yang sama)
    document.querySelectorAll('a.nav-link[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
            const mainNav = document.getElementById('main-nav');
            if (mainNav && !mainNav.classList.contains('hidden') && window.innerWidth < 1024) {
                mainNav.classList.add('hidden');
                mainNav.classList.remove('flex', 'flex-col');
            }
        });
    });

    // Filtering and search for Tourism Articles
    function filterAndSearchTourismArticles() {
        const categoryFilter = document.querySelector('#ecotourism #category-filter');
        const searchInput = document.querySelector('#ecotourism #search-input');

        const selectedCategory = categoryFilter ? categoryFilter.value : 'all';
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';

        let filteredArticles = tourismArticles.filter(article => {
            const matchesCategory = selectedCategory === 'all' || article.category.toLowerCase().includes(selectedCategory.toLowerCase());
            const matchesSearch = article.title.toLowerCase().includes(searchTerm) ||
                                  article.description.toLowerCase().includes(searchTerm) ||
                                  article.location.toLowerCase().includes(searchTerm);
            return matchesCategory && matchesSearch;
        });

        renderTourismArticles(filteredArticles);
    }
});


// JavaScript untuk Product Detail Modal
const productDetailModal = document.getElementById('product-detail-modal');
const productDetailContent = document.getElementById('product-detail-content');
const productModalCloseButton = document.querySelector('.product-modal-close');

if (productDetailModal && productModalCloseButton) {
    productModalCloseButton.addEventListener('click', () => {
        productDetailModal.style.display = 'none';
        productDetailModal.removeAttribute('open');
    });

    window.addEventListener('click', (event) => {
        if (event.target == productDetailModal) {
            productDetailModal.style.display = 'none';
            productDetailModal.removeAttribute('open');
        }
    });
}


function showProductDetailModal(productId) {
    const product = products.find(p => p.id === productId);
    if (!product || !productDetailContent || !productDetailModal) return;

    productDetailContent.innerHTML = `
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-1/2">
                <img src="${product.image}" alt="${product.name}" class="w-full h-auto object-cover rounded-lg shadow-md">
            </div>
            <div class="md:w-1/2">
                <h3 class="text-3xl font-bold text-blue-800 mb-3">${product.name}</h3>
                <p class="text-md text-gray-600 mb-2 uppercase">${product.category}</p>
                <p class="text-2xl font-bold text-green-700 mb-4">Rp ${product.price.toLocaleString('id-ID')}</p>
                <p class="text-gray-700 mb-4">${product.description}</p>
                <p class="text-sm text-gray-600 flex items-center mb-1">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    Lokasi: ${product.location}
                </p>
                <p class="text-sm text-gray-600 flex items-center mb-4">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    Penjual: ${product.seller}
                </p>
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full transition-colors duration-300 shadow-md">Beli Sekarang</button>
            </div>
        </div>
    `;
    productDetailModal.style.display = 'flex';
    productDetailModal.setAttribute('open', '');
}


// Fungsi untuk menangani pembukaan/penutupan modal dari footer
function showModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
        modal.setAttribute('open', '');
    }
}

// Event listeners untuk modal footer
document.querySelectorAll('dialog.modal .modal-action button').forEach(button => {
    button.addEventListener('click', (event) => {
        const modal = event.target.closest('dialog.modal');
        if (modal) {
            modal.style.display = 'none';
            modal.removeAttribute('open');
        }
    });
});

// Tutup modal footer jika pengguna mengklik di luar area modal
window.addEventListener('click', (event) => {
    const modals = document.querySelectorAll('dialog.modal');
    modals.forEach(modal => {
        if (event.target === modal && modal.id !== 'product-detail-modal' && modal.id !== 'article-detail-modal') {
            modal.style.display = 'none';
            modal.removeAttribute('open');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll("#slideshow .slide");
    if (slides.length > 0) { // Hanya jalankan slideshow jika ada elemen slide
        let currentIndex = 0;
        const slideInterval = 4000;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.classList.add("active");
                } else {
                    slide.classList.remove("active");
                }
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        setInterval(nextSlide, slideInterval);
    }
});