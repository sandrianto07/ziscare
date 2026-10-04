<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit = isset($mode) && $mode === 'edit';

$form_action = $is_edit
    ? base_url('penerimaan/update/' . $data->id)
    : base_url('penerimaan/simpan');

$tanggal = $is_edit ? $data->tanggal : date('Y-m-d');
$jenis_zis = $is_edit ? $data->jenis_zis : '';
$sumber_dana = $is_edit ? $data->sumber_dana : '';
$alamat_donatur = $is_edit ? ($data->alamat_donatur ?? '') : '';
$no_hp_donatur = $is_edit ? ($data->no_hp_donatur ?? '') : '';
$nominal = $is_edit ? $data->nominal : '';
$metode_pembayaran = $is_edit ? $data->metode_pembayaran : 'tunai';
$keterangan = $is_edit ? $data->keterangan : '';

$this->load->view('layout/header', [
    'title' => $is_edit ? 'Edit Penerimaan | ZIS Care' : 'Tambah Penerimaan | ZIS Care',
    'page_title' => $is_edit ? 'Edit Penerimaan' : 'Tambah Penerimaan',
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
                href="<?= base_url('penerimaan'); ?>"
                class="transition hover:text-emerald-600"
            >
                Penerimaan ZIS
            </a>

            <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

            <span class="text-slate-600">
                <?= $is_edit ? 'Edit' : 'Tambah'; ?>
            </span>
        </div>

        <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    <?= $is_edit ? 'Edit Penerimaan' : 'Tambah Penerimaan'; ?>
                </h1>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    <?= $is_edit
                        ? 'Perbarui data transaksi penerimaan ZIS.'
                        : 'Catat transaksi penerimaan Zakat, Infak, atau Sedekah.'; ?>
                </p>
            </div>

            <a
                href="<?= base_url('penerimaan'); ?>"
                class="inline-flex min-h-11 w-full shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-800 active:bg-slate-100 sm:w-auto"
            >
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Kembali
            </a>
        </div>
    </div>

    <?php if (!empty($form_error)): ?>
        <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 px-4 py-3.5 text-sm text-red-700">
            <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>
            <div><?= $form_error; ?></div>
        </div>
    <?php endif; ?>

    <?= form_open_multipart($form_action, [
        'id' => 'penerimaanForm',
        'autocomplete' => 'off'
    ]); ?>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                <i data-lucide="wallet" class="h-5 w-5"></i>
            </div>

            <div class="min-w-0">
                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                    Informasi Penerimaan
                </h2>
                <p class="mt-0.5 text-xs text-slate-500 sm:text-sm">
                    Lengkapi informasi transaksi penerimaan ZIS.
                </p>
            </div>
        </div>

        <div class="space-y-5 p-4 sm:space-y-6 sm:p-6">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label for="tanggal" class="mb-2 block text-sm font-semibold text-slate-700">
                        Tanggal <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        id="tanggal"
                        value="<?= html_escape(set_value('tanggal', $tanggal)); ?>"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                    >
                </div>

                <div>
                    <label for="jenis_zis" class="mb-2 block text-sm font-semibold text-slate-700">
                        Jenis ZIS <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="jenis_zis"
                        id="jenis_zis"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                    >
                        <option value="">Pilih Jenis ZIS</option>
                        <option value="zakat" <?= set_select('jenis_zis', 'zakat', $jenis_zis === 'zakat'); ?>>Zakat</option>
                        <option value="infak" <?= set_select('jenis_zis', 'infak', $jenis_zis === 'infak'); ?>>Infak</option>
                        <option value="sedekah" <?= set_select('jenis_zis', 'sedekah', $jenis_zis === 'sedekah'); ?>>Sedekah</option>
                    </select>
                </div>

            </div>

            <div>
                <label for="sumber_dana" class="mb-2 block text-sm font-semibold text-slate-700">
                    Sumber Dana <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="sumber_dana"
                    id="sumber_dana"
                    value="<?= html_escape(set_value('sumber_dana', $sumber_dana)); ?>"
                    placeholder="Contoh: Bapak Ahmad, Donatur, Jamaah, Instansi"
                    maxlength="150"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                >

                <p class="mt-1.5 text-xs text-slate-400">
                    Masukkan nama atau sumber pihak yang memberikan dana.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="alamat_donatur" class="mb-2 block text-sm font-semibold text-slate-700">
                        Alamat Donatur
                    </label>
                    <textarea
                        name="alamat_donatur"
                        id="alamat_donatur"
                        rows="3"
                        maxlength="255"
                        placeholder="Masukkan alamat pemberi ZIS"
                        class="w-full resize-none rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                    ><?= html_escape(set_value('alamat_donatur', $alamat_donatur)); ?></textarea>
                </div>

                <div>
                    <label for="no_hp_donatur" class="mb-2 block text-sm font-semibold text-slate-700">
                        Nomor Telepon
                        <span class="font-normal text-slate-400">(Opsional)</span>
                    </label>
                    <input
                        type="text"
                        name="no_hp_donatur"
                        id="no_hp_donatur"
                        value="<?= html_escape(set_value('no_hp_donatur', $no_hp_donatur)); ?>"
                        placeholder="Contoh: 081234567890"
                        maxlength="20"
                        inputmode="numeric"
                        autocomplete="tel"
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                    >
                    <p class="mt-1.5 text-xs text-slate-400">
                        Nomor telepon pemberi ZIS jika tersedia.
                    </p>
                </div>
            </div>

            <div>
                <label for="nominal" class="mb-2 block text-sm font-semibold text-slate-700">
                    Nominal Penerimaan <span class="text-red-500">*</span>
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
                    Contoh: 100.000 atau 1.500.000
                </p>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-semibold text-slate-700">
                    Metode Pembayaran <span class="text-red-500">*</span>
                </label>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    <label class="relative cursor-pointer">
                        <input
                            type="radio"
                            name="metode_pembayaran"
                            value="tunai"
                            class="peer sr-only"
                            <?= set_radio('metode_pembayaran', 'tunai', $metode_pembayaran === 'tunai'); ?>
                        >

                        <div class="flex min-h-[72px] items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                                <i data-lucide="banknote" class="h-5 w-5"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800">
                                    Tunai
                                </p>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    Pembayaran langsung
                                </p>
                            </div>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input
                            type="radio"
                            name="metode_pembayaran"
                            value="transfer"
                            class="peer sr-only"
                            <?= set_radio('metode_pembayaran', 'transfer', $metode_pembayaran === 'transfer'); ?>
                        >

                        <div class="flex min-h-[72px] items-center gap-3 rounded-xl border border-slate-200 bg-white p-3.5 transition hover:border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <i data-lucide="landmark" class="h-5 w-5"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800">
                                    Transfer
                                </p>
                                <p class="mt-0.5 text-xs text-slate-500">
                                    Transfer melalui rekening
                                </p>
                            </div>
                        </div>
                    </label>

                </div>
            </div>

            <div>
                <label for="keterangan" class="mb-2 block text-sm font-semibold text-slate-700">
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
                    <span id="keteranganCounter" class="text-xs text-slate-400">
                        0 / 1000
                    </span>
                </div>
            </div>

            <div>
                <label for="bukti" class="mb-2 block text-sm font-semibold text-slate-700">
                    Bukti Penerimaan
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
                href="<?= base_url('penerimaan'); ?>"
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
                    <?= $is_edit ? 'Simpan Perubahan' : 'Simpan Penerimaan'; ?>
                </span>
            </button>

        </div>

    </div>

    <?= form_close(); ?>

</div>

<?php $this->load->view('layout/footer'); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const nominalInput = document.getElementById('nominal');
    const keterangan = document.getElementById('keterangan');
    const counter = document.getElementById('keteranganCounter');
    const bukti = document.getElementById('bukti');
    const form = document.getElementById('penerimaanForm');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');

    if (nominalInput) {
        nominalInput.addEventListener('input', function () {
            const value = this.value.replace(/\D/g, '');
            this.value = value ? parseInt(value, 10).toLocaleString('id-ID') : '';
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

            if (!/[0-9]/.test(event.key) && !allowedKeys.includes(event.key)) {
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
            alert('Format file tidak diperbolehkan. Gunakan JPG, JPEG, PNG, WEBP atau PDF.');
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