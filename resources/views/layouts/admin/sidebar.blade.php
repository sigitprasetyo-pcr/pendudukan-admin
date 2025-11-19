<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="../assets/images/logos/logo.svg" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <!-- Section Title -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Kependudukan</span>
                </li>

                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg" href="{{ route('dashboard') }}" aria-expanded="false">
                        <iconify-icon icon="solar:atom-line-duotone"></iconify-icon>
                        <span class="hide-menu">Dashboard Admin</span>
                    </a>
                </li>

                <!-- Keluarga KK -->
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between" target="_blank"
                       href="{{ url('/keluarga-kk') }}" aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="solar:screencast-2-line-duotone"></iconify-icon>
                            </span>
                            <span class="hide-menu">Keluarga KK</span>
                        </div>
                    </a>
                </li>

                <!-- Anggota Keluarga (FIXED LINK) -->
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between"
                       href="{{ route('pages.admin.anggota_keluarga.index') }}"
                       aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="solar:chart-line-duotone"></iconify-icon>
                            </span>
                            <span class="hide-menu">Anggota Keluarga</span>
                        </div>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg justify-content-between has-arrow"
                       href="javascript:void(0)" aria-expanded="false">
                        <div class="d-flex align-items-center gap-6">
                            <span class="d-flex">
                                <iconify-icon icon="solar:home-angle-line-duotone"></iconify-icon>
                            </span>
                            <span class="hide-menu">Master Data</span>
                        </div>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level">

                        <!-- User -->
                        <li class="sidebar-item">
                            <a class="sidebar-link primary-hover-bg justify-content-between" target="_blank"
                               href="{{ route('user.index') }}">
                                <div class="d-flex align-items-center gap-6">
                                    <span class="d-flex"><span class="icon-small"></span></span>
                                    <span class="hide-menu">User</span>
                                </div>
                            </a>
                        </li>

                        <!-- Warga -->
                        <li class="sidebar-item">
                            <a class="sidebar-link primary-hover-bg justify-content-between" target="_blank"
                               href="{{ route('warga.index') }}">
                                <div class="d-flex align-items-center gap-6">
                                    <span class="d-flex"><span class="icon-small"></span></span>
                                    <span class="hide-menu">Warga</span>
                                </div>
                            </a>
                        </li>

                        <!-- ⭐ Tambahan Baru — Peristiwa Kelahiran -->
                        <li class="sidebar-item">
                            <a class="sidebar-link primary-hover-bg justify-content-between" target="_blank"
                               href="{{ route('pages.admin.peristiwa_kelahiran.index') }}">
                                <div class="d-flex align-items-center gap-6">
                                    <span class="d-flex"><span class="icon-small"></span></span>
                                    <span class="hide-menu">Peristiwa Kelahiran</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
