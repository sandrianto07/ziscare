<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('layout/header', [
    'title' => 'Dashboard | ZIS Care',
    'page_title' => 'Dashboard',
    'user' => $user
]);

$this->load->view('layout/sidebar', [
    'user' => $user
]);

$statistik = $statistik ?? [];

$total_penerimaan = (float) ($statistik['total_penerimaan'] ?? 0);
$total_penyaluran = (float) ($statistik['total_penyaluran'] ?? 0);
$total_mustahik = (int) ($statistik['total_mustahik'] ?? 0);
$mustahik_aktif = (int) ($statistik['mustahik_aktif'] ?? 0);
$mustahik_tidak_aktif = (int) ($statistik['mustahik_tidak_aktif'] ?? 0);
$jumlah_penerimaan = (int) ($statistik['jumlah_penerimaan'] ?? 0);
$jumlah_penyaluran = (int) ($statistik['jumlah_penyaluran'] ?? 0);
$penerimaan_dibatalkan = (int) ($statistik['penerimaan_dibatalkan'] ?? 0);
$penyaluran_dibatalkan = (int) ($statistik['penyaluran_dibatalkan'] ?? 0);

$saldo_zis = $total_penerimaan - $total_penyaluran;
$total_transaksi = $jumlah_penerimaan + $jumlah_penyaluran;

$format_rupiah = static function ($value) {
    return 'Rp ' . number_format((float) $value, 0, ',', '.');
};

$format_tanggal = static function ($tanggal) {
    if (empty($tanggal)) {
        return '-';
    }

    $timestamp = strtotime($tanggal);

    if (!$timestamp) {
        return html_escape($tanggal);
    }

    $bulan = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'Mei',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Agu',
        9 => 'Sep',
        10 => 'Okt',
        11 => 'Nov',
        12 => 'Des'
    ];

    return date('d', $timestamp) . ' ' .
        $bulan[(int) date('n', $timestamp)] . ' ' .
        date('Y', $timestamp);
};

$bulan_lengkap = [
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

$chart_data = [];

foreach (($penerimaan_bulanan ?? []) as $row) {
    $periode = $row->periode ?? '';

    if (!$periode) {
        continue;
    }

    $chart_data[$periode]['penerimaan'] = (float) ($row->total ?? 0);
}

foreach (($penyaluran_bulanan ?? []) as $row) {
    $periode = $row->periode ?? '';

    if (!$periode) {
        continue;
    }

    $chart_data[$periode]['penyaluran'] = (float) ($row->total ?? 0);
}

ksort($chart_data);

$chart_labels = [];
$chart_penerimaan = [];
$chart_penyaluran = [];

foreach ($chart_data as $periode => $values) {
    $parts = explode('-', $periode);
    $bulan = $parts[1] ?? '';

    $chart_labels[] = $bulan_lengkap[$bulan] ?? $periode;
    $chart_penerimaan[] = (float) ($values['penerimaan'] ?? 0);
    $chart_penyaluran[] = (float) ($values['penyaluran'] ?? 0);
}

$stat_cards = [
    [
        'title' => 'Zakat',
        'value' => $format_rupiah($total_zakat),
        'description' => $jumlah_zakat . ' transaksi tercatat',
        'icon' => 'hand-coins',
        'icon_class' => 'bg-emerald-50 text-emerald-600'
    ],
    [
        'title' => 'Infaq',
        'value' => $format_rupiah($total_infaq),
        'description' => $jumlah_infaq . ' transaksi tercatat',
        'icon' => 'wallet',
        'icon_class' => 'bg-blue-50 text-blue-600'
    ],
    [
        'title' => 'Sedekah',
        'value' => $format_rupiah($total_sedekah),
        'description' => $jumlah_sedekah . ' transaksi tercatat',
        'icon' => 'heart-handshake',
        'icon_class' => 'bg-amber-50 text-amber-600'
    ],
    [
        'title' => 'Saldo ZIS',
        'value' => $format_rupiah($saldo_zis),
        'description' => 'Penerimaan dikurangi penyaluran',
        'icon' => 'wallet-cards',
        'icon_class' => 'bg-violet-50 text-violet-600'
    ]
];

?>

<div class="mx-auto w-full max-w-[1400px] space-y-4 sm:space-y-6">

    <section class="overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-600 to-emerald-700 shadow-sm">
        <div class="relative px-5 py-5 sm:px-7 sm:py-7">
            <div class="absolute -right-14 -top-14 h-40 w-40 rounded-full bg-white/5"></div>
            <div class="absolute -bottom-20 right-10 h-40 w-40 rounded-full bg-white/5"></div>

            <div class="relative flex items-center justify-between gap-4">
                <div class="min-w-0">
                    <div class="mb-2 flex items-center gap-2 text-xs font-medium text-emerald-100 sm:text-sm">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            <i data-lucide="sun" class="h-3.5 w-3.5"></i>
                        </span>
                        Selamat datang kembali
                    </div>

                    <h2 class="truncate text-xl font-bold tracking-tight text-white sm:text-2xl">
                        <?= html_escape($user['nama_lengkap'] ?? 'Admin'); ?>
                    </h2>

                    <p class="mt-2 max-w-2xl text-xs leading-5 text-emerald-100 sm:text-sm sm:leading-6">
                        Kelola penerimaan, penyaluran, data mustahik, dan laporan ZIS dalam satu sistem.
                    </p>
                </div>

                <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-white/10 text-white sm:flex lg:h-16 lg:w-16">
                    <i data-lucide="hand-heart" class="h-7 w-7 lg:h-8 lg:w-8"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <form method="get" action="<?= base_url('dashboard'); ?>" class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                    Filter Data Transaksi
                </h3>
                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    Perubahan periode akan langsung memperbarui data.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:flex lg:items-end">
                <div class="min-w-0 lg:w-44">
                    <label for="bulan" class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Bulan
                    </label>
                    <select
                        id="bulan"
                        name="bulan"
                        onchange="this.form.submit()"
                        class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    >
                        <option value="all" <?= $bulan_filter === 'all' ? 'selected' : ''; ?>>
                            Semua Bulan
                        </option>
                        <option value="01" <?= $bulan_filter === '01' ? 'selected' : ''; ?>>Januari</option>
                        <option value="02" <?= $bulan_filter === '02' ? 'selected' : ''; ?>>Februari</option>
                        <option value="03" <?= $bulan_filter === '03' ? 'selected' : ''; ?>>Maret</option>
                        <option value="04" <?= $bulan_filter === '04' ? 'selected' : ''; ?>>April</option>
                        <option value="05" <?= $bulan_filter === '05' ? 'selected' : ''; ?>>Mei</option>
                        <option value="06" <?= $bulan_filter === '06' ? 'selected' : ''; ?>>Juni</option>
                        <option value="07" <?= $bulan_filter === '07' ? 'selected' : ''; ?>>Juli</option>
                        <option value="08" <?= $bulan_filter === '08' ? 'selected' : ''; ?>>Agustus</option>
                        <option value="09" <?= $bulan_filter === '09' ? 'selected' : ''; ?>>September</option>
                        <option value="10" <?= $bulan_filter === '10' ? 'selected' : ''; ?>>Oktober</option>
                        <option value="11" <?= $bulan_filter === '11' ? 'selected' : ''; ?>>November</option>
                        <option value="12" <?= $bulan_filter === '12' ? 'selected' : ''; ?>>Desember</option>
                    </select>
                </div>

                <div class="min-w-0 lg:w-32">
                    <label for="tahun" class="mb-1.5 block text-xs font-semibold text-slate-600">
                        Tahun
                    </label>
                    <select
                        id="tahun"
                        name="tahun"
                        onchange="this.form.submit()"
                        class="h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    >
                        <?php foreach ($tahun_list as $tahun): ?>
                            <option value="<?= $tahun; ?>" <?= (string) $tahun_filter === (string) $tahun ? 'selected' : ''; ?>>
                                <?= $tahun; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <a
                    href="<?= base_url('dashboard/reset_filter'); ?>"
                    class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-orange-200 bg-white px-4 text-sm font-semibold text-orange-600 transition hover:bg-orange-100 active:bg-slate-100"
                >
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    Reset
                </a>
            </div>
        </form>
    </section>

    <section class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 xl:grid-cols-4">
        <?php foreach ($stat_cards as $card): ?>
            <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl <?= $card['icon_class']; ?> sm:h-11 sm:w-11">
                        <i data-lucide="<?= $card['icon']; ?>" class="h-5 w-5"></i>
                    </div>

                    <span class="rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-medium text-slate-400 sm:text-[11px]">
                        Data
                    </span>
                </div>

                <div class="mt-4 sm:mt-5">
                    <p class="text-xs font-medium text-slate-500 sm:text-sm">
                        <?= $card['title']; ?>
                    </p>

                    <p class="mt-1 truncate text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                        <?= $card['value']; ?>
                    </p>

                    <p class="mt-1 truncate text-xs text-slate-400">
                        <?= $card['description']; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="grid grid-cols-1 gap-4 sm:gap-6 xl:grid-cols-3">

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-4 sm:px-6">
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                        Ringkasan Transaksi
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Perbandingan penerimaan dan penyaluran ZIS.
                    </p>
                </div>

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400">
                    <i data-lucide="chart-column" class="h-4 w-4"></i>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <?php if (!empty($chart_data)): ?>
                    <div class="space-y-4">
                        <?php
                        $max_chart_value = 0;

                        foreach ($chart_data as $values) {
                            $max_chart_value = max(
                                $max_chart_value,
                                (float) ($values['penerimaan'] ?? 0),
                                (float) ($values['penyaluran'] ?? 0)
                            );
                        }
                        ?>

                        <?php foreach ($chart_data as $periode => $values): ?>
                            <?php
                            $parts = explode('-', $periode);
                            $bulan = $parts[1] ?? '';
                            $tahun = $parts[0] ?? '';
                            $penerimaan_value = (float) ($values['penerimaan'] ?? 0);
                            $penyaluran_value = (float) ($values['penyaluran'] ?? 0);
                            $penerimaan_width = $max_chart_value > 0
                                ? ($penerimaan_value / $max_chart_value) * 100
                                : 0;
                            $penyaluran_width = $max_chart_value > 0
                                ? ($penyaluran_value / $max_chart_value) * 100
                                : 0;
                            ?>

                            <div>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <span class="text-xs font-semibold text-slate-600 sm:text-sm">
                                        <?= $bulan_lengkap[$bulan] ?? $periode; ?> <?= $tahun; ?>
                                    </span>

                                    <span class="text-[10px] text-slate-400 sm:text-xs">
                                        <?= $format_rupiah($penerimaan_value + $penyaluran_value); ?>
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-20 shrink-0 text-[10px] font-medium text-slate-400 sm:w-24 sm:text-xs">
                                            Penerimaan
                                        </span>

                                        <div class="h-2.5 min-w-0 flex-1 overflow-hidden rounded-full bg-slate-100">
                                            <div
                                                class="h-full rounded-full bg-emerald-500 transition-all"
                                                style="width: <?= min(100, $penerimaan_width); ?>%"
                                            ></div>
                                        </div>

                                        <span class="w-24 shrink-0 text-right text-[10px] font-semibold text-slate-600 sm:w-28 sm:text-xs">
                                            <?= $format_rupiah($penerimaan_value); ?>
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="w-20 shrink-0 text-[10px] font-medium text-slate-400 sm:w-24 sm:text-xs">
                                            Penyaluran
                                        </span>

                                        <div class="h-2.5 min-w-0 flex-1 overflow-hidden rounded-full bg-slate-100">
                                            <div
                                                class="h-full rounded-full bg-blue-500 transition-all"
                                                style="width: <?= min(100, $penyaluran_width); ?>%"
                                            ></div>
                                        </div>

                                        <span class="w-24 shrink-0 text-right text-[10px] font-semibold text-slate-600 sm:w-28 sm:text-xs">
                                            <?= $format_rupiah($penyaluran_value); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="flex min-h-48 flex-col items-center justify-center text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <i data-lucide="chart-no-axes-column" class="h-5 w-5"></i>
                        </div>

                        <p class="mt-3 text-sm font-semibold text-slate-700">
                            Belum ada data transaksi
                        </p>

                        <p class="mt-1 max-w-sm text-xs leading-5 text-slate-400">
                            Data penerimaan dan penyaluran akan tampil setelah transaksi tercatat.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-4 sm:px-6">
                <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                    Ringkasan Mustahik
                </h3>

                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    Kondisi data penerima manfaat.
                </p>
            </div>

            <div class="p-4 sm:p-6">
                <div class="rounded-2xl bg-slate-50 p-4 sm:p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-medium text-slate-500">
                                Total Mustahik
                            </p>

                            <p class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                                <?= number_format($total_mustahik, 0, ',', '.'); ?>
                            </p>
                        </div>

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                            <i data-lucide="users" class="h-5 w-5"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-4">
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-500">
                                Aktif
                            </span>

                            <span class="text-sm font-bold text-emerald-600">
                                <?= number_format($mustahik_aktif, 0, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full bg-emerald-500"
                                style="width: <?= $total_mustahik > 0 ? min(100, ($mustahik_aktif / $total_mustahik) * 100) : 0; ?>%"
                            ></div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <span class="text-sm text-slate-500">
                                Tidak Aktif
                            </span>

                            <span class="text-sm font-bold text-slate-500">
                                <?= number_format($mustahik_tidak_aktif, 0, ',', '.'); ?>
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full bg-slate-400"
                                style="width: <?= $total_mustahik > 0 ? min(100, ($mustahik_tidak_aktif / $total_mustahik) * 100) : 0; ?>%"
                            ></div>
                        </div>
                    </div>
                </div>

                <a
                    href="<?= base_url('mustahik'); ?>"
                    class="mt-5 inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 active:bg-slate-100"
                >
                    Lihat Data Mustahik
                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                </a>
            </div>
        </div>

    </section>

    <section class="grid grid-cols-1 gap-4 sm:gap-6 xl:grid-cols-3">

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-4 sm:px-6">
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                        Penerimaan Terbaru
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Transaksi penerimaan terakhir.
                    </p>
                </div>

                <a
                    href="<?= base_url('penerimaan'); ?>"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    title="Lihat semua"
                >
                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                <?php if (!empty($penerimaan_terbaru)): ?>
                    <?php foreach ($penerimaan_terbaru as $row): ?>
                        <div class="flex min-w-0 items-center gap-3 px-4 py-3.5 sm:px-6">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <i data-lucide="arrow-down-left" class="h-4 w-4"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-xs font-semibold text-slate-700 sm:text-sm">
                                        <?= html_escape($row->sumber_dana ?? 'Penerimaan ZIS'); ?>
                                    </p>

                                    <p class="shrink-0 text-xs font-bold text-emerald-600">
                                        <?= $format_rupiah($row->nominal ?? 0); ?>
                                    </p>
                                </div>

                                <div class="mt-1 flex items-center gap-2">
                                    <span class="text-[10px] text-slate-400 sm:text-xs">
                                        <?= $format_tanggal($row->tanggal ?? ''); ?>
                                    </span>

                                    <?php if (!empty($row->jenis_zis)): ?>
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium capitalize text-slate-500">
                                            <?= html_escape($row->jenis_zis); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-4 py-10 text-center sm:px-6">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                            <i data-lucide="wallet" class="h-4 w-4"></i>
                        </div>

                        <p class="mt-3 text-xs font-semibold text-slate-600">
                            Belum ada penerimaan
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-4 sm:px-6">
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                        Penyaluran Terbaru
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Transaksi penyaluran terakhir.
                    </p>
                </div>

                <a
                    href="<?= base_url('penyaluran'); ?>"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    title="Lihat semua"
                >
                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                <?php if (!empty($penyaluran_terbaru)): ?>
                    <?php foreach ($penyaluran_terbaru as $row): ?>
                        <div class="flex min-w-0 items-center gap-3 px-4 py-3.5 sm:px-6">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-xs font-semibold text-slate-700 sm:text-sm">
                                        <?= html_escape(
                                            $row->nama_penerima
                                            ?? $row->penerima
                                            ?? $row->keterangan
                                            ?? 'Penyaluran ZIS'
                                        ); ?>
                                    </p>

                                    <p class="shrink-0 text-xs font-bold text-blue-600">
                                        <?= $format_rupiah($row->nominal ?? 0); ?>
                                    </p>
                                </div>

                                <div class="mt-1 flex items-center gap-2">
                                    <span class="text-[10px] text-slate-400 sm:text-xs">
                                        <?= $format_tanggal($row->tanggal ?? ''); ?>
                                    </span>

                                    <?php if (!empty($row->kategori_mustahik)): ?>
                                        <span class="truncate rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-500">
                                            <?= html_escape($row->kategori_mustahik); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-4 py-10 text-center sm:px-6">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                            <i data-lucide="hand-coins" class="h-4 w-4"></i>
                        </div>

                        <p class="mt-3 text-xs font-semibold text-slate-600">
                            Belum ada penyaluran
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-4 sm:px-6">
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                        Mustahik Terbaru
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Data penerima manfaat terbaru.
                    </p>
                </div>

                <a
                    href="<?= base_url('mustahik'); ?>"
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    title="Lihat semua"
                >
                    <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                <?php if (!empty($mustahik_terbaru)): ?>
                    <?php foreach ($mustahik_terbaru as $row): ?>
                        <div class="flex min-w-0 items-center gap-3 px-4 py-3.5 sm:px-6">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                                <i data-lucide="user-round" class="h-4 w-4"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-xs font-semibold text-slate-700 sm:text-sm">
                                        <?= html_escape($row->nama_lengkap ?? 'Mustahik'); ?>
                                    </p>

                                    <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-semibold <?= ($row->status ?? '') === 'aktif'
                                        ? 'bg-emerald-50 text-emerald-600'
                                        : 'bg-slate-100 text-slate-500'; ?>">
                                        <?= ($row->status ?? '') === 'aktif' ? 'Aktif' : 'Tidak Aktif'; ?>
                                    </span>
                                </div>

                                <div class="mt-1 flex min-w-0 items-center gap-2">
                                    <span class="truncate text-[10px] text-slate-400 sm:text-xs">
                                        <?= html_escape($row->kategori_mustahik ?? 'Kategori belum diatur'); ?>
                                    </span>

                                    <span class="shrink-0 text-[10px] text-slate-300">
                                        •
                                    </span>

                                    <span class="shrink-0 text-[10px] text-slate-400 sm:text-xs">
                                        <?= $format_tanggal($row->tanggal_terdaftar ?? ''); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="px-4 py-10 text-center sm:px-6">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                            <i data-lucide="users" class="h-4 w-4"></i>
                        </div>

                        <p class="mt-3 text-xs font-semibold text-slate-600">
                            Belum ada data mustahik
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </section>

    <section class="grid grid-cols-1 gap-4 sm:gap-6 xl:grid-cols-3">

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-4 sm:px-6">
                <div class="min-w-0">
                    <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                        Aksi Cepat
                    </h3>

                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Akses fitur yang sering digunakan.
                    </p>
                </div>

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-400">
                    <i data-lucide="zap" class="h-4 w-4"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 p-4 sm:grid-cols-2 sm:p-6">

                <a
                    href="<?= base_url('penerimaan/tambah'); ?>"
                    class="group flex min-w-0 items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm active:bg-slate-100 sm:gap-4 sm:p-4"
                >
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-100 sm:h-11 sm:w-11">
                        <i data-lucide="plus-circle" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            Tambah Penerimaan
                        </p>

                        <p class="mt-1 truncate text-xs text-slate-400">
                            Catat penerimaan ZIS baru
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-slate-500"></i>
                </a>

                <a
                    href="<?= base_url('penyaluran'); ?>"
                    class="group flex min-w-0 items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm active:bg-slate-100 sm:gap-4 sm:p-4"
                >
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-100 sm:h-11 sm:w-11">
                        <i data-lucide="hand-coins" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            Penyaluran ZIS
                        </p>

                        <p class="mt-1 truncate text-xs text-slate-400">
                            Kelola penyaluran dana ZIS
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-slate-500"></i>
                </a>

                <a
                    href="<?= base_url('mustahik'); ?>"
                    class="group flex min-w-0 items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm active:bg-slate-100 sm:gap-4 sm:p-4"
                >
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-orange-600 transition group-hover:bg-orange-100 sm:h-11 sm:w-11">
                        <i data-lucide="user-plus" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            Data Mustahik
                        </p>

                        <p class="mt-1 truncate text-xs text-slate-400">
                            Kelola data penerima bantuan
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-slate-500"></i>
                </a>

                <a
                    href="<?= base_url('laporan'); ?>"
                    class="group flex min-w-0 items-center gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm active:bg-slate-100 sm:gap-4 sm:p-4"
                >
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 transition group-hover:bg-violet-100 sm:h-11 sm:w-11">
                        <i data-lucide="file-text" class="h-5 w-5"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            Laporan
                        </p>

                        <p class="mt-1 truncate text-xs text-slate-400">
                            Lihat dan kelola laporan
                        </p>
                    </div>

                    <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-slate-500"></i>
                </a>

            </div>
        </div>

        <div class="min-w-0 rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-4 py-4 sm:px-6">
                <h3 class="text-sm font-bold text-slate-900 sm:text-base">
                    Informasi Akun
                </h3>

                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    Detail akun administrator.
                </p>
            </div>

            <div class="p-4 sm:p-6">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-emerald-100 text-lg font-bold text-emerald-700 ring-1 ring-emerald-200 sm:h-12 sm:w-12">
                        <?php if (!empty($user['foto'])): ?>
                            <img
                                src="<?= base_url('uploads/users/' . $user['foto']); ?>"
                                alt="Foto Profil"
                                class="h-full w-full object-cover"
                            >
                        <?php else: ?>
                            <?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)); ?>
                        <?php endif; ?>
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            <?= html_escape($user['nama_lengkap'] ?? 'Admin'); ?>
                        </p>

                        <p class="truncate text-xs text-slate-400">
                            <?= html_escape($user['email'] ?? '-'); ?>
                        </p>
                    </div>
                </div>

                <div class="my-5 border-t border-slate-100"></div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="shrink-0 text-sm text-slate-500">
                            Username
                        </span>

                        <span class="min-w-0 truncate text-right text-sm font-semibold text-slate-800">
                            <?= html_escape($user['username'] ?? '-'); ?>
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <span class="shrink-0 text-sm text-slate-500">
                            Role
                        </span>

                        <span class="shrink-0 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                            Administrator
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <span class="shrink-0 text-sm text-slate-500">
                            Status
                        </span>

                        <span class="flex shrink-0 items-center gap-1.5 text-xs font-semibold text-emerald-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </section>

</div>

<?php $this->load->view('layout/footer'); ?>