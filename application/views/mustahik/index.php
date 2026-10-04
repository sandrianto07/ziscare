<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('layout/header', [
    'title' => 'Data Mustahik | ZIS Care',
    'page_title' => 'Data Mustahik',
    'user' => $user
]);

$this->load->view('layout/sidebar', [
    'user' => $user
]);

$total_mustahik = count($data);
$aktif_mustahik = 0;
$tidak_aktif = 0;
$total_kategori = [];

foreach ($data as $item) {
    if ($item->status === 'aktif') {
        $aktif_mustahik++;
    }

    if ($item->status === 'tidak_aktif') {
        $tidak_aktif++;
    }

    if (!isset($total_kategori[$item->kategori_mustahik])) {
        $total_kategori[$item->kategori_mustahik] = 0;
    }

    $total_kategori[$item->kategori_mustahik]++;
}

$kategori_label = [
    'fakir' => 'Fakir',
    'miskin' => 'Miskin',
    'amil' => 'Amil',
    'muallaf' => 'Muallaf',
    'riqab' => 'Riqab',
    'gharim' => 'Gharim',
    'fisabilillah' => 'Fisabilillah',
    'ibnu_sabil' => 'Ibnu Sabil'
];

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
                    Data Mustahik
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Data Mustahik
            </h1>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Kelola data penerima manfaat ZIS secara terstruktur.
            </p>
        </div>

        <a
            href="<?= base_url('mustahik/tambah'); ?>"
            class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 active:bg-emerald-800 sm:w-auto sm:px-5"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Mustahik
        </a>
    </section>

    </section>

    <?php if ($this->session->flashdata('success')): ?>

        <div class="flex items-start gap-3 rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-700">

            <i
                data-lucide="circle-check"
                class="mt-0.5 h-5 w-5 shrink-0"
            ></i>

            <p class="min-w-0 leading-5">
                <?= html_escape($this->session->flashdata('success')); ?>
            </p>

        </div>

    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>

        <div class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">

            <i
                data-lucide="circle-alert"
                class="mt-0.5 h-5 w-5 shrink-0"
            ></i>

            <p class="min-w-0 leading-5">
                <?= html_escape($this->session->flashdata('error')); ?>
            </p>

        </div>

    <?php endif; ?>

    <section class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 xl:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

            <div class="flex items-start justify-between gap-2">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-medium text-slate-400 sm:inline-flex">
                    Semua data
                </span>

            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Mustahik
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($total_mustahik, 0, ',', '.'); ?>
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
                <?= number_format($aktif_mustahik, 0, ',', '.'); ?>
            </p>

        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

            <div class="flex items-start justify-between gap-2">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 sm:h-11 sm:w-11">
                    <i data-lucide="user-x" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-medium text-slate-500 sm:inline-flex">
                    Nonaktif
                </span>

            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Tidak Aktif
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($tidak_aktif, 0, ',', '.'); ?>
            </p>

        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">

            <div class="flex items-start justify-between gap-2">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 sm:h-11 sm:w-11">
                    <i data-lucide="tags" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-medium text-amber-600 sm:inline-flex">
                    Kategori
                </span>

            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Kategori Mustahik
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format(count($total_kategori), 0, ',', '.'); ?>
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
                    Daftar seluruh penerima manfaat ZIS.
                </p>

            </div>

            <div class="flex flex-col gap-2 sm:flex-row">

                <div class="relative">

                    <i
                        data-lucide="search"
                        class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                    ></i>

                    <input
                        type="text"
                        id="searchMustahik"
                        placeholder="Cari mustahik..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-64"
                    >

                </div>

                <select
                    id="filterKategori"
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >
                    <option value="">
                        Semua Kategori
                    </option>

                    <option value="fakir">
                        Fakir
                    </option>

                    <option value="miskin">
                        Miskin
                    </option>

                    <option value="amil">
                        Amil
                    </option>

                    <option value="muallaf">
                        Muallaf
                    </option>

                    <option value="riqab">
                        Riqab
                    </option>

                    <option value="gharim">
                        Gharim
                    </option>

                    <option value="fisabilillah">
                        Fisabilillah
                    </option>

                    <option value="ibnu_sabil">
                        Ibnu Sabil
                    </option>

                </select>

                <select
                    id="filterStatus"
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >
                    <option value="">
                        Semua Status
                    </option>

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="tidak_aktif">
                        Tidak Aktif
                    </option>

                </select>

            </div>

        </div>

        <?php if (empty($data)): ?>

            <div class="px-5 py-14 text-center sm:px-6 sm:py-16">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="users" class="h-6 w-6"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                    Belum Ada Data Mustahik
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-500 sm:text-sm">
                    Belum terdapat data mustahik. Tambahkan data mustahik pertama untuk mulai mengelola penerima manfaat ZIS.
                </p>

                <a
                    href="<?= base_url('mustahik/tambah'); ?>"
                    class="mt-5 inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 active:bg-emerald-800"
                >
                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                    Tambah Mustahik
                </a>

            </div>

        <?php else: ?>

            <div class="hidden overflow-x-auto lg:block">

                <table
                    id="tableMustahik"
                    class="w-full min-w-[1100px] text-left"
                >

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
                                Lokasi
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Status
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <?php $no = 1; ?>

                        <?php foreach ($data as $row): ?>

                            <?php
                            $kategori = $kategori_label[$row->kategori_mustahik] ?? ucfirst($row->kategori_mustahik);
                            ?>

                            <tr
                                class="group transition hover:bg-slate-50/70"
                                data-kategori="<?= html_escape($row->kategori_mustahik); ?>"
                                data-status="<?= html_escape($row->status); ?>"
                            >

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                    <?= $no++; ?>
                                </td>

                                <td class="min-w-[230px] px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-bold text-slate-800">
                                                <?= html_escape($row->nama_lengkap); ?>
                                            </p>

                                            <p class="mt-0.5 text-xs text-slate-400">
                                                <?= html_escape($row->kode_mustahik); ?>
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-slate-600">
                                    <?= html_escape($row->nik); ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">

                                    <span class="inline-flex items-center rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        <?= html_escape($kategori); ?>
                                    </span>

                                </td>

                                <td class="min-w-[180px] px-5 py-4">

                                    <div class="flex items-start gap-2">

                                        <i
                                            data-lucide="map-pin"
                                            class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"
                                        ></i>

                                        <div>

                                            <p class="text-sm text-slate-600">
                                                <?= html_escape(ucwords(strtolower($row->desa ?: '-'))); ?>
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                <?= html_escape(ucwords(strtolower($row->kecamatan ?: '-'))); ?>
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                <td class="whitespace-nowrap px-5 py-4">

                                    <?php if ($row->status === 'aktif'): ?>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>

                                    <?php else: ?>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Tidak Aktif
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right">

                                    <div class="flex justify-end gap-1">

                                        <a
                                            href="<?= base_url('mustahik/edit/' . $row->id); ?>"
                                            title="Edit"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-amber-50 hover:text-amber-600"
                                        >
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </a>

                                        <button
                                            type="button"
                                            title="Hapus"
                                            onclick="hapusMustahik(
                                                <?= (int) $row->id; ?>,
                                                '<?= html_escape(addslashes($row->nama_lengkap)); ?>'
                                            )"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <div
                id="mobileMustahikList"
                class="divide-y divide-slate-100 lg:hidden"
            >

                <?php foreach ($data as $row): ?>

                    <?php
                    $kategori = $kategori_label[$row->kategori_mustahik] ?? ucfirst($row->kategori_mustahik);
                    ?>

                    <article
                        class="mustahik-card p-4 sm:p-5"
                        data-kategori="<?= html_escape($row->kategori_mustahik); ?>"
                        data-status="<?= html_escape($row->status); ?>"
                    >

                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-sm font-bold text-emerald-700">
                                    <?= strtoupper(substr($row->nama_lengkap, 0, 1)); ?>
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-bold text-slate-900">
                                        <?= html_escape($row->nama_lengkap); ?>
                                    </p>

                                    <p class="mt-1 truncate text-xs text-slate-400">
                                        <?= html_escape($row->kode_mustahik); ?>
                                    </p>

                                </div>

                            </div>

                            <?php if ($row->status === 'aktif'): ?>

                                <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>

                            <?php else: ?>

                                <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold text-slate-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Tidak Aktif
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="mt-4 flex items-center justify-between gap-3">

                            <span class="inline-flex rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                <?= html_escape($kategori); ?>
                            </span>

                            <span class="text-xs font-medium text-slate-500">
                                NIK <?= html_escape($row->nik); ?>
                            </span>

                        </div>

                        <div class="mt-4 rounded-xl bg-slate-50 p-3.5">

                            <div class="grid grid-cols-2 gap-4">

                                <div class="min-w-0">

                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Desa
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape($row->desa ?: '-'); ?>
                                    </p>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Kecamatan
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape($row->kecamatan ?: '-'); ?>
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="mt-3 grid grid-cols-3 gap-2">

                            <a
                                href="<?= base_url('mustahik/detail/' . $row->id); ?>"
                                class="flex min-h-10 items-center justify-center gap-1.5 rounded-xl bg-blue-50 px-2 py-2.5 text-xs font-semibold text-blue-600 transition hover:bg-blue-100 active:bg-blue-200"
                            >
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                Detail
                            </a>

                            <a
                                href="<?= base_url('mustahik/edit/' . $row->id); ?>"
                                class="flex min-h-10 items-center justify-center gap-1.5 rounded-xl bg-amber-50 px-2 py-2.5 text-xs font-semibold text-amber-600 transition hover:bg-amber-100 active:bg-amber-200"
                            >
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                Edit
                            </a>

                            <button
                                type="button"
                                onclick="hapusMustahik(
                                    <?= (int) $row->id; ?>,
                                    '<?= html_escape(addslashes($row->nama_lengkap)); ?>'
                                )"
                                class="flex min-h-10 items-center justify-center gap-1.5 rounded-xl bg-red-50 px-2 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-100 active:bg-red-200"
                            >
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                Hapus
                            </button>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

            <div
                id="emptyFilterState"
                class="hidden px-5 py-14 text-center sm:px-6 sm:py-16"
            >

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <i data-lucide="search-x" class="h-6 w-6"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                    Data Tidak Ditemukan
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-500 sm:text-sm">
                    Tidak ada data mustahik yang sesuai dengan pencarian atau filter yang dipilih.
                </p>

            </div>

        <?php endif; ?>

    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const searchInput = document.getElementById('searchMustahik');
    const filterKategori = document.getElementById('filterKategori');
    const filterStatus = document.getElementById('filterStatus');
    const table = document.getElementById('tableMustahik');
    const mobileList = document.getElementById('mobileMustahikList');
    const emptyFilterState = document.getElementById('emptyFilterState');

    function filterData() {
        const search = searchInput
            ? searchInput.value.toLowerCase().trim()
            : '';

        const kategori = filterKategori
            ? filterKategori.value
            : '';

        const status = filterStatus
            ? filterStatus.value
            : '';

        let visibleCount = 0;

        if (table) {
            table.querySelectorAll('tbody tr').forEach(function (row) {
                const text = row.textContent.toLowerCase();
                const rowKategori = row.dataset.kategori || '';
                const rowStatus = row.dataset.status || '';

                const matchSearch = !search || text.includes(search);
                const matchKategori = !kategori || rowKategori === kategori;
                const matchStatus = !status || rowStatus === status;
                const visible = matchSearch && matchKategori && matchStatus;

                row.style.display = visible ? '' : 'none';

                if (visible) {
                    visibleCount++;
                }
            });
        }

        if (mobileList) {
            mobileList.querySelectorAll('.mustahik-card').forEach(function (card) {
                const text = card.textContent.toLowerCase();
                const rowKategori = card.dataset.kategori || '';
                const rowStatus = card.dataset.status || '';

                const matchSearch = !search || text.includes(search);
                const matchKategori = !kategori || rowKategori === kategori;
                const matchStatus = !status || rowStatus === status;
                const visible = matchSearch && matchKategori && matchStatus;

                card.style.display = visible ? '' : 'none';
            });
        }

        if (emptyFilterState) {
            emptyFilterState.classList.toggle('hidden', visibleCount > 0);
        }
    }

    searchInput?.addEventListener('input', filterData);
    filterKategori?.addEventListener('change', filterData);
    filterStatus?.addEventListener('change', filterData);
});

function hapusMustahik(id, nama) {
    const url = "<?= base_url('mustahik/hapus/'); ?>" + id;

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Hapus Data Mustahik?',
            html: 'Data <strong>' + escapeHtml(nama) + '</strong> akan dihapus secara permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white ml-2',
                cancelButton: 'rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-bold text-slate-600'
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });

        return;
    }

    if (confirm('Hapus data mustahik "' + nama + '"?')) {
        window.location.href = url;
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>

<?php
$this->load->view('layout/footer');
?>