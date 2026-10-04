<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$filters = $filters ?? [];
$data_mustahik = $data_mustahik ?? [];

$total_mustahik = $total_mustahik ?? 0;
$mustahik_aktif = $mustahik_aktif ?? 0;
$mustahik_nonaktif = $mustahik_nonaktif ?? 0;

$kategori = $filters['kategori'] ?? '';
$status = $filters['status'] ?? '';
$desa = $filters['desa'] ?? '';
$kecamatan = $filters['kecamatan'] ?? '';
$tanggal_mulai = $filters['tanggal_mulai'] ?? '';
$tanggal_selesai = $filters['tanggal_selesai'] ?? '';

$kategori_list = [];

foreach ($data_mustahik as $row) {
    if (!empty($row->kategori_mustahik) && !in_array($row->kategori_mustahik, $kategori_list, true)) {
        $kategori_list[] = $row->kategori_mustahik;
    }
}

sort($kategori_list);
?>

<div class="mx-auto w-full max-w-[1400px] space-y-4 sm:space-y-6">

    <section class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div class="min-w-0">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400 sm:text-sm">
                <a href="<?= base_url('dashboard'); ?>" class="transition hover:text-emerald-600">
                    Dashboard
                </a>

                <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

                <a href="<?= base_url('laporan'); ?>" class="transition hover:text-emerald-600">
                    Laporan
                </a>

                <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

                <span class="text-slate-600">
                    Mustahik
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Laporan Data Mustahik
            </h1>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Rincian data mustahik berdasarkan kategori, status, dan periode pendaftaran.
            </p>
        </div>

        <a
            href="<?= base_url('laporan/cetak_mustahik?' . http_build_query($filters)); ?>"
            target="_blank"
            class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 active:bg-emerald-800 sm:w-auto sm:px-5"
        >
            <i data-lucide="printer" class="h-4 w-4"></i>
            Cetak Laporan
        </a>
    </section>

    <section class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 xl:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-medium text-emerald-600 sm:inline-flex">
                    Mustahik
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Mustahik
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($total_mustahik, 0, ',', '.'); ?>
                <span class="text-xs font-medium text-slate-400">Orang</span>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11">
                    <i data-lucide="user-check" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-medium text-blue-600 sm:inline-flex">
                    Aktif
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Mustahik Aktif
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($mustahik_aktif, 0, ',', '.'); ?>
                <span class="text-xs font-medium text-slate-400">Orang</span>
            </p>
        </div>

        <div class="col-span-2 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:col-span-2 xl:col-span-1 sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 sm:h-11 sm:w-11">
                    <i data-lucide="user-x" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-violet-50 px-2.5 py-1 text-[10px] font-medium text-violet-600 sm:inline-flex">
                    Tidak Aktif
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Mustahik Tidak Aktif
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($mustahik_nonaktif, 0, ',', '.'); ?>
                <span class="text-xs font-medium text-slate-400">Orang</span>
            </p>
        </div>

    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                    Daftar Mustahik
                </h2>

                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    <?= number_format(count($data_mustahik), 0, ',', '.'); ?> data ditemukan.
                </p>
            </div>

            <form method="get" class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap">

                <select
                    name="kategori"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-36 sm:text-sm"
                >
                    <option value="">Semua Kategori</option>

                    <?php foreach ($kategori_list as $item): ?>
                        <option value="<?= html_escape($item); ?>" <?= $kategori === $item ? 'selected' : ''; ?>>
                            <?= html_escape(ucwords(strtolower($item))); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-32 sm:text-sm"
                >
                    <option value="">Semua Status</option>
                    <option value="aktif" <?= $status === 'aktif' ? 'selected' : ''; ?>>
                        Aktif
                    </option>
                    <option value="tidak_aktif" <?= $status === 'tidak_aktif' ? 'selected' : ''; ?>>
                        Tidak Aktif
                    </option>
                </select>

                <input
                    type="date"
                    name="tanggal_mulai"
                    value="<?= html_escape($tanggal_mulai); ?>"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-36 sm:text-sm"
                >

                <input
                    type="date"
                    name="tanggal_selesai"
                    value="<?= html_escape($tanggal_selesai); ?>"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-36 sm:text-sm"
                >

                <a
                    href="<?= base_url('laporan/mustahik'); ?>"
                    class="col-span-2 inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 sm:col-span-1 sm:w-10 sm:px-0"
                    title="Reset Filter"
                >
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    <span class="sm:hidden">Reset Filter</span>
                </a>

            </form>
        </div>

        <?php if (empty($data_mustahik)): ?>

            <div class="px-5 py-14 text-center sm:px-6 sm:py-16">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="users-round" class="h-6 w-6"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                    Belum Ada Data Mustahik
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-500 sm:text-sm">
                    Tidak terdapat data mustahik yang sesuai dengan filter yang dipilih.
                </p>
            </div>

        <?php else: ?>

            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full min-w-[1200px] text-left">
                    <thead class="border-b border-slate-100 bg-slate-50">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                #
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Mustahik
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                NIK
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Kategori
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Wilayah
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                No. HP
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Terdaftar
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-center text-xs font-bold uppercase tracking-wide text-slate-500">
                                Status
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <?php $no = 1; ?>

                        <?php foreach ($data_mustahik as $row): ?>
                            <?php
                            $nama = $row->nama_lengkap ?? '-';
                            $kode = $row->kode_mustahik ?? '-';
                            $nik = $row->nik ?? '-';
                            $kategori_row = $row->kategori_mustahik ?? '-';
                            $desa_row = $row->desa ?? '';
                            $kecamatan_row = $row->kecamatan ?? '';
                            $no_hp = $row->no_hp ?? '-';
                            $tanggal = $row->tanggal_terdaftar ?? null;
                            $status_row = $row->status ?? '';
                            ?>

                            <tr class="group transition hover:bg-slate-50/70">

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                    <?= $no++; ?>
                                </td>

                                <td class="min-w-[240px] px-5 py-4">
                                    <div class="flex items-center gap-3">

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-slate-800">
                                                <?= html_escape($nama); ?>
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-400">
                                                <?= html_escape($kode); ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 font-mono text-xs text-slate-600">
                                    <?= html_escape($nik); ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <?= html_escape(ucwords(strtolower($kategori_row))); ?>
                                    </span>
                                </td>

                                <td class="min-w-[180px] px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-700">
                                        <?= html_escape($desa_row ?: '-'); ?>
                                    </p>

                                    <?php if ($kecamatan_row): ?>
                                        <p class="mt-0.5 text-xs text-slate-400">
                                            Kec. <?= html_escape($kecamatan_row); ?>
                                        </p>
                                    <?php endif; ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    <?= html_escape($no_hp); ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    <?= $tanggal ? date('d/m/Y', strtotime($tanggal)) : '-'; ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                    <?php if ($status_row === 'aktif'): ?>
                                        <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                            Tidak Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="divide-y divide-slate-100 lg:hidden">

                <?php foreach ($data_mustahik as $row): ?>
                    <?php
                    $nama = $row->nama_lengkap ?? '-';
                    $kode = $row->kode_mustahik ?? '-';
                    $nik = $row->nik ?? '-';
                    $kategori_row = $row->kategori_mustahik ?? '-';
                    $desa_row = $row->desa ?? '';
                    $kecamatan_row = $row->kecamatan ?? '';
                    $no_hp = $row->no_hp ?? '-';
                    $tanggal = $row->tanggal_terdaftar ?? null;
                    $status_row = $row->status ?? '';
                    ?>

                    <article class="p-4 sm:p-5">

                        <div class="flex items-start justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-sm font-bold text-emerald-700">
                                    <?= strtoupper(substr($nama, 0, 1)); ?>
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-slate-900">
                                        <?= html_escape($nama); ?>
                                    </p>

                                    <p class="mt-1 truncate text-xs text-slate-400">
                                        <?= html_escape($kode); ?>
                                    </p>
                                </div>

                            </div>

                            <?php if ($status_row === 'aktif'): ?>
                                <span class="inline-flex shrink-0 rounded-lg bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700">
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex shrink-0 rounded-lg bg-slate-100 px-2.5 py-1 text-[10px] font-semibold text-slate-500">
                                    Tidak Aktif
                                </span>
                            <?php endif; ?>

                        </div>

                        <div class="mt-4 rounded-xl bg-slate-50 p-3.5">
                            <div class="grid grid-cols-2 gap-4">

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        NIK
                                    </p>

                                    <p class="mt-1 break-all font-mono text-xs text-slate-600">
                                        <?= html_escape($nik); ?>
                                    </p>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Kategori
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape(ucwords(strtolower($kategori_row))); ?>
                                    </p>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Desa
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape($desa_row ?: '-'); ?>
                                    </p>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Kecamatan
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape($kecamatan_row ?: '-'); ?>
                                    </p>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        No. HP
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape($no_hp); ?>
                                    </p>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Terdaftar
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= $tanggal ? date('d M Y', strtotime($tanggal)) : '-'; ?>
                                    </p>
                                </div>

                            </div>
                        </div>

                    </article>
                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>