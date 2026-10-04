<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit = isset($mode) && $mode === 'edit';

$form_action = $is_edit
    ? base_url('mustahik/update/' . $data->id)
    : base_url('mustahik/simpan');

$kode_mustahik = $is_edit ? $data->kode_mustahik : 'Otomatis';
$nik = $is_edit ? $data->nik : '';
$nama_lengkap = $is_edit ? $data->nama_lengkap : '';
$jenis_kelamin = $is_edit ? $data->jenis_kelamin : '';
$no_hp = $is_edit ? $data->no_hp : '';
$alamat = $is_edit ? $data->alamat : '';
$desa = $is_edit ? $data->desa : '';
$kecamatan = $is_edit ? $data->kecamatan : '';
$kategori_mustahik = $is_edit ? $data->kategori_mustahik : '';
$status = $is_edit ? $data->status : 'aktif';
$keterangan = $is_edit ? $data->keterangan : '';
$tanggal_terdaftar = $is_edit ? $data->tanggal_terdaftar : date('Y-m-d');

$kategori_options = [
    'fakir' => 'Fakir',
    'miskin' => 'Miskin',
    'amil' => 'Amil',
    'muallaf' => 'Muallaf',
    'riqab' => 'Riqab',
    'gharim' => 'Gharim',
    'fisabilillah' => 'Fisabilillah',
    'ibnu_sabil' => 'Ibnu Sabil'
];

$this->load->view('layout/header', [
    'title' => ($is_edit ? 'Edit Mustahik' : 'Tambah Mustahik') . ' | ZIS Care',
    'page_title' => $is_edit ? 'Edit Mustahik' : 'Tambah Mustahik',
    'user' => $user
]);

$this->load->view('layout/sidebar', ['user' => $user]);

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
                href="<?= base_url('mustahik'); ?>"
                class="transition hover:text-emerald-600"
            >
                Data Mustahik
            </a>

            <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0"></i>

            <span class="text-slate-600">
                <?= $is_edit ? 'Edit' : 'Tambah'; ?>
            </span>
        </div>

        <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    <?= $is_edit ? 'Edit Mustahik' : 'Tambah Mustahik'; ?>
                </h1>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    <?= $is_edit
                        ? 'Perbarui informasi data mustahik.'
                        : 'Tambahkan data penerima manfaat ZIS baru.'; ?>
                </p>
            </div>

            <a
                href="<?= base_url('mustahik'); ?>"
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

            <div>
                <?= $form_error; ?>
            </div>
        </div>
    <?php endif; ?>

    <?= form_open($form_action, [
        'id' => 'mustahikForm',
        'autocomplete' => 'off'
    ]); ?>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                <i data-lucide="user-round-plus" class="h-5 w-5"></i>
            </div>

            <div class="min-w-0">
                <h2 class="text-sm font-bold text-slate-900 sm:text-base">
                    Informasi Mustahik
                </h2>

                <p class="mt-0.5 text-xs text-slate-500 sm:text-sm">
                    Lengkapi identitas dan informasi penerima manfaat.
                </p>
            </div>
        </div>

        <div class="space-y-5 p-4 sm:space-y-6 sm:p-6">

            <section>
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <i data-lucide="contact" class="h-4 w-4"></i>
                    </div>

                    <h3 class="text-sm font-bold text-slate-800">
                        Identitas Mustahik
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>
                        <label
                            for="kode_mustahik"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Kode Mustahik
                        </label>

                        <div class="relative">
                            <i
                                data-lucide="hash"
                                class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                            ></i>

                            <input
                                type="text"
                                id="kode_mustahik"
                                value="<?= html_escape($kode_mustahik); ?>"
                                readonly
                                class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 pl-10 text-sm font-medium text-slate-500 outline-none"
                            >
                        </div>

                        <?php if (!$is_edit): ?>
                            <p class="mt-1.5 text-xs text-slate-400">
                                Kode akan dibuat otomatis oleh sistem.
                            </p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label
                            for="nik"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            NIK <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nik"
                            id="nik"
                            value="<?= html_escape(set_value('nik', $nik)); ?>"
                            maxlength="16"
                            minlength="16"
                            inputmode="numeric"
                            pattern="[0-9]{16}"
                            placeholder="Masukkan 16 digit NIK"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                        <p
                            id="nikCounter"
                            class="mt-1.5 text-xs text-slate-400"
                        >
                            0 / 16 digit
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <label
                            for="nama_lengkap"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_lengkap"
                            id="nama_lengkap"
                            value="<?= html_escape(set_value('nama_lengkap', $nama_lengkap)); ?>"
                            maxlength="150"
                            placeholder="Masukkan nama lengkap mustahik"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>

                        <div class="grid grid-cols-2 gap-3">

                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="jenis_kelamin"
                                    value="laki-laki"
                                    class="peer sr-only"
                                    <?= set_radio(
                                        'jenis_kelamin',
                                        'laki-laki',
                                        $jenis_kelamin === 'laki-laki'
                                    ); ?>
                                >

                                <div class="flex min-h-[44px] items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                                    <i data-lucide="user" class="h-4 w-4"></i>
                                    Laki-laki
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input
                                    type="radio"
                                    name="jenis_kelamin"
                                    value="perempuan"
                                    class="peer sr-only"
                                    <?= set_radio(
                                        'jenis_kelamin',
                                        'perempuan',
                                        $jenis_kelamin === 'perempuan'
                                    ); ?>
                                >

                                <div class="flex min-h-[44px] items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                                    <i data-lucide="user-round" class="h-4 w-4"></i>
                                    Perempuan
                                </div>
                            </label>

                        </div>
                    </div>

                    <div>
                        <label
                            for="no_hp"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            No. HP
                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            id="no_hp"
                            value="<?= html_escape(set_value('no_hp', $no_hp)); ?>"
                            maxlength="20"
                            inputmode="numeric"
                            placeholder="Contoh: 081234567890"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                </div>
            </section>

            <section>
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <i data-lucide="map-pin" class="h-4 w-4"></i>
                    </div>

                    <h3 class="text-sm font-bold text-slate-800">
                        Alamat
                    </h3>
                </div>

                <div class="space-y-5">

                    <div>
                        <label
                            for="alamat"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            name="alamat"
                            id="alamat"
                            rows="3"
                            placeholder="Masukkan alamat lengkap mustahik..."
                            required
                            class="w-full resize-none rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        ><?= html_escape(set_value('alamat', $alamat)); ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        <div>
                            <label
                                for="desa"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Desa / Kelurahan
                            </label>

                            <input
                                type="text"
                                name="desa"
                                id="desa"
                                value="<?= html_escape(set_value('desa', $desa)); ?>"
                                maxlength="100"
                                placeholder="Contoh: Margomulyo"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                        <div>
                            <label
                                for="kecamatan"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Kecamatan
                            </label>

                            <input
                                type="text"
                                name="kecamatan"
                                id="kecamatan"
                                value="<?= html_escape(set_value('kecamatan', $kecamatan)); ?>"
                                maxlength="100"
                                placeholder="Contoh: Margomulyo"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                    </div>
                </div>
            </section>

            <section>
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <i data-lucide="badge-dollar-sign" class="h-4 w-4"></i>
                    </div>

                    <h3 class="text-sm font-bold text-slate-800">
                        Data ZIS
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>
                        <label
                            for="kategori_mustahik"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Kategori Mustahik <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="kategori_mustahik"
                            id="kategori_mustahik"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                            <option value="">Pilih Kategori Mustahik</option>

                            <?php foreach ($kategori_options as $value => $label): ?>
                                <option
                                    value="<?= $value; ?>"
                                    <?= set_select(
                                        'kategori_mustahik',
                                        $value,
                                        $kategori_mustahik === $value
                                    ); ?>
                                >
                                    <?= $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <p class="mt-1.5 text-xs text-slate-400">
                            Pilih kategori penerima manfaat sesuai kondisi.
                        </p>
                    </div>

                    <div>
                        <label
                            for="status"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Status <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="status"
                            id="status"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                            <option
                                value="aktif"
                                <?= set_select(
                                    'status',
                                    'aktif',
                                    $status === 'aktif'
                                ); ?>
                            >
                                Aktif
                            </option>

                            <option
                                value="tidak_aktif"
                                <?= set_select(
                                    'status',
                                    'tidak_aktif',
                                    $status === 'tidak_aktif'
                                ); ?>
                            >
                                Tidak Aktif
                            </option>
                        </select>

                        <p class="mt-1.5 text-xs text-slate-400">
                            Status menentukan apakah mustahik masih aktif.
                        </p>
                    </div>

                    <div>
                        <label
                            for="tanggal_terdaftar"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Tanggal Terdaftar <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_terdaftar"
                            id="tanggal_terdaftar"
                            value="<?= html_escape(set_value('tanggal_terdaftar', $tanggal_terdaftar)); ?>"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                </div>
            </section>

            <section>
                <div class="mb-4 flex items-center gap-2">
                    <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <i data-lucide="notebook-pen" class="h-4 w-4"></i>
                    </div>

                    <h3 class="text-sm font-bold text-slate-800">
                        Catatan
                    </h3>
                </div>

                <textarea
                    name="keterangan"
                    id="keterangan"
                    rows="4"
                    maxlength="1000"
                    placeholder="Tambahkan catatan atau keterangan mengenai mustahik..."
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
            </section>

        </div>

        <div class="flex flex-col-reverse gap-2.5 border-t border-slate-100 bg-slate-50/70 p-4 sm:flex-row sm:justify-end sm:p-5">

            <a
                href="<?= base_url('mustahik'); ?>"
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
                    <?= $is_edit ? 'Simpan Perubahan' : 'Simpan Mustahik'; ?>
                </span>
            </button>

        </div>
    </div>

    <?= form_close(); ?>
</div>

<?php $this->load->view('layout/footer'); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const nik = document.getElementById('nik');
    const nikCounter = document.getElementById('nikCounter');
    const noHp = document.getElementById('no_hp');
    const keterangan = document.getElementById('keterangan');
    const keteranganCounter = document.getElementById('keteranganCounter');
    const form = document.getElementById('mustahikForm');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');

    const updateNikCounter = () => {
        if (!nik || !nikCounter) {
            return;
        }

        nikCounter.textContent = `${nik.value.length} / 16 digit`;
        nikCounter.classList.toggle(
            'text-emerald-600',
            nik.value.length === 16
        );
        nikCounter.classList.toggle(
            'text-slate-400',
            nik.value.length !== 16
        );
    };

    nik?.addEventListener('input', function () {
        this.value = this.value
            .replace(/[^0-9]/g, '')
            .substring(0, 16);

        updateNikCounter();
    });

    noHp?.addEventListener('input', function () {
        this.value = this.value
            .replace(/[^0-9]/g, '')
            .substring(0, 20);
    });

    const updateKeteranganCounter = () => {
        if (keterangan && keteranganCounter) {
            keteranganCounter.textContent = `${keterangan.value.length} / 1000`;
        }
    };

    keterangan?.addEventListener(
        'input',
        updateKeteranganCounter
    );

    updateNikCounter();
    updateKeteranganCounter();

    form?.addEventListener('submit', event => {
        if (nik && nik.value.length !== 16) {
            event.preventDefault();

            alert('NIK harus terdiri dari 16 digit.');

            nik.focus();

            return;
        }

        if (!document.querySelector('input[name="jenis_kelamin"]:checked')) {
            event.preventDefault();

            alert('Silakan pilih jenis kelamin.');

            return;
        }

        if (submitButton) {
            submitButton.disabled = true;
        }

        if (submitText) {
            submitText.textContent = 'Menyimpan...';
        }
    });
});
</script>