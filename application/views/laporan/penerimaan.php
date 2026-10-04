<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$filters = $filters ?? [];
$data_penerimaan = $data_penerimaan ?? [];
$total_penerimaan = $total_penerimaan ?? 0;

$bulan = $filters['bulan'] ?? '';
$tahun = $filters['tahun'] ?? date('Y');
$jenis_zis = $filters['jenis_zis'] ?? '';
$tanggal_mulai = $filters['tanggal_mulai'] ?? '';
$tanggal_selesai = $filters['tanggal_selesai'] ?? '';

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

$jenis_label = [
    'Zakat' => 'Zakat',
    'Infaq' => 'Infaq',
    'Sedekah' => 'Sedekah'
];
?>

<div class="mx-auto w-full max-w-[1400px] space-y-4 sm:space-y-6">

    <section class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
    <div class="min-w-0">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-400 sm:text-sm">
                <a
                    href="<?= base_url('dashboard'); ?>"
                    class="transition hover:text-emerald-600"
                >
                    Dashboard
                </a>

                <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

                <a
                    href="<?= base_url('laporan'); ?>"
                    class="transition hover:text-emerald-600"
                >
                    Laporan
                </a>

                <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

                <span class="text-slate-600">
                    Penerimaan ZIS
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Laporan Penerimaan ZIS
            </h1>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Rincian seluruh transaksi penerimaan dana ZIS berdasarkan periode dan jenis dana.
            </p>
        </div>

        <a
            href="<?= base_url('laporan/cetak_penerimaan?' . http_build_query($filters)); ?>"
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
                    <i data-lucide="wallet" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-medium text-emerald-600 sm:inline-flex">
                    Penerimaan
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Penerimaan
            </p>

            <p class="mt-1 truncate text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                Rp <?= number_format($total_penerimaan, 0, ',', '.'); ?>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11">
                    <i data-lucide="calendar-days" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-medium text-blue-600 sm:inline-flex">
                    Periode
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Periode Laporan
            </p>

            <p class="mt-1 truncate text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?php if ($bulan): ?>
                    <?= $nama_bulan[(int) $bulan]; ?> <?= $tahun; ?>
                <?php else: ?>
                    Tahun <?= $tahun; ?>
                <?php endif; ?>
            </p>
        </div>

        <div class="col-span-2 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:col-span-2 xl:col-span-1 sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-600 sm:h-11 sm:w-11">
                    <i data-lucide="receipt-text" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-violet-50 px-2.5 py-1 text-[10px] font-medium text-violet-600 sm:inline-flex">
                    Transaksi
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Jumlah Transaksi
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format(count($data_penerimaan), 0, ',', '.'); ?>
                <span class="text-xs font-medium text-slate-400">Transaksi</span>
            </p>
        </div>

    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                    Daftar Penerimaan ZIS
                </h2>

                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    <?= count($data_penerimaan); ?> transaksi ditemukan.
                </p>
            </div>

            <form
                method="get"
                class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap"
            >
                <select
                    name="jenis_zis"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-32 sm:text-sm"
                >
                    <option value="">Semua Jenis</option>
                    <?php foreach ($jenis_label as $value => $label): ?>
                        <option value="<?= $value; ?>" <?= $jenis_zis === $value ? 'selected' : ''; ?>>
                            <?= $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select
                    name="bulan"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-32 sm:text-sm"
                >
                    <option value="">Semua Bulan</option>
                    <?php foreach ($nama_bulan as $nomor => $nama): ?>
                        <option value="<?= $nomor; ?>" <?= (string) $bulan === (string) $nomor ? 'selected' : ''; ?>>
                            <?= $nama; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select
                    name="tahun"
                    onchange="this.form.submit()"
                    class="min-h-10 w-full rounded-xl border border-slate-200 bg-white px-3 text-xs text-slate-600 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 sm:w-28 sm:text-sm"
                >
                    <?php for ($year = date('Y'); $year >= date('Y') - 5; $year--): ?>
                        <option value="<?= $year; ?>" <?= (string) $tahun === (string) $year ? 'selected' : ''; ?>>
                            <?= $year; ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <a
                    href="<?= base_url('laporan/penerimaan'); ?>"
                    class="col-span-2 inline-flex min-h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900 sm:col-span-1 sm:w-10 sm:px-0"
                    title="Reset Filter"
                >
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    <span class="sm:hidden">Reset Filter</span>
                </a>
            </form>
        </div>

        <?php if (empty($data_penerimaan)): ?>

            <div class="px-5 py-14 text-center sm:px-6 sm:py-16">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="inbox" class="h-6 w-6"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                    Belum Ada Data Penerimaan
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-500 sm:text-sm">
                    Tidak terdapat transaksi penerimaan ZIS yang sesuai dengan filter yang dipilih.
                </p>
            </div>

        <?php else: ?>

            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full min-w-[1100px] text-left">
                    <thead class="border-b border-slate-100 bg-slate-50">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                #
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Donatur
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Jenis ZIS
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Tanggal
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Nominal
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-bold uppercase tracking-wide text-slate-500">
                                Metode
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                Keterangan
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <?php $no = 1; ?>

                        <?php foreach ($data_penerimaan as $row): ?>
                            <?php
                            $nama_donatur = $row->nama_donatur ?? $row->sumber_dana ?? 'Umum';
                            $jenis = $row->jenis_zis ?? '-';
                            $tanggal = $row->tanggal ?? null;
                            ?>

                            <tr class="group transition hover:bg-slate-50/70">
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                    <?= $no++; ?>
                                </td>

                                <td class="min-w-[230px] px-5 py-4">
                                    <div class="flex items-center gap-3">

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-slate-800">
                                                <?= html_escape($nama_donatur); ?>
                                            </p>

                                            <?php if (!empty($row->no_hp_donatur)): ?>
                                                <p class="mt-0.5 text-xs text-slate-400">
                                                    <?= html_escape($row->no_hp_donatur); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <?php
                                    $badge = match ($jenis) {
                                        'Zakat' => 'bg-emerald-50 text-emerald-700',
                                        'Infaq' => 'bg-blue-50 text-blue-700',
                                        'Sedekah' => 'bg-violet-50 text-violet-700',
                                        default => 'bg-slate-100 text-slate-600'
                                    };
                                    ?>

                                    <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold <?= $badge; ?>">
                                        <?= html_escape(ucwords(strtolower($jenis))); ?>
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    <?= $tanggal ? date('d/m/Y', strtotime($tanggal)) : '-'; ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <p class="text-sm font-bold text-slate-900">
                                        Rp <?= number_format((float) ($row->nominal ?? 0), 0, ',', '.'); ?>
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    <?= html_escape(ucwords(strtolower($row->metode_pembayaran ?? '-'))); ?>
                                </td>

                                <td class="max-w-[220px] px-5 py-4 text-right">
                                    <span class="line-clamp-2 text-sm text-slate-500">
                                        <?= html_escape($row->keterangan ?? '-'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="divide-y divide-slate-100 lg:hidden">
                <?php foreach ($data_penerimaan as $row): ?>
                    <?php
                    $nama_donatur = $row->nama_donatur ?? $row->sumber_dana ?? 'Umum';
                    $jenis = $row->jenis_zis ?? '-';

                    $badge = match ($jenis) {
                        'Zakat' => 'bg-emerald-50 text-emerald-700',
                        'Infaq' => 'bg-blue-50 text-blue-700',
                        'Sedekah' => 'bg-violet-50 text-violet-700',
                        default => 'bg-slate-100 text-slate-600'
                    };
                    ?>

                    <article class="p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-sm font-bold text-emerald-700">
                                    <?= strtoupper(substr($nama_donatur, 0, 1)); ?>
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-slate-900">
                                        <?= html_escape($nama_donatur); ?>
                                    </p>

                                    <p class="mt-1 truncate text-xs text-slate-400">
                                        <?= $row->tanggal ? date('d M Y', strtotime($row->tanggal)) : '-'; ?>
                                    </p>
                                </div>
                            </div>

                            <span class="shrink-0 inline-flex rounded-lg px-2.5 py-1 text-[10px] font-semibold <?= $badge; ?>">
                                <?= html_escape($jenis); ?>
                            </span>
                        </div>

                        <div class="mt-4 rounded-xl bg-slate-50 p-3.5">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Nominal
                                    </p>

                                    <p class="mt-1 truncate text-sm font-bold text-slate-900">
                                        Rp <?= number_format((float) ($row->nominal ?? 0), 0, ',', '.'); ?>
                                    </p>
                                </div>

                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Metode
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                        <?= html_escape($row->metode_pembayaran ?? '-'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($row->alamat_donatur) || !empty($row->no_hp_donatur)): ?>
                            <div class="mt-3 rounded-xl border border-slate-100 p-3.5">
                                <?php if (!empty($row->no_hp_donatur)): ?>
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <i data-lucide="phone" class="h-4 w-4 shrink-0 text-slate-400"></i>
                                        <?= html_escape($row->no_hp_donatur); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($row->alamat_donatur)): ?>
                                    <div class="mt-2 flex items-start gap-2 text-xs leading-5 text-slate-500">
                                        <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-slate-400"></i>
                                        <span><?= html_escape($row->alamat_donatur); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($row->keterangan)): ?>
                            <p class="mt-3 text-xs leading-5 text-slate-500">
                                <?= html_escape($row->keterangan); ?>
                            </p>
                        <?php endif; ?>
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