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

            <li class="side-nav-title">Apps</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmpolyeeManagement" aria-expanded="false" aria-controls="sidebarEmpolyeeManagement" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Employee Management </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmpolyeeManagement">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?= base_url('employee'); ?>">Data Employee</a>
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