<style>
    #sidebar {
        width: 240px;
        min-height: 100vh;
        transition: all .3s ease;
        background: #ffffff;
    }

    #sidebar.collapsed {
        margin-left: -240px;
    }

    @media (max-width: 768px) {
        #sidebar {
            position: fixed;
            z-index: 1040;
            top: 0;
            left: 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, .15);
        }
    }
</style>

<nav id="sidebar" class="border-end">

    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <strong>Menu Peserta</strong>

        <!-- Close button (mobile) -->
        <button class="btn btn-sm btn-outline-secondary d-md-none"
            onclick="toggleSidebar()">✕</button>
    </div>

    <ul class="nav flex-column p-2">
        <li class="nav-item mb-1">
            <a href="<?= base_url('hasil') ?>"
                class="nav-link <?= uri_string() == 'hasil' ? 'active fw-bold' : '' ?>">
                📄 Hasil Lomba
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="<?= base_url('leaderboard') ?>"
                class="nav-link <?= uri_string() == 'leaderboard' ? 'active fw-bold' : '' ?>">
                🏆 Leaderboard
            </a>
        </li>

        <li class="nav-item mt-3">
            <a href="<?= base_url('auth/logout') ?>" class="nav-link text-danger">
                🚪 Logout
            </a>
        </li>
    </ul>

</nav>