<?php
$pageTitle = 'Pulau Sebesi - Beranda';
$cssFile = 'Beranda.css'; // Pastikan CSS ini ada di public/
include_once __DIR__ . '/../templates/header.php'; // Path relatif ke header.php
?>

    <main class="flex-grow">
        <div class="relative overflow-hidden bg-primary">
            <div class="w-full max-w-5xl p-4 py-8 mx-auto">
                <div class="flex flex-col items-center justify-between max-sm:gap-4 gap-10 md:flex-row">
                    <div class="flex-1">
                        <div class="flex items-start gap-2 mb-8 text-white md:gap-4">
                            <img id="content_imgLogo" class="object-contain w-20 md:w-32 aspect-[3/4] rounded-lg shadow-lg bg-blue-400/40 p-2" alt="logo" src="Images/18_01_16_2014_logo_desa.jpg" />
                            <div class="flex-1">
                                <h3 class="text-xl font-bold sm:text-lg md:text-3xl lg:text-4xl">
                                    Pulau Sebesi
                                </h3>
                                <h6 class="text-xs font-normal break-words sm:text-base md:text-lg lg:text-xl lg:font-semibold">
                                    Desa Tejang, Pulau Sebesi, Kecamatan Raja Basa, Kabupaten Lampung Selatan Telp. 082184180359 Email contact@pulausebesi.com
                                </h6>
                            </div>
                        </div>
                        <div id="jadwal-sholat-widget" class="overflow-x-auto max-md:hidden">
                            <div class="max-w-3xl min-w-[768px] md:min-w-full md:w-full rounded-xl overflow-hidden block shadow-lg">
                                <div id="prayer-times-container" class="grid grid-cols-7 text-center text-white p-4 bg-sky-600">
                                    </div>
                                <div class="bg-white py-2 flex flex-wrap items-center gap-x-4 gap-y-1 justify-center text-sm">
                                    <span id="tanggal-sekarang" class="font-semibold text-gray-700"></span>
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-1.5 rounded-full bg-sky-600"></div>
                                        <p class="text-gray-700">Lokasi : <span id="content_lokasiDesa" class="font-semibold text-sky-700">Desa Tejang Pulau Sebesi</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-64">
                        <div id="slideshow" class="relative mx-auto mt-4 rounded-lg shadow-lg p-4 hover:shadow-xl transition-shadow duration-300 bg-white" style="max-width: 16rem; height: 20rem; overflow: hidden;">
                            <div class="slide active">
                                <img src="Images/tejang.jpg" alt="Foto Desa Tejang" />
                                <div class="slide-caption">Desa Tejang</div>
                            </div>
                            <div class="slide">
                                <img src="Images/pantai.jpg" alt="Foto Desa Tejang" />
                                <div class="slide-caption">Desa Tejang</div>
                            </div>
                            <div class="slide">
                                <img src="Images/desa.jpg" alt="Foto Desa Tejang" />
                                <div class="slide-caption">Desa Tejang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-gelombang-png">
            <div class="gelombang-png gelombang1"></div>
            <div class="gelombang-png gelombang2"></div>
            <div class="gelombang-png gelombang3"></div>
            <div class="gelombang-png gelombang4"></div>
        </div>

        <section class="py-10 bg-base-100">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-primary mb-8">Jelajahi Pulau Sebesi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <a href="desamart.php" class="block bg-green-500 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                        <h3 class="text-3xl font-bold mb-4">Produk Unggulan</h3>
                        <p class="text-lg">Temukan hasil bumi dan kerajinan tangan khas Pulau Sebesi.</p>
                        <button class="mt-6 bg-white text-green-700 font-semibold py-3 px-6 rounded-full hover:bg-gray-100 transition-colors">Lihat Produk</button>
                    </a>
                    <a href="wisata.php" class="block bg-blue-500 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 text-center">
                        <h3 class="text-3xl font-bold mb-4">Destinasi Wisata</h3>
                        <p class="text-lg">Nikmati keindahan alam dan spot menarik di Pulau Sebesi.</p>
                        <button class="mt-6 bg-white text-blue-700 font-semibold py-3 px-6 rounded-full hover:bg-gray-100 transition-colors">Lihat Wisata</button>
                    </a>
                </div>
            </div>
        </section>

        <div class="py-10 bg-primary">
            <div class="container p-4 mx-auto">
                <h3 class="px-4 pb-2 mx-auto mb-4 text-3xl font-semibold text-center text-white border-b-4 border-white w-fit">Aparatur Desa</h3>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" style="margin-bottom: 3rem;">
                    <div id="main-official-card" class="flex flex-col bg-base-100 rounded-lg">
                        <img class="w-full max-sm:aspect-[3/4] md:h-96 object-cover rounded-t-lg" alt="Kepala Desa Placeholder" src="Images/placeholder.jpg" /> <div class="flex flex-col items-center justify-center gap-1 p-4 overflow-hidden">
                            <h4 class="text-lg font-bold line-clamp-1">Memuat...</h4>
                            <h4 class="font-semibold badge badge-primary">Memuat...</h4>
                            <p class="text-sm">
                                <i class="mr-1 icon-phone"></i>
                                Memuat...
                            </p>
                            <p class="text-sm text-balance">
                                <i class="mr-1 icon-envelope"></i>
                                Memuat...
                            </p>
                        </div>
                    </div>
                    <div class="flex overflow-x-scroll lg:col-span-2 xl:col-span-3 scroll-theme-white">
                        <div class="grid grid-flow-col grid-rows-2 gap-2 pb-2" id="other-officials-container">
                             </div>
                    </div>
                </div>
                <div class="py-10 bg-base-100">
                    <div class="container p-4 mx-auto">
                        <h3 class="px-4 pb-2 mx-auto mb-4 text-3xl font-semibold text-center border-b-4 border-black w-fit">Video</h3>
                        <div class="flex h-full overflow-x-auto scroll-theme-primary pb-2.5">
                            <div class="inline-flex gap-4 max-sm:gap-2">
                                <div class="shadow rounded-lg overflow-hidden w-72 lg:w-80">
                                    <iframe class="w-full aspect-video object-center object-cover" src="https://www.youtube.com/embed/nrK0wVr-lVQ" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    <div class="h-24 content-shadow-video bg-white py-2 px-4">
                                        <h4 class="mb-2 text-lg font-semibold line-clamp-1">Tejang Pulau Sebesi Electrical Goes to Village</h4>
                                        <h5 class="text-xs font-light">8 JANUARI 2025</h5>
                                        <div class="flex justify-between"><h5 class="text-xs font-light"></h5><h5 class="text-xs font-light">Profil Desa</h5></div>
                                    </div>
                                </div>
                                <div class="shadow rounded-lg overflow-hidden w-72 lg:w-80">
                                    <iframe class="w-full aspect-video object-center object-cover" src="https://www.youtube.com/embed/onxiZWjtqnM" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    <div class="h-24 content-shadow-video bg-white py-2 px-4">
                                        <h4 class="mb-2 text-lg font-semibold line-clamp-1">Keindahan Alam Pulau Sebesi</h4>
                                        <h5 class="text-xs font-light">15 FEBRUARI 2025</h5>
                                        <div class="flex justify-between"><h5 class="text-xs font-light"></h5><h5 class="text-xs font-light">Wisata Alam</h5></div>
                                    </div>
                                </div>
                                <div class="shadow rounded-lg overflow-hidden w-72 lg:w-80">
                                    <iframe class="w-full aspect-video object-center object-cover" src="https://www.youtube.com/embed/q1mY74sYhJs" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    <div class="h-24 content-shadow-video bg-white py-2 px-4">
                                        <h4 class="mb-2 text-lg font-semibold line-clamp-1">Kearifan Lokal dan Budaya</h4>
                                        <h5 class="text-xs font-light">22 MARET 2025</h5>
                                        <div class="flex justify-between"><h5 class="text-xs font-light"></h5><h5 class="text-xs font-light">Budaya</h5></div>
                                    </div>
                                </div>
                                <div class="shadow rounded-lg overflow-hidden w-72 lg:w-80">
                                    <iframe class="w-full aspect-video object-center object-cover" src="https://www.youtube.com/embed/AFD9ik--u1s" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    <div class="h-24 content-shadow-video bg-white py-2 px-4">
                                        <h4 class="mb-2 text-lg font-semibold line-clamp-1">Festival dan Acara Desa</h4>
                                        <h5 class="text-xs font-light">5 APRIL 2025</h5>
                                        <div class="flex justify-between"><h5 class="text-xs font-light"></h5><h5 class="text-xs font-light">Acara Desa</h5></div>
                                    </div>
                                </div>
                                <div class="shadow rounded-lg overflow-hidden w-72 lg:w-80">
                                    <iframe class="w-full aspect-video object-center object-cover" src="https://www.youtube.com/embed/RiEXSts8pbw" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    <div class="h-24 content-shadow-video bg-white py-2 px-4">
                                        <h4 class="mb-2 text-lg font-semibold line-clamp-1">Profil Desa Pulau Sebesi</h4>
                                        <h5 class="text-xs font-light">12 MEI 2025</h5>
                                        <div class="flex justify-between"><h5 class="text-xs font-light"></h5><h5 class="text-xs font-light">Profil Desa</h5></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include_once __DIR__ . '/../templates/footer.php'; ?>