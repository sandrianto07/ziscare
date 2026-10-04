<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit = isset($mode) && $mode === 'edit';

$form_action = $is_edit
    ? base_url('penyaluran/update/' . $data->id)
    : base_url('penyaluran/simpan');

$tanggal = $is_edit ? $data->tanggal : date('Y-m-d');
$jenis_zis = $is_edit ? $data->jenis_zis : '';
$mustahik_id = $is_edit ? $data->mustahik_id : '';
$kategori_penerima = $is_edit ? ($data->kategori_penerima ?? '') : '';
$nominal = $is_edit ? $data->nominal : '';
$metode_penyaluran = $is_edit ? $data->metode_penyaluran : 'tunai';
$keterangan = $is_edit ? $data->keterangan : '';

$this->load->view('layout/header', [
    'title' => $is_edit ? 'Edit Penyaluran | ZIS Care' : 'Tambah Penyaluran | ZIS Care',
    'page_title' => $is_edit ? 'Edit Penyaluran' : 'Tambah Penyaluran',
    'user' => $user
]);

$this->load->view('layout/sidebar', [
    'user' => $user
]);
?>

<div class="mx-auto w-full max-w-5xl">

    <div class="mb-5 sm:mb-6">
        <div class="flex items-center gap-2 text-xs font-medium text-slate-400 sm:text-sm">
            <a
                href="<?= base_url('dashboard'); ?>"
                class="transition hover:text-emerald-600"
            >
                Dashboard
            </a>

            <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

            <a
                href="<?= base_url('penyaluran'); ?>"
                class="transition hover:text-emerald-600"
            >
                Penyaluran ZIS
            </a>

            <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

            <span class="text-slate-600">
                <?= $is_edit ? 'Edit' : 'Tambah'; ?>
            </span>
        </div>

        <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    <?= $is_edit ? 'Edit Penyaluran' : 'Tambah Penyaluran'; ?>
                </h1>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    <?= $is_edit
                        ? 'Perbarui data transaksi penyaluran ZIS.'
                        : 'Catat transaksi penyaluran Zakat, Infak, atau Sedekah.'; ?>
                </p>
            </div>

            <a
                href="<?= base_url('penyaluran'); ?>"
                class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-800 active:bg-slate-100 sm:w-auto"
            >
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3.5 text-sm text-red-700">
            <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>

            <div>
                <?= $this->session->flashdata('error'); ?>
            </div>
        </div>
    <?php endif; ?>

    <form
        action="<?= $form_action; ?>"
        method="post"
        enctype="multipart/form-data"
        id="penyaluranForm"
        autocomplete="off"
    >

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                    <i data-lucide="hand-coins" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                        Informasi Penyaluran
                    </h2>

                    <p class="mt-0.5 text-xs text-slate-500 sm:text-sm">
                        Lengkapi informasi transaksi penyaluran ZIS.
                    </p>
                </div>
            </div>

            <div class="space-y-5 p-4 sm:space-y-6 sm:p-6">

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>
                        <label
                            for="tanggal"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Tanggal <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            value="<?= html_escape(set_value('tanggal', $tanggal)); ?>"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                    <div>
                        <label
                            for="jenis_zis"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Jenis ZIS <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="jenis_zis"
                            id="jenis_zis"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                            <option value="">Pilih Jenis ZIS</option>

                            <option
                                value="zakat"
                                <?= set_select('jenis_zis', 'zakat', $jenis_zis === 'zakat'); ?>
                            >
                                Zakat
                            </option>

                            <option
                                value="infak"
                                <?= set_select('jenis_zis', 'infak', $jenis_zis === 'infak'); ?>
                            >
                                Infak
                            </option>

                            <option
                                value="sedekah"
                                <?= set_select('jenis_zis', 'sedekah', $jenis_zis === 'sedekah'); ?>
                            >
                                Sedekah
                            </option>
                        </select>
                    </div>

                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label
                            for="mustahik_id"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="mustahik_id"
                            id="mustahik_id"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                            <option value="">Pilih Mustahik</option>

                            <?php foreach ($data_mustahik as $mustahik): ?>
                                <option
                                    value="<?= $mustahik->id; ?>"
                                    data-kategori="<?= html_escape($mustahik->kategori_mustahik); ?>"
                                    <?= set_select('mustahik_id', $mustahik->id, $mustahik_id == $mustahik->id); ?>
                                >
                                    <?= html_escape($mustahik->nama_lengkap); ?> — <?= html_escape(ucwords(strtolower($mustahik->nik))); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label
                            for="kategori_penyaluran"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Kategori Penyaluran
                        </label>

                        <select
                            id="kategori_penyaluran"
                            name="kategori_penerima"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            required
                        >
                            <option value="">Pilih kategori penyaluran</option>

                            <?php
                            $kategori_penyaluran = [
                                'Beasiswa',
                                'Santunan',
                                'Bantuan Pendidikan',
                                'Bantuan Kesehatan',
                                'Bantuan Sosial',
                                'Bantuan Ekonomi',
                                'Kegiatan Keagamaan',
                                'Pemberdayaan Masyarakat',
                                'Lainnya'
                            ];
                            ?>

                            <?php foreach ($kategori_penyaluran as $kategori): ?>
                                <option
                                    value="<?= html_escape($kategori) ?>"
                                    <?= strtolower($kategori_penerima ?? '') === strtolower($kategori) ? 'selected' : '' ?>
                                >
                                    <?= html_escape($kategori) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <p class="mt-1.5 text-xs text-slate-400">
                            Pilih kategori sesuai dengan tujuan penyaluran dana ZIS.
                        </p>
                    </div>
                </div>

                <div>
                    <label
                        for="nominal"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nominal <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">
                            Rp
                        </span>

                        <input
                            type="text"
                            name="nominal"
                            id="nominal"
                            value="<?= html_escape(set_value(
                                'nominal',
                                $nominal !== ''
                                    ? number_format($nominal, 0, ',', '.')
                                    : ''
                            )); ?>"
                            placeholder="0"
                            required
                            inputmode="numeric"
                            autocomplete="off"
                            class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                    <p class="mt-1.5 text-xs text-slate-400">
                        Masukkan nominal dana yang disalurkan.
                    </p>
                </div>

                <div>
                    <label
                        for="metode_penyaluran"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Metode Penyaluran <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="metode_penyaluran"
                        id="metode_penyaluran"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                    >
                        <option
                            value="tunai"
                            <?= $metode_penyaluran === 'tunai' ? 'selected' : ''; ?>
                        >
                            Tunai
                        </option>

                        <option
                            value="transfer"
                            <?= $metode_penyaluran === 'transfer' ? 'selected' : ''; ?>
                        >
                            Transfer
                        </option>

                        <option
                            value="barang"
                            <?= $metode_penyaluran === 'barang' ? 'selected' : ''; ?>
                        >
                            Barang
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        for="keterangan"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        id="keterangan"
                        rows="4"
                        maxlength="1000"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                        class="w-full resize-none rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                    ><?= html_escape(set_value('keterangan', $keterangan)); ?></textarea>

                    <div class="mt-1.5 flex justify-end">
                        <span
                            id="keteranganCounter"
                            class="text-xs text-slate-400"
                        >
                            0 / 1000
                        </span>
                    </div>
                </div>

                <div>
                    <label
                        for="bukti"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Bukti Penyaluran
                    </label>

                    <input
                        type="file"
                        name="bukti"
                        id="bukti"
                        accept=".jpg,.jpeg,.png,.webp,.pdf"
                        class="block w-full rounded-xl border border-slate-200 bg-white text-sm text-slate-500 file:mr-3 file:border-0 file:bg-emerald-50 file:px-3.5 file:py-2.5 file:text-sm file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100"
                    >

                    <p class="mt-1.5 text-xs text-slate-400">
                        JPG, JPEG, PNG, WEBP atau PDF. Maksimal 2 MB.
                    </p>

                    <?php if ($is_edit && !empty($data->bukti)): ?>
                        <div class="mt-3 flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500 ring-1 ring-slate-100">
                                <i data-lucide="paperclip" class="h-4 w-4"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-xs text-slate-400">
                                    Bukti saat ini
                                </p>

                                <p class="truncate text-sm font-medium text-slate-600">
                                    <?= html_escape($data->bukti); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

            <div class="flex flex-col-reverse gap-2.5 border-t border-slate-100 bg-slate-50/70 p-4 sm:flex-row sm:justify-end sm:p-5">

                <a
                    href="<?= base_url('penyaluran'); ?>"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 active:bg-slate-200"
                >
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    id="submitButton"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-bold text-white shadow-sm shadow-emerald-600/20 transition hover:bg-emerald-700 active:bg-emerald-800 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>

                    <span id="submitText">
                        <?= $is_edit ? 'Simpan Perubahan' : 'Simpan Penyaluran'; ?>
                    </span>
                </button>

            </div>

        </div>

    </form>

</div>

<?php $this->load->view('layout/footer'); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const nominalInput = document.getElementById('nominal');
    const keterangan = document.getElementById('keterangan');
    const counter = document.getElementById('keteranganCounter');
    const bukti = document.getElementById('bukti');
    const form = document.getElementById('penyaluranForm');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const mustahikSelect = document.getElementById('mustahik_id');
    const kategoriInput = document.getElementById('kategori_penerima');

    const updateKategori = () => {
        const selected = mustahikSelect?.options[mustahikSelect.selectedIndex];
        const kategori = selected?.dataset.kategori || '';

        kategoriInput.value = kategori
            ? kategori.toLowerCase().replace(/\b\w/g, char => char.toUpperCase())
            : '';
    };

    mustahikSelect?.addEventListener('change', updateKategori);
    updateKategori();

    if (nominalInput) {
        nominalInput.addEventListener('input', function () {
            const value = this.value.replace(/\D/g, '');
            this.value = value
                ? parseInt(value, 10).toLocaleString('id-ID')
                : '';
        });

        nominalInput.addEventListener('keydown', event => {
            const allowedKeys = [
                'Backspace',
                'Delete',
                'ArrowLeft',
                'ArrowRight',
                'ArrowUp',
                'ArrowDown',
                'Tab',
                'Home',
                'End'
            ];

            if (
                !/[0-9]/.test(event.key) &&
                !allowedKeys.includes(event.key)
            ) {
                event.preventDefault();
            }
        });
    }

    const updateCounter = () => {
        if (keterangan && counter) {
            counter.textContent = `${keterangan.value.length} / 1000`;
        }
    };

    keterangan?.addEventListener('input', updateCounter);
    updateCounter();

    bukti?.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            return;
        }

        const maxSize = 2 * 1024 * 1024;

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'application/pdf'
        ];

        if (!allowedTypes.includes(file.type)) {
            alert(
                'Format file tidak diperbolehkan. Gunakan JPG, JPEG, PNG, WEBP atau PDF.'
            );

            this.value = '';
            return;
        }

        if (file.size > maxSize) {
            alert('Ukuran file maksimal 2 MB.');
            this.value = '';
        }
    });

    form?.addEventListener('submit', () => {
        if (submitButton) {
            submitButton.disabled = true;
        }

        if (submitText) {
            submitText.textContent = 'Menyimpan...';
        }
    });
});
</script>