<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$format_rupiah = static function ($nominal) {
    return 'Rp ' . number_format((float) $nominal, 0, ',', '.');
};

$format_tanggal = static function ($tanggal) {
    if (!$tanggal) {
        return '-';
    }

    return date('d M Y', strtotime($tanggal));
};

$nama_bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

$label_periode = 'Semua Periode';

if (!empty($periode_aktif) && preg_match('/^\d{4}-\d{2}$/', $periode_aktif)) {
    $tahun = substr($periode_aktif, 0, 4);
    $bulan = substr($periode_aktif, 5, 2);
    $label_periode = ($nama_bulan[$bulan] ?? $bulan) . ' ' . $tahun;
}

$total_penerimaan = (float) ($ringkasan['total_penerimaan'] ?? 0);
$total_penyaluran = (float) ($ringkasan['total_penyaluran'] ?? 0);
$saldo = (float) ($ringkasan['saldo'] ?? 0);

$jumlah_penerimaan = (int) ($ringkasan['jumlah_penerimaan'] ?? 0);
$jumlah_penyaluran = (int) ($ringkasan['jumlah_penyaluran'] ?? 0);

$zakat = $rekap_penerimaan['zakat'] ?? [
    'jumlah' => 0,
    'total' => 0,
    'persentase' => 0
];

$infaq = $rekap_penerimaan['infaq'] ?? [
    'jumlah' => 0,
    'total' => 0,
    'persentase' => 0
];

$sedekah = $rekap_penerimaan['sedekah'] ?? [
    'jumlah' => 0,
    'total' => 0,
    'persentase' => 0
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= html_escape($description ?? 'Transparansi pengelolaan Zakat, Infaq, dan Sedekah MWCNU Kecamatan Ngasem Bojonegoro.') ?>">
    <meta name="theme-color" content="#047857">
    <title><?= html_escape($title ?? 'Transparansi ZIS | MWCNU Kecamatan Ngasem') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<header id="navbar" class="fixed inset-x-0 top-0 z-50 border-b border-transparent transition-all duration-300">
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
                <a href="<?= base_url() ?>" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">
                    Beranda
                </a>

                <a href="<?= base_url('transparansi') ?>" class="text-sm font-semibold text-emerald-700">
                    Transparansi
                </a>

                <a href="<?= base_url('#program') ?>" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">
                    Program
                </a>

                <a href="<?= base_url('#tentang') ?>" class="text-sm font-medium text-slate-600 transition hover:text-emerald-700">
                    Tentang
                </a>
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
                <a href="<?= base_url() ?>" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                    Beranda
                </a>

                <a href="<?= base_url('transparansi') ?>" class="rounded-lg bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                    Transparansi
                </a>

                <a href="<?= base_url('#program') ?>" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                    Program
                </a>

                <a href="<?= base_url('#tentang') ?>" class="rounded-lg px-4 py-3 text-sm font-medium text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">
                    Tentang
                </a>

                <div class="mt-3 border-t border-slate-100 pt-3">
                    <a href="<?= base_url('login') ?>" class="flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white">
                        <i data-lucide="log-in" class="h-4 w-4"></i>
                        Login Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<main>

    <section class="relative overflow-hidden border-b border-slate-200 bg-white pt-32 pb-12 lg:pt-36 lg:pb-16">
        <div class="pointer-events-none absolute -right-40 -top-40 h-96 w-96 rounded-full bg-emerald-100/70 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-40 bottom-0 h-80 w-80 rounded-full bg-amber-100/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-5 lg:px-8">
            <div class="max-w-3xl">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                    <i data-lucide="bar-chart-3" class="h-4 w-4"></i>
                    Laporan Transparansi ZIS
                </div>

                <h1 class="text-4xl font-black tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                    Transparansi
                    <span class="text-emerald-700">Pengelolaan ZIS</span>
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                    Pantau penerimaan dan penyaluran dana Zakat, Infaq, dan Sedekah secara terbuka melalui data yang tercatat dalam sistem ZIS Care.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="shield-check" class="h-4 w-4 text-emerald-600"></i>
                        Data tercatat
                    </span>

                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>

                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="eye" class="h-4 w-4 text-emerald-600"></i>
                        Terbuka untuk publik
                    </span>

                    <span class="h-1 w-1 rounded-full bg-slate-300"></span>

                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="refresh-cw" class="h-4 w-4 text-emerald-600"></i>
                        Diperbarui berkala
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-5 py-5 lg:px-8">
            <form method="get" action="<?= base_url('transparansi') ?>" class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Periode Laporan</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        Menampilkan data: <?= html_escape($label_periode) ?>
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <div class="relative">
                        <i data-lucide="calendar-days" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                        <select
                            name="periode"
                            onchange="this.form.submit()"
                            class="w-full appearance-none rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-10 text-sm font-medium text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:min-w-56"
                        >
                            <option value="">Semua Periode</option>

                            <?php foreach ($periode_list as $periode): ?>
                                <?php
                                $tahun = substr($periode, 0, 4);
                                $bulan = substr($periode, 5, 2);
                                $label = ($nama_bulan[$bulan] ?? $bulan) . ' ' . $tahun;
                                ?>
                                <option value="<?= html_escape($periode) ?>" <?= $periode_aktif === $periode ? 'selected' : '' ?>>
                                    <?= html_escape($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (!empty($periode_aktif)): ?>
                        <a href="<?= base_url('transparansi') ?>" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                            <i data-lucide="x" class="h-4 w-4"></i>
                            Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <section class="py-10 lg:py-14">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">

            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-700">Ringkasan Keuangan</p>
                    <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">
                        Gambaran dana ZIS
                    </h2>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                    <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                    <?= html_escape($label_periode) ?>
                </span>
            </div>

            <div class="grid gap-5 md:grid-cols-3">

                <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Dana Masuk</p>
                            <p class="mt-3 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">
                                <?= $format_rupiah($total_penerimaan) ?>
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <i data-lucide="arrow-down-left" class="h-5 w-5"></i>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4 text-xs text-slate-500">
                        <i data-lucide="receipt" class="h-3.5 w-3.5"></i>
                        <?= number_format($jumlah_penerimaan, 0, ',', '.') ?> transaksi penerimaan
                    </div>
                </div>

                <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Dana Disalurkan</p>
                            <p class="mt-3 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">
                                <?= $format_rupiah($total_penyaluran) ?>
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <i data-lucide="arrow-up-right" class="h-5 w-5"></i>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4 text-xs text-slate-500">
                        <i data-lucide="send" class="h-3.5 w-3.5"></i>
                        <?= number_format($jumlah_penyaluran, 0, ',', '.') ?> transaksi penyaluran
                    </div>
                </div>

                <div class="group overflow-hidden rounded-2xl border border-emerald-200 bg-emerald-700 p-6 text-white shadow-xl shadow-emerald-900/10 transition hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-100">Saldo Periode</p>
                            <p class="mt-3 text-2xl font-black tracking-tight sm:text-3xl">
                                <?= $format_rupiah($saldo) ?>
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-white">
                            <i data-lucide="wallet" class="h-5 w-5"></i>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-2 border-t border-white/10 pt-4 text-xs text-emerald-100">
                        <i data-lucide="calculator" class="h-3.5 w-3.5"></i>
                        Dana masuk dikurangi dana disalurkan
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="pb-10 lg:pb-14">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-emerald-700">Komposisi Penerimaan</p>
                            <h2 class="mt-1 text-xl font-black text-slate-950">Sumber dana ZIS</h2>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <i data-lucide="pie-chart" class="h-5 w-5"></i>
                        </div>
                    </div>

                    <div class="mt-7 space-y-6">

                        <?php
                        $komposisi = [
                            [
                                'nama' => 'Zakat',
                                'data' => $zakat,
                                'icon' => 'badge-dollar-sign',
                                'bg' => 'bg-emerald-50',
                                'text' => 'text-emerald-700',
                                'bar' => 'bg-emerald-600'
                            ],
                            [
                                'nama' => 'Infaq',
                                'data' => $infaq,
                                'icon' => 'hand-coins',
                                'bg' => 'bg-blue-50',
                                'text' => 'text-blue-700',
                                'bar' => 'bg-blue-600'
                            ],
                            [
                                'nama' => 'Sedekah',
                                'data' => $sedekah,
                                'icon' => 'heart',
                                'bg' => 'bg-amber-50',
                                'text' => 'text-amber-700',
                                'bar' => 'bg-amber-500'
                            ]
                        ];
                        ?>

                        <?php foreach ($komposisi as $item): ?>
                            <div>
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl <?= $item['bg'] ?> <?= $item['text'] ?>">
                                            <i data-lucide="<?= $item['icon'] ?>" class="h-4.5 w-4.5"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-900"><?= $item['nama'] ?></p>
                                            <p class="text-xs text-slate-500">
                                                <?= number_format((int) $item['data']['jumlah'], 0, ',', '.') ?> transaksi
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm font-bold text-slate-900">
                                            <?= $format_rupiah($item['data']['total']) ?>
                                        </p>
                                        <p class="text-xs font-semibold text-slate-400">
                                            <?= number_format((float) $item['data']['persentase'], 1, ',', '.') ?>%
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                                    <div
                                        class="h-full rounded-full <?= $item['bar'] ?> transition-all duration-700"
                                        style="width: <?= min(100, max(0, (float) $item['data']['persentase'])) ?>%"
                                    ></div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-emerald-700">Distribusi Dana</p>
                            <h2 class="mt-1 text-xl font-black text-slate-950">Penyaluran berdasarkan kategori</h2>
                        </div>

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                            <i data-lucide="chart-no-axes-combined" class="h-5 w-5"></i>
                        </div>
                    </div>

                    <?php if (!empty($rekap_penyaluran)): ?>
                        <div class="mt-7 space-y-5">
                            <?php foreach ($rekap_penyaluran as $item): ?>
                                <?php
                                $kategori = trim((string) ($item->kategori_penerima ?? ''));
                                $kategori = $kategori !== '' ? $kategori : 'Belum dikategorikan';
                                $persentase = (float) ($item->persentase ?? 0);
                                ?>

                                <div>
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-slate-900">
                                                <?= html_escape($kategori) ?>
                                            </p>
                                            <p class="mt-0.5 text-xs text-slate-500">
                                                <?= number_format((int) $item->jumlah, 0, ',', '.') ?> transaksi
                                            </p>
                                        </div>

                                        <div class="shrink-0 text-right">
                                            <p class="text-sm font-bold text-slate-900">
                                                <?= $format_rupiah($item->total) ?>
                                            </p>
                                            <p class="text-xs font-semibold text-slate-400">
                                                <?= number_format($persentase, 1, ',', '.') ?>%
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                                        <div
                                            class="h-full rounded-full bg-emerald-600 transition-all duration-700"
                                            style="width: <?= min(100, max(0, $persentase)) ?>%"
                                        ></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="mt-7 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-5 py-10 text-center">
                            <i data-lucide="inbox" class="mx-auto h-8 w-8 text-slate-300"></i>
                            <p class="mt-3 text-sm font-semibold text-slate-600">Belum ada data penyaluran</p>
                            <p class="mt-1 text-xs text-slate-400">Data akan ditampilkan ketika tersedia.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>

    <section class="pb-10 lg:pb-14">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">

            <div class="mb-6">
                <p class="text-sm font-semibold text-emerald-700">Aktivitas Dana</p>
                <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">
                    Alur penerimaan & penyaluran
                </h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                    Riwayat aktivitas terbaru berdasarkan data yang tercatat pada periode yang dipilih.
                </p>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <?php if (!empty($timeline)): ?>

                    <div class="divide-y divide-slate-100">
                        <?php foreach ($timeline as $item): ?>
                            <?php
                            $is_penerimaan = $item->tipe === 'penerimaan';
                            $jenis = trim((string) ($item->jenis_zis ?? ''));
                            $jenis = $jenis !== '' ? ucfirst(strtolower($jenis)) : 'ZIS';
                            $kategori = trim((string) ($item->kategori ?? ''));
                            ?>

                            <div class="flex gap-4 p-5 transition hover:bg-slate-50 sm:p-6">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl <?= $is_penerimaan ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' ?>">
                                    <i data-lucide="<?= $is_penerimaan ? 'arrow-down-left' : 'arrow-up-right' ?>" class="h-5 w-5"></i>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="font-bold text-slate-900">
                                                    <?= $is_penerimaan ? 'Penerimaan ZIS' : 'Penyaluran ZIS' ?>
                                                </span>

                                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                                    <?= html_escape($jenis) ?>
                                                </span>
                                            </div>

                                            <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500">
                                                <span class="inline-flex items-center gap-1.5">
                                                    <i data-lucide="calendar-days" class="h-3.5 w-3.5"></i>
                                                    <?= $format_tanggal($item->tanggal) ?>
                                                </span>

                                                <?php if (!empty($item->metode)): ?>
                                                    <span class="inline-flex items-center gap-1.5">
                                                        <i data-lucide="credit-card" class="h-3.5 w-3.5"></i>
                                                        <?= html_escape($item->metode) ?>
                                                    </span>
                                                <?php endif; ?>

                                                <?php if (!$is_penerimaan && $kategori !== ''): ?>
                                                    <span class="inline-flex items-center gap-1.5">
                                                        <i data-lucide="users" class="h-3.5 w-3.5"></i>
                                                        <?= html_escape($kategori) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="shrink-0">
                                            <p class="text-base font-black <?= $is_penerimaan ? 'text-emerald-700' : 'text-amber-700' ?>">
                                                <?= $is_penerimaan ? '+' : '-' ?> <?= $format_rupiah($item->nominal) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>

                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <i data-lucide="activity" class="h-6 w-6"></i>
                        </div>

                        <h3 class="mt-4 font-bold text-slate-900">Belum ada aktivitas</h3>
                        <p class="mx-auto mt-1 max-w-sm text-sm leading-6 text-slate-500">
                            Belum terdapat aktivitas penerimaan atau penyaluran pada periode yang dipilih.
                        </p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </section>

    <section class="pb-10 lg:pb-14">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">

            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-emerald-700">Data Transaksi</p>
                    <h2 class="mt-1 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">
                        Riwayat transaksi publik
                    </h2>
                </div>

                <div class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-500">
                    <i data-lucide="database" class="h-3.5 w-3.5"></i>
                    <?= number_format(count($transaksi), 0, ',', '.') ?> data ditampilkan
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full text-left">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Tanggal</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Aktivitas</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Jenis</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Kategori</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Nominal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($transaksi)): ?>

                                <?php foreach ($transaksi as $item): ?>
                                    <?php
                                    $is_penerimaan = strtolower((string) $item->aktivitas) === 'penerimaan';
                                    $jenis = trim((string) ($item->jenis_zis ?? ''));
                                    $jenis = $jenis !== '' ? ucfirst(strtolower($jenis)) : '-';
                                    $kategori = trim((string) ($item->kategori ?? ''));
                                    ?>

                                    <tr class="transition hover:bg-slate-50">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                            <?= $format_tanggal($item->tanggal) ?>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-2 rounded-full <?= $is_penerimaan ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' ?> px-3 py-1.5 text-xs font-bold">
                                                <span class="h-1.5 w-1.5 rounded-full <?= $is_penerimaan ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                                                <?= html_escape($item->aktivitas) ?>
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                            <?= html_escape($jenis) ?>
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-500">
                                            <?= $kategori !== '' ? html_escape($kategori) : '-' ?>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-black <?= $is_penerimaan ? 'text-emerald-700' : 'text-amber-700' ?>">
                                            <?= $is_penerimaan ? '+' : '-' ?> <?= $format_rupiah($item->nominal) ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <i data-lucide="file-search" class="mx-auto h-8 w-8 text-slate-300"></i>
                                        <p class="mt-3 text-sm font-semibold text-slate-600">Tidak ada transaksi</p>
                                        <p class="mt-1 text-xs text-slate-400">Belum ada transaksi pada periode yang dipilih.</p>
                                    </td>
                                </tr>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="divide-y divide-slate-100 md:hidden">

                    <?php if (!empty($transaksi)): ?>

                        <?php foreach ($transaksi as $item): ?>
                            <?php
                            $is_penerimaan = strtolower((string) $item->aktivitas) === 'penerimaan';
                            $jenis = trim((string) ($item->jenis_zis ?? ''));
                            $jenis = $jenis !== '' ? ucfirst(strtolower($jenis)) : '-';
                            $kategori = trim((string) ($item->kategori ?? ''));
                            ?>

                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl <?= $is_penerimaan ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' ?>">
                                            <i data-lucide="<?= $is_penerimaan ? 'arrow-down-left' : 'arrow-up-right' ?>" class="h-4 w-4"></i>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-slate-900">
                                                <?= html_escape($item->aktivitas) ?>
                                            </p>
                                            <p class="mt-0.5 text-xs text-slate-500">
                                                <?= $format_tanggal($item->tanggal) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <p class="shrink-0 text-sm font-black <?= $is_penerimaan ? 'text-emerald-700' : 'text-amber-700' ?>">
                                        <?= $is_penerimaan ? '+' : '-' ?> <?= $format_rupiah($item->nominal) ?>
                                    </p>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-2 pl-[52px]">
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                        <?= html_escape($jenis) ?>
                                    </span>

                                    <?php if ($kategori !== ''): ?>
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                            <?= html_escape($kategori) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <div class="px-6 py-16 text-center">
                            <i data-lucide="file-search" class="mx-auto h-8 w-8 text-slate-300"></i>
                            <p class="mt-3 text-sm font-semibold text-slate-600">Tidak ada transaksi</p>
                            <p class="mt-1 text-xs text-slate-400">Belum ada transaksi pada periode yang dipilih.</p>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </section>

    <section class="pb-16 lg:pb-20">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">

            <div class="overflow-hidden rounded-3xl border border-emerald-100 bg-emerald-50">
                <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1fr_auto] lg:items-center lg:p-10">
                    <div class="flex gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">
                            <i data-lucide="lock-keyhole" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h2 class="font-bold text-slate-900">Perlindungan data pribadi</h2>
                            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-600">
                                Laporan publik hanya menampilkan informasi transaksi yang diperlukan untuk transparansi. Data pribadi seperti NIK, nomor telepon, alamat, identitas donatur, dan informasi sensitif penerima tidak ditampilkan kepada publik.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700">
                        <i data-lucide="shield-check" class="h-4 w-4"></i>
                        Privasi terlindungi
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<footer class="border-t border-slate-200 bg-white">
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
                    Sistem informasi pengelolaan Zakat, Infaq, dan Sedekah untuk mendukung transparansi dan administrasi dana umat.
                </p>
            </div>

            <div class="flex flex-wrap gap-x-6 gap-y-3 text-sm">
                <a href="<?= base_url() ?>" class="text-slate-500 transition hover:text-emerald-700">
                    Beranda
                </a>

                <a href="<?= base_url('transparansi') ?>" class="font-semibold text-emerald-700">
                    Transparansi
                </a>

                <a href="<?= base_url('#program') ?>" class="text-slate-500 transition hover:text-emerald-700">
                    Program
                </a>

                <a href="<?= base_url('#tentang') ?>" class="text-slate-500 transition hover:text-emerald-700">
                    Tentang
                </a>

                <a href="<?= base_url('login') ?>" class="font-semibold text-slate-700 transition hover:text-emerald-700">
                    Login Admin
                </a>
            </div>

        </div>

        <div class="flex flex-col gap-3 border-t border-slate-100 py-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>
                © <?= date('Y') ?> MWCNU Kecamatan Ngasem Bojonegoro. Semua hak dilindungi.
            </p>

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
    const navbar = document.getElementById('navbar');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('border-slate-200', 'bg-white/95', 'shadow-sm', 'backdrop-blur');
            navbar.classList.remove('border-transparent');
        } else {
            navbar.classList.remove('border-slate-200', 'bg-white/95', 'shadow-sm', 'backdrop-blur');
            navbar.classList.add('border-transparent');
        }
    });

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    document.querySelectorAll('#mobileMenu a').forEach((link) => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });

    lucide.createIcons();
</script>

</body>
</html>