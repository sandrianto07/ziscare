<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = $page_title ?? 'Dashboard';
$title = $title ?? 'ZIS Care';
$user = $user ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ZIS Care - Sistem Administrasi ZIS MWCNU Kecamatan Ngasem">
    <title><?= html_escape($title); ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css'); ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">

<header class="fixed inset-x-0 top-0 z-50 h-16 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="flex h-full items-center justify-between px-4 sm:px-6 lg:px-7">
        <div class="flex min-w-0 items-center gap-2">
            <button
                type="button"
                id="mobileMenuBtn"
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 lg:hidden"
                aria-label="Buka menu"
            >
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden text-right sm:block">
                <p class="max-w-40 truncate text-sm font-semibold text-slate-800">
                    <?= html_escape($user['nama_lengkap'] ?? 'Admin'); ?>
                </p>
                <p class="text-xs text-slate-400">
                    Administrator
                </p>
            </div>

            <div class="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-emerald-100 text-sm font-bold text-emerald-700 ring-1 ring-emerald-200">
                <?php if (!empty($user['foto'])): ?>
                    <img
                        src="<?= base_url('uploads/users/' . $user['foto']); ?>"
                        alt="Foto Profil"
                        class="h-full w-full object-cover"
                    >
                <?php else: ?>
                    <?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<div id="mobileOverlay" class="fixed inset-0 z-40 hidden bg-slate-950/40 backdrop-blur-[2px] lg:hidden"></div>

<div
    id="mobileSidebar"
    class="fixed inset-y-0 left-0 top-16 z-50 w-[280px] -translate-x-full overflow-y-auto border-r border-slate-200 bg-white shadow-2xl transition-transform duration-300 lg:hidden"
></div>

<div id="mainWrapper" class="main-wrapper min-h-screen pt-16 pb-14">
    <main class="content-area">