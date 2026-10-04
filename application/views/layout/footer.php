<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    </main>
</div>

<footer class="app-footer fixed bottom-0 left-0 right-0 z-30 h-14 border-t border-slate-200 bg-white">
    <div class="flex h-full items-center justify-between px-4 text-xs text-slate-400 sm:px-5 lg:px-6">
        <span>© <?= date('Y'); ?> ZIS Care</span>
        <span class="hidden sm:block">MWCNU Kecamatan Ngasem</span>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const desktopSidebar = document.getElementById('desktopSidebar');
    const mobileButton = document.getElementById('mobileMenuBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('mobileOverlay');

    const renderIcons = () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    };

    const openMobile = () => {
        if (!mobileSidebar || !overlay) return;

        mobileSidebar.classList.remove('-translate-x-full');
        mobileSidebar.classList.add('translate-x-0');

        overlay.classList.remove('hidden');

        mobileSidebar.setAttribute('aria-hidden', 'false');
        mobileButton?.setAttribute('aria-expanded', 'true');

        document.body.classList.add('overflow-hidden');
    };

    const closeMobile = () => {
        if (!mobileSidebar || !overlay) return;

        mobileSidebar.classList.remove('translate-x-0');
        mobileSidebar.classList.add('-translate-x-full');

        overlay.classList.add('hidden');

        mobileSidebar.setAttribute('aria-hidden', 'true');
        mobileButton?.setAttribute('aria-expanded', 'false');

        document.body.classList.remove('overflow-hidden');
    };

    if (desktopSidebar && mobileSidebar) {
        mobileSidebar.innerHTML = desktopSidebar.innerHTML;

        mobileSidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeMobile);
        });
    }

    mobileButton?.addEventListener('click', () => {
        if (mobileSidebar?.classList.contains('translate-x-0')) {
            closeMobile();
        } else {
            openMobile();
        }
    });

    overlay?.addEventListener('click', closeMobile);

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            closeMobile();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            closeMobile();
        }
    });

    renderIcons();
});
</script>

</body>
</html>