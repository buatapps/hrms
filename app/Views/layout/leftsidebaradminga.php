<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="<?= base_url(); ?>" class="logo logo-light">
        <span class="logo-lg">
            <img src="<?= base_url(); ?>assets/images/logo.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="<?= base_url(); ?>assets/images/logo-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="<?= base_url(); ?>" class="logo logo-dark">
        <span class="logo-lg">
            <img src="<?= base_url(); ?>assets/images/logo-dark.png" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="<?= base_url(); ?>assets/images/logo-dark-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>

            <!-- <li class="side-nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li> -->

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboard" aria-expanded="false" aria-controls="sidebarDashboard" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarDashboard">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?= base_url('dashboard/count_makan'); ?>">Dasboard Count Makan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('dashboard/order_catering'); ?>">Dasboard Report Order Catering</a>
                        </li>
                        <!-- <li>
                            <a href="<?= base_url('dashboard/grafik_karyawan'); ?>">Dasboard Grafik Karyawan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('dashboard/notifikasi'); ?>">Dasboard Notifikasi</a>
                        </li> -->
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Apps</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarGeneralAffair " aria-expanded="false" aria-controls="sidebarGeneralAffair " class="side-nav-link">
                    <i class="uil-document-layout-right"></i>
                    <span> General Affairs </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarGeneralAffair">
                    <ul class="side-nav-second-level">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarInventory" aria-expanded="false" aria-controls="sidebarInventory">
                                <span> Inventory </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarInventory">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('inventory_stock'); ?>">Stock</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('inventory_items'); ?>">Inventory Items</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('inventory_in'); ?>">Transactions In</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('inventory_out'); ?>">Transactions Out</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('inventory_stock_opname'); ?>">Stock Opname</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?= base_url('general_affairs/sim'); ?>">Data SIM</a>
                        </li>
                        <li>
                            <a href="<?= base_url('general_affairs/stnk'); ?>">Data STNK</a>
                        </li>
                        <li>
                            <a href="<?= base_url('general_affairs/stiker_kendaraan'); ?>">QR Stiker Kendaraan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('general_affairs/sertifikat'); ?>">Sertifikat</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->