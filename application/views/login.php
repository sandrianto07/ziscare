<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Login Admin Sistem Informasi Pengelolaan ZIS MWCNU Kecamatan Ngasem.">
    <meta name="theme-color" content="#064e3b">

    <title><?= html_escape($title ?? 'Login Admin | ZIS Care') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen lg:grid lg:grid-cols-2">

    <!-- PANEL KIRI -->
    <div class="relative hidden overflow-hidden bg-emerald-950 lg:flex lg:min-h-screen lg:flex-col lg:justify-between">
        
        <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-emerald-400/10 blur-3xl"></div>

        <div class="relative z-10 p-10 xl:p-14">
            <a href="<?= base_url() ?>" class="inline-flex items-center gap-3 text-white">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10">
                    <i data-lucide="hand-heart" class="h-5 w-5"></i>
                </div>

                <div class="leading-tight">
                    <p class="font-bold">ZIS Care</p>
                    <p class="text-xs text-emerald-200/70">
                        MWCNU Kecamatan Ngasem
                    </p>
                </div>
            </a>
        </div>

        <div class="relative z-10 px-10 pb-16 xl:px-14">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-emerald-100">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                Sistem Informasi ZIS
            </span>

            <h1 class="mt-6 max-w-xl text-4xl font-black leading-tight tracking-tight text-white xl:text-5xl">
                Kelola amanah dengan
                <span class="text-emerald-400">tertib dan transparan.</span>
            </h1>

            <p class="mt-6 max-w-lg text-base leading-8 text-emerald-100/70">
                Masuk ke panel administrator untuk mengelola data penerimaan,
                penyaluran, dan laporan Zakat, Infak, dan Sedekah.
            </p>

            <div class="mt-8 flex flex-wrap gap-5 text-sm text-emerald-100/70">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield-check" class="h-4 w-4 text-emerald-400"></i>
                    Aman
                </div>

                <div class="flex items-center gap-2">
                    <i data-lucide="database" class="h-4 w-4 text-emerald-400"></i>
                    Terdata
                </div>

                <div class="flex items-center gap-2">
                    <i data-lucide="eye" class="h-4 w-4 text-emerald-400"></i>
                    Transparan
                </div>
            </div>
        </div>

        <div class="relative z-10 p-10 text-xs text-emerald-100/40 xl:px-14">
            © <?= date('Y') ?> MWCNU Kecamatan Ngasem Bojonegoro
        </div>
    </div>


    <!-- PANEL LOGIN -->
    <div class="flex min-h-screen flex-col">

        <!-- MOBILE HEADER -->
        <div class="flex items-center justify-between border-b border-slate-100 bg-white px-5 py-4 lg:hidden">

            <a href="<?= base_url() ?>" class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-700 text-white">
                    <i data-lucide="hand-heart" class="h-5 w-5"></i>
                </div>

                <div class="leading-tight">
                    <p class="font-bold text-slate-900">ZIS Ngasem</p>
                    <p class="text-xs text-slate-500">
                        MWCNU Kecamatan Ngasem
                    </p>
                </div>

            </a>

            <a
                href="<?= base_url() ?>"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50"
                aria-label="Kembali ke halaman utama"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </a>

        </div>


        <!-- FORM AREA -->
        <main class="flex flex-1 items-center justify-center px-5 py-10 sm:px-8 lg:px-12">

            <div class="w-full max-w-md">

                <!-- HEADER -->
                <div class="mb-8 text-center lg:text-left">

                    <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 lg:hidden">
                        <i data-lucide="lock-keyhole" class="h-6 w-6"></i>
                    </div>

                    <span class="text-sm font-bold uppercase tracking-widest text-emerald-700">
                        Administrator
                    </span>

                    <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                        Selamat datang
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-500 sm:text-base">
                        Masuk untuk mengakses panel pengelolaan ZIS.
                    </p>

                </div>


                <!-- ALERT ERROR -->
                <?php if ($this->session->flashdata('error')): ?>

                    <div class="mb-6 flex gap-3 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">

                        <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>

                        <div class="leading-6">
                            <?= $this->session->flashdata('error') ?>
                        </div>

                    </div>

                <?php endif; ?>


                <!-- LOGIN CARD -->
                <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-8">

                    <form
                        action="<?= base_url('login/proses') ?>"
                        method="POST"
                        autocomplete="off"
                        class="space-y-5"
                    >

                        <!-- USERNAME -->
                        <div>

                            <label
                                for="login"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Username atau Email
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i data-lucide="user" class="h-5 w-5"></i>
                                </div>

                                <input
                                    type="text"
                                    id="login"
                                    name="login"
                                    value="<?= set_value('login') ?>"
                                    placeholder="Masukkan username atau email"
                                    autocomplete="username"
                                    autofocus
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                    required
                                >

                            </div>

                        </div>


                        <!-- PASSWORD -->
                        <div>

                            <div class="mb-2 flex items-center justify-between">

                                <label
                                    for="password"
                                    class="block text-sm font-semibold text-slate-700"
                                >
                                    Password
                                </label>

                            </div>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i data-lucide="lock" class="h-5 w-5"></i>
                                </div>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    autocomplete="current-password"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                                    required
                                >

                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-emerald-700"
                                    aria-label="Tampilkan password"
                                >
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </button>

                            </div>

                        </div>


                        <!-- SUBMIT -->
                        <button
                            type="submit"
                            class="group flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 transition hover:-translate-y-0.5 hover:bg-emerald-800 active:translate-y-0"
                        >

                            <span>Masuk ke Dashboard</span>

                            <i
                                data-lucide="arrow-right"
                                class="h-4 w-4 transition-transform group-hover:translate-x-1"
                            ></i>

                        </button>

                    </form>

                </div>


                <!-- FOOTER -->
                <div class="mt-6 text-center">

                    <a
                        href="<?= base_url() ?>"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-700"
                    >
                        <i data-lucide="arrow-left" class="h-4 w-4"></i>
                        Kembali ke halaman utama
                    </a>

                </div>

                <p class="mt-8 text-center text-xs leading-5 text-slate-400">
                    Sistem Informasi Pengelolaan Zakat, Infak, dan Sedekah
                </p>

            </div>

        </main>

    </div>

</div>


<script>
lucide.createIcons();

const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

togglePassword.addEventListener('click', () => {

    const isPassword = password.type === 'password';

    password.type = isPassword ? 'text' : 'password';

    togglePassword.innerHTML = `
        <i data-lucide="${isPassword ? 'eye-off' : 'eye'}" class="h-5 w-5"></i>
    `;

    togglePassword.setAttribute(
        'aria-label',
        isPassword ? 'Sembunyikan password' : 'Tampilkan password'
    );

    lucide.createIcons();
});
</script>

</body>
</html>