<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('layout/header', [
    'title' => 'Penerimaan ZIS | ZIS Care',
    'page_title' => 'Penerimaan ZIS',
    'user' => $user
]);

$this->load->view('layout/sidebar', [
    'user' => $user
]);

$total_nominal = 0;
$total_tercatat = 0;

foreach ($data as $row) {
    if ($row->status === 'tercatat') {
        $total_nominal += (float) $row->nominal;
        $total_tercatat++;
    }

    if ($row->status === 'dibatalkan') {
        $total_dibatalkan++;
    }
}

$jenis_classes = [
    'zakat' => 'bg-emerald-50 text-emerald-700',
    'infak' => 'bg-blue-50 text-blue-700',
    'sedekah' => 'bg-amber-50 text-amber-700'
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
                    Penerimaan ZIS
                </span>
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Penerimaan ZIS
            </h1>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Kelola seluruh data penerimaan Zakat, Infak, dan Sedekah.
            </p>
        </div>

        <a
            href="<?= base_url('penerimaan/tambah'); ?>"
            class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 active:bg-emerald-800 sm:w-auto sm:px-5"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Penerimaan
        </a>
    </section>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="flex items-start gap-3 rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-700">
            <i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0"></i>
            <p class="min-w-0 leading-5">
                <?= html_escape($this->session->flashdata('success')); ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">
            <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>
            <p class="min-w-0 leading-5">
                <?= html_escape($this->session->flashdata('error')); ?>
            </p>
        </div>
    <?php endif; ?>

    <section class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 xl:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                    <i data-lucide="receipt" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-medium text-slate-400 sm:inline-flex">
                    Semua data
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Transaksi
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format(count($data), 0, ',', '.'); ?>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 sm:h-11 sm:w-11">
                    <i data-lucide="wallet" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-slate-50 px-2.5 py-1 text-[10px] font-medium text-slate-400 sm:inline-flex">
                    Tercatat
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Total Penerimaan
            </p>

            <p class="mt-1 truncate text-lg font-bold tracking-tight text-slate-900 sm:text-2xl">
                Rp <?= number_format($total_nominal, 0, ',', '.'); ?>
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-start justify-between gap-2">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                    <i data-lucide="circle-check" class="h-5 w-5"></i>
                </div>

                <span class="hidden rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-medium text-emerald-600 sm:inline-flex">
                    Aktif
                </span>
            </div>

            <p class="mt-4 text-xs font-medium text-slate-500 sm:text-sm">
                Transaksi Tercatat
            </p>

            <p class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                <?= number_format($total_tercatat, 0, ',', '.'); ?>
            </p>
        </div>

    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                    Data Penerimaan
                </h2>

                <p class="mt-0.5 text-xs text-slate-400 sm:text-sm">
                    Daftar seluruh transaksi penerimaan ZIS.
                </p>
            </div>

            <div class="flex w-fit items-center gap-2 rounded-lg bg-slate-50 px-3 py-2 text-xs font-medium text-slate-500">
                <i data-lucide="database" class="h-4 w-4"></i>
                <?= number_format(count($data), 0, ',', '.'); ?> data
            </div>
        </div>

        <?php if (empty($data)): ?>

            <div class="px-5 py-14 text-center sm:px-6 sm:py-16">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <i data-lucide="inbox" class="h-6 w-6"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-900 sm:text-base">
                    Belum ada data
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-500 sm:text-sm">
                    Belum ada transaksi penerimaan ZIS yang tercatat.
                </p>

                <a
                    href="<?= base_url('penerimaan/tambah'); ?>"
                    class="mt-5 inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 active:bg-emerald-800"
                >
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Tambah Penerimaan
                </a>
            </div>

        <?php else: ?>

            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full min-w-[950px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Transaksi
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Tanggal
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Jenis
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Sumber Dana
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Nominal
                            </th>
                            <th class="whitespace-nowrap px-5 py-4 font-semibold">
                                Metode
                            </th>
                            <th class="px-5 py-4 text-right font-semibold">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($data as $row): ?>
                            <?php
                            $jenis_class = $jenis_classes[$row->jenis_zis] ?? 'bg-slate-100 text-slate-600';
                            $is_cancelled = $row->status === 'dibatalkan';
                            ?>

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-900">
                                        <?= html_escape($row->kode_transaksi); ?>
                                    </p>

                                    <span class="mt-1 inline-flex rounded-full px-2 py-1 text-[10px] font-semibold <?= $is_cancelled ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600'; ?>">
                                        <?= $is_cancelled ? 'Dibatalkan' : 'Tercatat'; ?>
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                    <?= date('d/m/Y', strtotime($row->tanggal)); ?>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?= $jenis_class; ?>">
                                        <?= ucfirst($row->jenis_zis); ?>
                                    </span>
                                </td>

                                <td class="max-w-xs px-5 py-4">
                                    <p class="truncate font-medium text-slate-800">
                                        <?= html_escape($row->sumber_dana); ?>
                                    </p>

                                    <?php if (!empty($row->keterangan)): ?>
                                        <p class="mt-1 truncate text-xs text-slate-400">
                                            <?= html_escape($row->keterangan); ?>
                                        </p>
                                    <?php endif; ?>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 font-bold text-slate-900">
                                    Rp <?= number_format($row->nominal, 0, ',', '.'); ?>
                                </td>

                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-600">
                                        <i
                                            data-lucide="<?= $row->metode_pembayaran === 'tunai' ? 'banknote' : 'landmark'; ?>"
                                            class="h-4 w-4"
                                        ></i>
                                        <?= ucfirst($row->metode_pembayaran); ?>
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="<?= base_url('penerimaan/edit/' . $row->id); ?>"
                                            title="Edit"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition hover:bg-blue-100 active:bg-blue-200"
                                        >
                                            <i data-lucide="pencil" class="h-4 w-4"></i>
                                        </a>

                                        <button
                                            type="button"
                                            onclick="hapusData('<?= $row->id; ?>')"
                                            title="Hapus"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100 active:bg-red-200"
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

            <div class="divide-y divide-slate-100 lg:hidden">
                <?php foreach ($data as $row): ?>
                    <?php
                    $jenis_class = $jenis_classes[$row->jenis_zis] ?? 'bg-slate-100 text-slate-600';
                    $is_cancelled = $row->status === 'dibatalkan';
                    ?>

                    <article class="p-4 sm:p-5">

                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-900">
                                    <?= html_escape($row->kode_transaksi); ?>
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    <?= date('d/m/Y', strtotime($row->tanggal)); ?>
                                </p>
                            </div>

                            <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-semibold <?= $is_cancelled ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600'; ?>">
                                <?= $is_cancelled ? 'Dibatalkan' : 'Tercatat'; ?>
                            </span>
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?= $jenis_class; ?>">
                                <?= ucfirst($row->jenis_zis); ?>
                            </span>

                            <p class="text-base font-bold text-slate-900">
                                Rp <?= number_format($row->nominal, 0, ',', '.'); ?>
                            </p>
                        </div>

                        <div class="mt-4 rounded-xl bg-slate-50 p-3.5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Sumber Dana
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-slate-800">
                                        <?= html_escape($row->sumber_dana); ?>
                                    </p>
                                </div>

                                <div class="shrink-0 text-right">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Metode
                                    </p>

                                    <span class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-slate-600">
                                        <i
                                            data-lucide="<?= $row->metode_pembayaran === 'tunai' ? 'banknote' : 'landmark'; ?>"
                                            class="h-3.5 w-3.5"
                                        ></i>
                                        <?= ucfirst($row->metode_pembayaran); ?>
                                    </span>
                                </div>
                            </div>

                            <?php if (!empty($row->keterangan)): ?>
                                <div class="mt-3 border-t border-slate-200 pt-3">
                                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                                        Keterangan
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-500">
                                        <?= html_escape($row->keterangan); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a
                                href="<?= base_url('penerimaan/edit/' . $row->id); ?>"
                                class="flex min-h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-blue-50 px-3 py-2.5 text-xs font-semibold text-blue-600 transition hover:bg-blue-100 active:bg-blue-200"
                            >
                                <i data-lucide="pencil" class="h-4 w-4"></i>
                                Edit
                            </a>

                            <button
                                type="button"
                                onclick="hapusData('<?= $row->id; ?>')"
                                class="flex min-h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-red-50 px-3 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-100 active:bg-red-200"
                            >
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                Hapus
                            </button>
                        </div>

                    </article>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </section>

</div>

<script>
function hapusData(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data penerimaan ini?')) {
        window.location.href = '<?= base_url('penerimaan/hapus/'); ?>' + id;
    }
}
</script>

<?php $this->load->view('layout/footer'); ?>