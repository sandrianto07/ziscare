<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Pengelolaan Zakat, Infak, dan Sedekah MWCNU Kecamatan Ngasem Bojonegoro.">
    <meta name="theme-color" content="#064e3b">
    <title>ZIS Care | MWCNU Kecamatan Ngasem</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<header id="navbar" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <nav class="flex h-20 items-center justify-between">
            <a href="<?= base_url() ?>" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-700 text-white shadow-lg shadow-emerald-900/10">
                    <i data-lucide="hand-heart" class="h-5 w-5"></i>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-slate-900">ZIS Care</div>
                    <div class="text-xs text-slate-500">MWCNU Kecamatan Ngasem</div>
                </div>
            </a>

            <div class="hidden items-center gap-8 md:flex">
                <a href="#beranda" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Beranda</a>
                <a href="#transparansi" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Transparansi</a>
                <a href="#program" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Program</a>
                <a href="#tentang" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">Tentang</a>
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-2 rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-700/20 transition hover:-translate-y-0.5 hover:bg-emerald-800">
                    <i data-lucide="log-in" class="h-4 w-4"></i>
                    Login Admin
                </a>
            </div>

            <button id="mobileMenuButton" type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 md:hidden" aria-label="Buka menu">
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </nav>

        <div id="mobileMenu" class="hidden border-t border-slate-100 bg-white pb-5 md:hidden">
            <div class="flex flex-col gap-1 pt-4">
                <a href="#beranda" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">Beranda</a>
                <a href="#transparansi" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">Transparansi</a>
                <a href="#program" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">Program</a>
                <a href="#tentang" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">Tentang</a>
                <div class="mt-3 border-t border-slate-100 pt-3">
                    <a href="<?= base_url('login') ?>" class="flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800">
                        <i data-lucide="log-in" class="h-4 w-4"></i>
                        Login Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<main>
    <section id="beranda" class="relative overflow-hidden pt-32 pb-20 lg:pt-40 lg:pb-28">
        <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-32 bottom-0 h-80 w-80 rounded-full bg-amber-100/50 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-5 lg:grid-cols-2 lg:px-8">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></span>
                    Sistem Transparansi ZIS
                </div>

                <h1 class="max-w-2xl text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                    Mengelola Amanah,
                    <span class="text-emerald-700">Menebar Manfaat.</span>
                </h1>

                <p class="mt-6 max-w-xl text-base leading-8 text-slate-600 sm:text-lg">
                    Sistem informasi pengelolaan Zakat, Infak, dan Sedekah MWCNU Kecamatan Ngasem yang hadir untuk mendukung pengelolaan dana umat secara tertib, terbuka, dan dapat dipertanggungjawabkan.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#transparansi" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-6 py-3.5 font-semibold text-white shadow-xl shadow-emerald-700/20 transition hover:-translate-y-1 hover:bg-emerald-800">
                        Lihat Transparansi
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <a href="#tentang" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3.5 font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                        Tentang ZIS
                    </a>
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="h-4 w-4 text-emerald-600"></i>
                        Data tercatat
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="eye" class="h-4 w-4 text-emerald-600"></i>
                        Transparan
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="heart-handshake" class="h-4 w-4 text-emerald-600"></i>
                        Amanah
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="relative overflow-hidden rounded-3xl border border-white bg-white p-6 shadow-2xl shadow-slate-900/10">
                    <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-emerald-100 blur-3xl"></div>

                    <div class="relative">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Ringkasan ZIS</p>
                                <h2 class="mt-1 text-xl font-bold text-slate-900">Transparansi Dana</h2>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                <i data-lucide="wallet" class="h-5 w-5"></i>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-emerald-700 p-6 text-white">
                            <p class="text-sm text-emerald-100">Total Dana Terkelola</p>
                            <div class="mt-2 text-3xl font-black tracking-tight">
                                Rp <?= number_format($total_dana, 0, ',', '.'); ?>
                            </div>
                            <div class="mt-5 flex items-center gap-2 text-sm text-emerald-100">
                                <i data-lucide="calendar-days" class="h-4 w-4"></i>
                                Periode berjalan
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                                        <i data-lucide="arrow-down-left" class="h-4 w-4"></i>
                                    </div>
                                    <span class="text-xs text-slate-500">Penerimaan</span>
                                </div>
                                <p class="mt-3 text-lg font-bold text-slate-900">
                                    Rp <?= number_format($total_penerimaan, 0, ',', '.'); ?>
                                </p>
                            </div>

                            <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                                    </div>
                                    <span class="text-xs text-slate-500">Penyaluran</span>
                                </div>
                                <p class="mt-3 text-lg font-bold text-slate-900">
                                    Rp <?= number_format($total_penyaluran, 0, ',', '.'); ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 flex items-center gap-3 rounded-xl bg-slate-50 p-4">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white shadow-sm">
                                <i data-lucide="info" class="h-4 w-4 text-emerald-700"></i>
                            </div>
                            <p class="text-xs leading-5 text-slate-500">
                                Data akan diperbarui secara berkala oleh pengelola ZIS.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-100 bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-2 divide-x divide-slate-100 px-5 lg:grid-cols-4 lg:px-8">
            <div class="px-5 py-8 text-center lg:py-10">
            <p class="text-2xl font-black text-slate-900">
                Rp <?= number_format($total_zakat, 0, ',', '.'); ?>
            </p>
                <p class="mt-1 text-sm text-slate-500">Total Zakat</p>
            </div>
            <div class="px-5 py-8 text-center lg:py-10">
            <p class="text-2xl font-black text-slate-900">
                Rp <?= number_format($total_infaq, 0, ',', '.'); ?>
            </p>
                <p class="mt-1 text-sm text-slate-500">Total Infak</p>
            </div>
            <div class="px-5 py-8 text-center lg:py-10">
            <p class="text-2xl font-black text-slate-900">
                Rp <?= number_format($total_sedekah, 0, ',', '.'); ?>
            </p>
                <p class="mt-1 text-sm text-slate-500">Total Sedekah</p>
            </div>
            <div class="px-5 py-8 text-center lg:py-10">
            <p class="text-2xl font-black text-slate-900">
                <?= number_format($total_program, 0, ',', '.'); ?>
            </p>
                <p class="mt-1 text-sm text-slate-500">Program Penyaluran</p>
            </div>
        </div>
    </section>

    <section id="transparansi" class="scroll-mt-20 py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="text-sm font-bold uppercase tracking-widest text-emerald-700">Transparansi</span>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Pengelolaan Dana ZIS</h2>
                <p class="mt-4 leading-7 text-slate-600">
                    Masyarakat dapat melihat ringkasan penerimaan dan penyaluran dana ZIS sebagai bentuk keterbukaan pengelolaan amanah umat.
                </p>
            </div>

            <div class="mt-12 grid gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <i data-lucide="trending-up" class="h-6 w-6"></i>
                    </div>
                    <p class="mt-5 text-sm text-slate-500">Total Penerimaan</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">
                        Rp <?= number_format($total_penerimaan, 0, ',', '.'); ?>
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Zakat, infak, dan sedekah</p>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <i data-lucide="hand-heart" class="h-6 w-6"></i>
                    </div>
                    <p class="mt-5 text-sm text-slate-500">Total Penyaluran</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">
                        Rp <?= number_format($total_penyaluran, 0, ',', '.'); ?>
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Dana yang telah disalurkan</p>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <i data-lucide="wallet-cards" class="h-6 w-6"></i>
                    </div>
                    <p class="mt-5 text-sm text-slate-500">Saldo Dana</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">
                        Rp <?= number_format($total_dana, 0, ',', '.'); ?>
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Penerimaan dikurangi penyaluran</p>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <a href="<?= base_url('transparansi') ?>" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-3 font-semibold text-emerald-700 transition hover:bg-emerald-100">
                    Lihat Detail Transparansi
                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <span class="text-sm font-bold uppercase tracking-widest text-emerald-700">Pengelolaan</span>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                        Dari amanah menjadi manfaat nyata.
                    </h2>
                    <p class="mt-5 max-w-xl leading-8 text-slate-600">
                        Setiap dana yang diterima dicatat dan dikelola dengan tertib. Informasi penyaluran dapat dipantau sebagai bagian dari komitmen terhadap keterbukaan kepada masyarakat.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-700 font-bold text-white">1</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Dana Diterima</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-500">Penerimaan Zakat, Infak, dan Sedekah dicatat oleh pengelola.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-700 font-bold text-white">2</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Dana Dikelola</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-500">Dana dikelola sesuai kebutuhan dan program yang telah ditentukan.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-700 font-bold text-white">3</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Dana Disalurkan</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-500">Dana disalurkan kepada penerima manfaat dan program sosial.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-700 font-bold text-white">4</div>
                        <div>
                            <h3 class="font-bold text-slate-900">Informasi Dipublikasikan</h3>
                            <p class="mt-1 text-sm leading-6 text-slate-500">Ringkasan pengelolaan dana dapat dilihat oleh masyarakat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="scroll-mt-20 py-20 lg:py-28">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div>
                    <span class="text-sm font-bold uppercase tracking-widest text-emerald-700">Program</span>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Penyaluran ZIS</h2>
                </div>
                <a href="<?= base_url('transparansi') ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                    Lihat semua
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <i data-lucide="graduation-cap" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Pendidikan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Dukungan bagi masyarakat dalam bidang pendidikan.</p>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <i data-lucide="heart-pulse" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Kesehatan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Bantuan untuk kebutuhan kesehatan masyarakat.</p>
                </div>

                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <i data-lucide="users" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Sosial & Kemanusiaan</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Mendukung masyarakat yang membutuhkan bantuan sosial.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="scroll-mt-20 bg-emerald-950 py-20 text-white lg:py-28">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white/10">
                        <i data-lucide="landmark" class="h-6 w-6"></i>
                    </div>
                    <h2 class="mt-6 text-3xl font-black tracking-tight sm:text-4xl">Tentang Pengelolaan ZIS</h2>
                    <p class="mt-5 leading-8 text-emerald-100/80">
                        Sistem ini dikembangkan sebagai media pencatatan dan transparansi pengelolaan Zakat, Infak, dan Sedekah di lingkungan MWCNU Kecamatan Ngasem Bojonegoro.
                    </p>
                    <p class="mt-4 leading-8 text-emerald-100/80">
                        Kehadiran sistem ini diharapkan dapat membantu pengelola dalam melakukan pencatatan administrasi sekaligus memberikan informasi yang mudah diakses oleh masyarakat.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <i data-lucide="file-check-2" class="h-6 w-6 text-emerald-300"></i>
                        <h3 class="mt-5 font-bold">Tercatat</h3>
                        <p class="mt-2 text-sm leading-6 text-emerald-100/60">Setiap transaksi dicatat secara terstruktur.</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <i data-lucide="eye" class="h-6 w-6 text-emerald-300"></i>
                        <h3 class="mt-5 font-bold">Terbuka</h3>
                        <p class="mt-2 text-sm leading-6 text-emerald-100/60">Informasi pengelolaan dapat diketahui masyarakat.</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <i data-lucide="shield-check" class="h-6 w-6 text-emerald-300"></i>
                        <h3 class="mt-5 font-bold">Amanah</h3>
                        <p class="mt-2 text-sm leading-6 text-emerald-100/60">Mendukung pengelolaan dana secara bertanggung jawab.</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <i data-lucide="heart-handshake" class="h-6 w-6 text-emerald-300"></i>
                        <h3 class="mt-5 font-bold">Bermanfaat</h3>
                        <p class="mt-2 text-sm leading-6 text-emerald-100/60">Dana disalurkan untuk membantu masyarakat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 lg:py-24">
        <div class="mx-auto max-w-5xl px-5 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-emerald-700 px-6 py-12 text-center text-white shadow-2xl shadow-emerald-900/20 sm:px-12">
                <div class="absolute -right-20 -top-20 h-60 w-60 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 h-60 w-60 rounded-full bg-emerald-400/20 blur-3xl"></div>

                <div class="relative">
                    <span class="text-sm font-medium text-emerald-100">Keterbukaan untuk masyarakat</span>
                    <h2 class="mt-3 text-3xl font-black sm:text-4xl">Ingin mengetahui pengelolaan dana ZIS?</h2>
                    <p class="mx-auto mt-4 max-w-xl leading-7 text-emerald-100">
                        Lihat informasi penerimaan dan penyaluran dana ZIS secara terbuka.
                    </p>
                    <a href="<?= base_url('transparansi') ?>" class="mt-7 inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3.5 font-bold text-emerald-700 shadow-lg transition hover:-translate-y-1 hover:bg-emerald-50">
                        Buka Transparansi
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="border-t border-slate-100 bg-white">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="flex flex-col gap-8 py-10 md:flex-row md:items-center md:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-700 text-white">
                        <i data-lucide="hand-heart" class="h-5 w-5"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">ZIS Care</p>
                        <p class="text-xs text-slate-500">MWCNU Kecamatan Ngasem</p>
                    </div>
                </div>
                <p class="mt-4 max-w-md text-sm leading-6 text-slate-500">
                    Sistem informasi pengelolaan Zakat, Infak, dan Sedekah untuk mendukung transparansi dan administrasi dana umat.
                </p>
            </div>

            <div class="flex flex-wrap gap-x-6 gap-y-3 text-sm">
                <a href="#beranda" class="text-slate-500 transition hover:text-emerald-700">Beranda</a>
                <a href="#transparansi" class="text-slate-500 transition hover:text-emerald-700">Transparansi</a>
                <a href="#program" class="text-slate-500 transition hover:text-emerald-700">Program</a>
                <a href="#tentang" class="text-slate-500 transition hover:text-emerald-700">Tentang</a>
                <a href="<?= base_url('login') ?>" class="font-semibold text-emerald-700 transition hover:text-emerald-800">Login Admin</a>
            </div>
        </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 py-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>© <?= date('Y') ?> MWCNU Kecamatan Ngasem Bojonegoro. Semua hak dilindungi.</p>
            <p>
                Dibuat oleh
                <a
                    href="https://sandronn.vercel.app"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="font-semibold text-emerald-700 transition hover:text-emerald-800"
                >
                    Sans Developer
                </a>
            </p>
        </div>
    </div>
</footer>

<script>
    lucide.createIcons();

    const navbar = document.getElementById('navbar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    function updateNavbar() {
        navbar.classList.toggle('bg-white/95', window.scrollY > 20);
        navbar.classList.toggle('shadow-sm', window.scrollY > 20);
        navbar.classList.toggle('backdrop-blur-md', window.scrollY > 20);
    }

    window.addEventListener('scroll', updateNavbar);
    updateNavbar();

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;

            const target = document.querySelector(targetId);
            if (!target) return;

            e.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });
</script>

</body>
</html>