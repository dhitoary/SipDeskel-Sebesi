<div class="py-4 text-white border-t-4 border-blue-400 bg-primary">
        <div class="container p-4 mx-auto lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div>
                    <h4 class="pb-1 mb-2 text-lg text-center border-b-2 border-white lg:text-left">Link Terkait</h4>
                    <div class="grid grid-cols-3 gap-2 text-xs font-semibold text-center text-black">
                        <a href="https://id.wikipedia.org/wiki/Pulau_Sebesi" class="flex flex-col p-2 rounded-lg bg-base-100 aspect-square" target="_blank">
                            <img src="Images/sebesi.jpeg" alt="Pulau Sebesi" class="object-contain m-auto size-14">
                            <p class="line-clamp-2">Pulau Sebesi</p>
                        </a>
                        <a href="https://lampungselatankab.go.id" class="flex flex-col p-2 rounded-lg bg-base-100 aspect-square" target="_blank">
                            <img src="Images/lamsel.jpg" alt="Lampung Selatan" class="object-contain m-auto size-14">
                            <p class="line-clamp-2">Lampung Selatan</p>
                        </a>
                        <a href="https://lampungprov.go.id" class="flex flex-col p-2 rounded-lg bg-base-100 aspect-square" target="_blank">
                            <img src="Images/download.png" alt="Provinsi Lampung" class="object-contain m-auto size-14">
                            <p class="line-clamp-2">Provinsi Lampung</p>
                        </a>
                    </div>
                </div>
                <div class="flex flex-col">
                    <h4 class="pb-1 mb-2 text-lg text-center border-b-2 border-white lg:text-left">Hubungi Kami</h4>
                    <div class="flex flex-col items-center gap-2 mb-4 md:flex-row md:items-start">
                        <img id="imgLogoDesa" class="object-contain w-20 aspect-[3/4] p-2 rounded-lg bg-blue-400/40" alt="logo" src="Images/18_01_16_2014_logo_desa.jpg" />
                        <div class="text-center md:text-left">
                            <h4 class="text-lg font-semibold lg:text-xl"><span id="lblNamaDesa">Pulau Sebesi</span></h4>
                            <p class="text-xs lg:text-sm"><span id="lblAlamatDesa">Desa Tejang, Pulau Sebesi, Kecamatan Raja Basa, Kabupaten Lampung Selatan</span></p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1 px-2 text-xs font-semibold text-center lg:text-sm md:text-left">
                        <p><i class="mr-2 icon-phone"></i><span id="lblTelponDesaFooter">082184180359</span></p>
                        <p><i class="mr-2 icon-envelope"></i><span id="lblEmailDesaFooter">contact@pulausebesi.com</span></p>
                        <div class="flex justify-center gap-2 mt-2 md:justify-start">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <h4 class="pb-1 mb-2 text-lg text-center border-b-2 border-white lg:text-left">Lokasi Balai Desa</h4>
                    <span id="literalMap"><div class="flex flex-col"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63498.08982356496!2d105.45578261276283!3d-5.907386983546514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e416b8ba8c01793%3A0xbc4340562025b433!2sTejang%20Pulau%20Sebesi%2C%20Rajabasa%2C%20Kabupaten%20Lampung%20Selatan%2C%20Lampung!5e0!3m2!1sid!2sid!4v1749049634842!5m2!1sid!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div></span>
                </div>
            </div>
        </div>
        <div class="pt-4 pb-20 border-t-4 border-white lg:pb-4 bg-primary">
            <footer>
                <div class="flex flex-col items-center justify-center gap-4 px-4 pb-4 lg:flex-row lg:justify-between lg:px-8">
                    <img src="Images/download.png" alt="Logo Provinsi Lampung" style="width: 64px; aspect-ratio: 3/4; object-fit: contain;">
                    <p class="flex-1 text-lg font-semibold text-center text-white capitalize">
                        Portal Resmi Informasi Wisata dan Produk <br>Pulau Sebesi, Kec. Raja Basa, Kab. Lampung Selatan, Prov. Lampung
                    </p>
                    <img src="Images/18_01_16_2014_logo_desa.jpg" alt="Logo Desa" style="width: 96px; aspect-ratio: 1/1; object-fit: contain;">
                </div>
                <div class="container flex flex-col items-center justify-center pb-4 mx-auto text-white">
                    <p>Informasi Pulau Sebesi</p>
                    <div class="flex gap-2">
                        <button onclick="showModal('ketentuan_layanan')">Ketentuan Layanan</button> | <button onclick="showModal('pedoman_siber')">Pedoman Siber</button> | <button onclick="showModal('privasi')">Privasi</button>
                    </div>
                </div>
                <div class="border-t-2 border-white"></div>
                <div class="pt-4 font-semibold text-white max-sm:text-sm">
                    <div class="container flex justify-between max-sm:gap-2 gap-4 max-sm:text-xs text-sm mx-auto text-center max-sm:px-4">
                        <p>Pulau Sebesi © 2025</p>
                        <p>V1.0.0</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <dialog id="product-detail-modal" class="modal">
        <div class="modal-content">
            <span class="close-button product-modal-close">×</span>
            <div id="product-detail-content">
                </div>
        </div>
    </dialog>

    <dialog id="article-detail-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full max-h-[80vh] overflow-auto p-6 relative">
            <button id="close-article-modal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-2xl font-bold">×</button>
            <div id="article-detail-content"></div>
        </div>
    </dialog>

    <dialog id="ketentuan_layanan" class="modal">
        <div class="modal-box w-full max-w-4xl">
            <h4 class="text-2xl font-bold mb-4">KETENTUAN LAYANAN PULAU SEBESI</h4>
            <div class="prose max-w-none">
                <p><b>1. Pendahuluan</b></p>
                <p>Website Pulau Sebesi ini dirancang untuk menyediakan informasi wisata dan produk lokal Pulau Sebesi.</p>
                <p><b>2. Penggunaan Konten</b></p>
                <p>Semua konten (teks, gambar, video) yang tersedia di website ini adalah milik Pulau Sebesi atau telah mendapatkan izin penggunaan. Penggunaan kembali konten tanpa izin adalah dilarang.</p>
            </div>
            <div class="modal-action mt-4">
                <form method="dialog">
                    <button class="btn btn-error max-sm:w-full btn-sm">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="pedoman_siber" class="modal">
        <div class="modal-box w-full max-w-4xl">
            <h4 class="text-2xl font-bold mb-4">PEDOMAN KEAMANAN SIBER PULAU SEBESI</h4>
            <div class="prose max-w-none">
                <p><b>1. Keamanan Informasi</b></p>
                <p>Kami berkomitmen untuk menjaga keamanan informasi pengguna. Segala upaya akan dilakukan untuk melindungi data dari akses tidak sah.</p>
                <p><b>2. Tanggung Jawab Pengguna</b></p>
                <p>Pengguna diharapkan tidak menyebarkan informasi palsu atau merusak melalui website ini.</p>
            </div>
            <div class="modal-action mt-4">
                <form method="dialog">
                    <button class="btn btn-error max-sm:w-full btn-sm">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>

    <dialog id="privasi" class="modal">
        <div class="modal-box w-full max-w-4xl">
            <h4 class="text-2xl font-bold mb-4">KEBIJAKAN PRIVASI PULAU SEBESI</h4>
            <div class="prose max-w-none">
                <p><b>1. Data yang Dikumpulkan</b></p>
                <p>Kami mungkin mengumpulkan data non-pribadi seperti kebiasaan Browse untuk meningkatkan pengalaman pengguna.</p>
                <p><b>2. Penggunaan Data</b></p>
                <p>Data yang dikumpulkan hanya digunakan untuk tujuan internal dan tidak akan dibagikan kepada pihak ketiga tanpa persetujuan pengguna.</p>
            </div>
            <div class="modal-action mt-4">
                <form method="dialog">
                    <button class="btn btn-error max-sm:w-full btn-sm">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>

    <?php include __DIR__ . '/login_modal.php'; // Include the login modal ?>

    <script src="SIPDeskel.js"></script>
</body>
</html>