<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bulan_aktif = $bulan ?? '';
$tahun_aktif = $tahun ?? date('Y');

$nama_bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

$total_penerimaan = $total_penerimaan ?? 0;
$total_penyaluran = $total_penyaluran ?? 0;
$saldo_zis = $saldo_zis ?? 0;
$total_mustahik = $total_mustahik ?? 0;

$penerimaan_zakat = $penerimaan_zakat ?? 0;
$penerimaan_infaq = $penerimaan_infaq ?? 0;
$penerimaan_sedekah = $penerimaan_sedekah ?? 0;

$penyaluran_zakat = $penyaluran_zakat ?? 0;
$penyaluran_infaq = $penyaluran_infaq ?? 0;
$penyaluran_sedekah = $penyaluran_sedekah ?? 0;
?>

<div class="mx-auto w-full max-w-[1400px] space-y-4 sm:space-y-6">

    <section class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400 sm:text-sm">
                <a
                    href="<?= base_url('dashboard'); ?>"
                    class="transition hover:text-emerald-600"
                >
                    Dashboard
                </a>

                <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

                <span class="text-slate-600">
                    Laporan
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Laporan
            </h1>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Pantau dan lihat ringkasan pengelolaan dana ZIS secara terstruktur.
            </p>
        </div>

        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
            <select
                name="bulan"
                id="filterBulan"
                class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 text-sm text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-40"
            >
                <option value="">Semua Bulan</option>
                <?php foreach ($nama_bulan as $nomor => $nama): ?>
                    <option value="<?= $nomor; ?>" <?= (string) $bulan_aktif === (string) $nomor ? 'selected' : ''; ?>>
                        <?= $nama; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select
                name="tahun"
                id="filterTahun"
                class="min-h-11 w-full rounded-xl border border-slate-200 bg-white px-3.5 text-sm text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-28"
            >
                <?php for ($year = date('Y'); $year >= date('Y') - 5; $year--): ?>
                    <option value="<?= $year; ?>" <?= (string) $tahun_aktif === (string) $year ? 'selected' : ''; ?>>
                        <?= $year; ?>
                    </option>
                <?php endfor; ?>
            </select>

            <a
                href="<?= base_url('laporan?reset=1'); ?>"
                class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900"
            >
                <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                Reset
            </a>
        </div>
    </section>

    <section class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 xl:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                    <i data-lucide="arrow-down-to-line" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-medium text-emerald-600 sm:inline-flex">
                    Penerimaan
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Penerimaan
            </p>

            <p class="mt-1 truncate text-lg font-bold tracking-tight text-slate-900 sm:text-2xl">
                Rp <?= number_format($total_penerimaan, 0, ',', '.'); ?>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11">
                    <i data-lucide="arrow-up-from-line" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-medium text-blue-600 sm:inline-flex">
                    Penyaluran
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Penyaluran
            </p>

            <p class="mt-1 truncate text-lg font-bold tracking-tight text-slate-900 sm:text-2xl">
                Rp <?= number_format($total_penyaluran, 0, ',', '.'); ?>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 sm:h-11 sm:w-11">
                    <i data-lucide="wallet" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-medium text-amber-600 sm:inline-flex">
                    Saldo
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Saldo ZIS
            </p>

            <p class="mt-1 truncate text-lg font-bold tracking-tight text-slate-900 sm:text-2xl">
                Rp <?= number_format($saldo_zis, 0, ',', '.'); ?>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 sm:h-11 sm:w-11">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-violet-50 px-2.5 py-1 text-[10px] font-medium text-violet-600 sm:inline-flex">
                    Mustahik
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Mustahik
            </p>

            <p class="mt-1 text-lg font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($total_mustahik, 0, ',', '.'); ?>
                <span class="text-xs font-medium text-slate-400">Orang</span>
            </p>
        </div>

    </section>

    <section class="grid gap-4 lg:grid-cols-2">

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
                <div class="min-w-0">
                    <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                        Penerimaan ZIS
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Rekap berdasarkan jenis dana.
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="wallet" class="h-5 w-5"></i>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-medium text-slate-600">Zakat</span>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-slate-900">
                        Rp <?= number_format($penerimaan_zakat, 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                        <span class="text-sm font-medium text-slate-600">Infaq</span>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-slate-900">
                        Rp <?= number_format($penerimaan_infaq, 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-violet-500"></span>
                        <span class="text-sm font-medium text-slate-600">Sedekah</span>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-slate-900">
                        Rp <?= number_format($penerimaan_sedekah, 0, ',', '.'); ?>
                    </span>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50/70 px-4 py-3.5 sm:px-6">
                <a
                    href="<?= base_url('laporan/penerimaan'); ?>"
                    class="group inline-flex items-center gap-2 text-xs font-semibold text-emerald-600 transition hover:text-emerald-700 sm:text-sm"
                >
                    Lihat laporan penerimaan
                    <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5"></i>
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
                <div class="min-w-0">
                    <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                        Penyaluran ZIS
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                        Rekap berdasarkan jenis dana.
                    </p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="hand-coins" class="h-5 w-5"></i>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-medium text-slate-600">Zakat</span>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-slate-900">
                        Rp <?= number_format($penyaluran_zakat, 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                        <span class="text-sm font-medium text-slate-600">Infaq</span>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-slate-900">
                        Rp <?= number_format($penyaluran_infaq, 0, ',', '.'); ?>
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4 px-4 py-3.5 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="h-2 w-2 shrink-0 rounded-full bg-violet-500"></span>
                        <span class="text-sm font-medium text-slate-600">Sedekah</span>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-slate-900">
                        Rp <?= number_format($penyaluran_sedekah, 0, ',', '.'); ?>
                    </span>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-slate-50/70 px-4 py-3.5 sm:px-6">
                <a
                    href="<?= base_url('laporan/penyaluran'); ?>"
                    class="group inline-flex items-center gap-2 text-xs font-semibold text-blue-600 transition hover:text-blue-700 sm:text-sm"
                >
                    Lihat laporan penyaluran
                    <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5"></i>
                </a>
            </div>
        </div>

    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                    Pilihan Laporan
                </h2>
                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    Pilih laporan yang ingin kamu lihat secara lebih detail.
                </p>
            </div>
        </div>

        <div class="grid gap-3 p-4 sm:grid-cols-3 sm:p-5">

            <a
                href="<?= base_url('laporan/penerimaan'); ?>"
                class="group flex min-h-[88px] items-center gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50/40"
            >
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="arrow-down-to-line" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-800">
                        Penerimaan ZIS
                    </p>
                    <p class="mt-0.5 text-xs leading-5 text-slate-400">
                        Rincian transaksi penerimaan
                    </p>
                </div>

                <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-emerald-500"></i>
            </a>

            <a
                href="<?= base_url('laporan/penyaluran'); ?>"
                class="group flex min-h-[88px] items-center gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-blue-200 hover:bg-blue-50/40"
            >
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="arrow-up-from-line" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-800">
                        Penyaluran ZIS
                    </p>
                    <p class="mt-0.5 text-xs leading-5 text-slate-400">
                        Rincian transaksi penyaluran
                    </p>
                </div>

                <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-blue-500"></i>
            </a>

            <a
                href="<?= base_url('laporan/mustahik'); ?>"
                class="group flex min-h-[88px] items-center gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-violet-200 hover:bg-violet-50/40"
            >
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-800">
                        Data Mustahik
                    </p>
                    <p class="mt-0.5 text-xs leading-5 text-slate-400">
                        Rincian penerima manfaat
                    </p>
                </div>

                <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-violet-500"></i>
            </a>

        </div>
    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bulan = document.getElementById('filterBulan');
    const tahun = document.getElementById('filterTahun');

    function applyFilter() {
        const params = new URLSearchParams();

        if (bulan?.value) params.set('bulan', bulan.value);
        if (tahun?.value) params.set('tahun', tahun.value);

        window.location.href = '<?= base_url('laporan'); ?>' + (params.toString() ? '?' + params.toString() : '');
    }

    bulan?.addEventListener('change', applyFilter);
    tahun?.addEventListener('change', applyFilter);

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>