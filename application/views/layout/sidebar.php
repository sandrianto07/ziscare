<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$current_page = $this->uri->segment(1);
$user = $user ?? [];
?>

<aside
    id="desktopSidebar"
    class="sidebar fixed inset-y-0 left-0 top-16 z-30 hidden w-64 flex-col border-r border-slate-200 bg-white lg:flex"
>
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-100 px-5">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm shadow-emerald-200">
            <i data-lucide="hand-heart" class="h-5 w-5"></i>
        </div>

        <div class="min-w-0">
            <h2 class="text-sm font-bold leading-tight text-slate-900">
                ZIS Care
            </h2>

            <p class="mt-0.5 truncate text-xs text-slate-400">
                MWCNU Ngasem
            </p>
        </div>
    </div>

    <nav class="sidebar-nav flex-1 overflow-y-auto px-3 py-5">
        <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">
            Menu Utama
        </p>

        <a
            href="<?= base_url('dashboard'); ?>"
            class="sidebar-link <?= $current_page === 'dashboard' ? 'active' : ''; ?>"
        >
            <i data-lucide="layout-dashboard" class="h-[18px] w-[18px] shrink-0"></i>
            <span>Dashboard</span>
        </a>

        <a
            href="<?= base_url('penerimaan'); ?>"
            class="sidebar-link <?= $current_page === 'penerimaan' ? 'active' : ''; ?>"
        >
            <i data-lucide="wallet" class="h-[18px] w-[18px] shrink-0"></i>
            <span>Penerimaan ZIS</span>
        </a>

        <a
            href="<?= base_url('penyaluran'); ?>"
            class="sidebar-link <?= $current_page === 'penyaluran' ? 'active' : ''; ?>"
        >
            <i data-lucide="hand-coins" class="h-[18px] w-[18px] shrink-0"></i>
            <span>Penyaluran ZIS</span>
        </a>

        <a
            href="<?= base_url('mustahik'); ?>"
            class="sidebar-link <?= $current_page === 'mustahik' ? 'active' : ''; ?>"
        >
            <i data-lucide="users" class="h-[18px] w-[18px] shrink-0"></i>
            <span>Data Mustahik</span>
        </a>

        <p class="mb-2 mt-7 px-3 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">
            Laporan
        </p>

        <a
            href="<?= base_url('laporan'); ?>"
            class="sidebar-link <?= $current_page === 'laporan' ? 'active' : ''; ?>"
        >
            <i data-lucide="file-text" class="h-[18px] w-[18px] shrink-0"></i>
            <span>Laporan</span>
        </a>
    </nav>

    <div class="border-t border-slate-100 p-3">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-2.5">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-sm font-bold text-emerald-700 ring-1 ring-emerald-200">
                <?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)); ?>
            </div>

            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-slate-800">
                    <?= html_escape($user['nama_lengkap'] ?? 'Admin'); ?>
                </p>

                <p class="truncate text-xs text-slate-400">
                    Administrator
                </p>
            </div>

            <a
                href="<?= base_url('logout'); ?>"
                title="Keluar"
                aria-label="Keluar"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-600 active:bg-red-100"
            >
                <i data-lucide="log-out" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</aside>