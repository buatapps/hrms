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
                            <a href="<?= base_url('dashboard/dashboard_employee'); ?>">Dasboard Employee</a>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarDashboardAbsensi" aria-expanded="false" aria-controls="sidebarDashboardAbsensi">
                                <span> Dashboard Absensi </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarDashboardAbsensi">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('dashboard/late'); ?>">Employee Late</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('dashboard/absent'); ?>">Employee Absent</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?= base_url('dashboard/count_makan'); ?>">Dasboard Count Makan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('dashboard/order_catering'); ?>">Dasboard Report Order Catering</a>
                        </li>
                        <li>
                            <a href="<?= base_url('dashboard/grafik_karyawan'); ?>">Dasboard Grafik Karyawan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('dashboard/notifikasi'); ?>">Dasboard Notifikasi</a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarWelcomeBoard" aria-expanded="false" aria-controls="sidebarWelcomeBoard" class="side-nav-link">
                    <i class="uil-meeting-board"></i>
                    <span> Welcome Board </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarWelcomeBoard">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?= base_url('welcome_board'); ?>">Data</a>
                        </li>
                        <li>
                            <a href="<?= base_url('guest'); ?>">Guest</a>
                        </li>
                        <li>
                            <a href="<?= base_url('welcome_board_video'); ?>" target="_blank">Welcome Board Video</a>
                        </li>
                    </ul>
                </div>
            </li>

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
                            <a href="<?= base_url('employee/add'); ?>">Add Employee</a>
                        </li>
                        <li>
                            <a href="<?= base_url('employee'); ?>">Data Employee</a>
                        </li>
                        <li>
                            <a href="<?= base_url('contract'); ?>">Contract</a>
                        </li>
                        <li>
                            <a href="<?= base_url('employee/schedule'); ?>">Schedule</a>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarCountFood" aria-expanded="false" aria-controls="sidebarCountFood">
                                <span> Count Food </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarCountFood">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('count_food'); ?>">Generate</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('count_food/data'); ?>">Data</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('count_food/cardFood'); ?>">Card Food</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarOverTime" aria-expanded="false" aria-controls="sidebarOverTime">
                                <span> Overtime </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarOverTime">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('overtimes/form'); ?>">Form</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('overtime'); ?>">Data</a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="collapse" href="#sidebarAttendanceReportOvertime" aria-expanded="false" aria-controls="sidebarAttendanceReportOvertime">
                                            <span> Report </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarAttendanceReportOvertime">
                                            <ul class="side-nav-third-level">
                                                <li>
                                                    <a href="<?= base_url('overtime/report'); ?>">Report All</a>
                                                </li>
                                                <li>
                                                    <a href="<?= base_url('overtime/report_user'); ?>">Report per User</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                        <li>
                            <a href="<?= base_url('overtimes'); ?>">Overtimes</a>
                        </li>
                        <li>
                            <a href="<?= base_url('employee/resign'); ?>">Resign</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarAttendance " aria-expanded="false" aria-controls="sidebarAttendance " class="side-nav-link">
                    <i class="uil-clock-eight"></i>
                    <span> Attendance </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarAttendance">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?= base_url('attendance'); ?>">Data</a>
                        </li>
                        <li>
                            <a href="<?= base_url('attendance/download/0'); ?>">Download</a>
                        </li>
                        <li>
                            <a href="<?= base_url('attendance/employee_late'); ?>">Employee Late</a>
                        </li>
                        <li>
                            <a href="<?= base_url('attendance/absent'); ?>">Absent</a>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarAttendanceReport" aria-expanded="false" aria-controls="sidebarAttendanceReport">
                                <span> Report </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarAttendanceReport">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('attendance/report'); ?>">Report All</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('attendance/report_user'); ?>">Report User</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('attendance/report_department'); ?>">Report Department</a>
                                    </li>
                                    <li class="side-nav-item">
                                        <a data-bs-toggle="collapse" href="#reportMonthly" aria-expanded="false" aria-controls="reportMonthly">
                                            <span> Report Monthly </span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="reportMonthly">
                                            <ul class="side-nav-third-level">
                                                <li>
                                                    <a href="<?= base_url('attendance/reportmonthlydepartment'); ?>">Department</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarAttendanceHistory" aria-expanded="false" aria-controls="sidebarAttendanceHistory">
                                <span> History </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarAttendanceHistory">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('history/plant_group'); ?>">Plant - Group</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('history/absent'); ?>">Absent</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?= base_url('shift'); ?>">Shift</a>
                        </li>
                        <li>
                            <a href="<?= base_url('working_hours'); ?>">Working Hours</a>
                        </li>
                        <li>
                            <a href="<?= base_url('working_days'); ?>">Working Days</a>
                        </li>

                    </ul>
                </div>
            </li>

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
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarLocker" aria-expanded="false" aria-controls="sidebarLocker">
                                <span> Locker Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarLocker">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('locker'); ?>">Master Locker</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('locker_history'); ?>">Locker History</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarIT" aria-expanded="false" aria-controls="sidebarIT" class="side-nav-link">
                    <i class="uil uil-laptop"></i>
                    <span> IT </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarIT">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?= base_url('ticket'); ?>">Ticket</a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarinventory" aria-expanded="false" aria-controls="sidebarinventory">
                                <span> Inventory </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarinventory">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('inventory/hardware'); ?>">Hardware</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('inventory/software'); ?>">Software</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('inventory/network'); ?>">Network</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDataManagement" aria-expanded="false" aria-controls="sidebarDataManagement" class="side-nav-link">
                    <i class="uil-database-alt"></i>
                    <span> Data Management </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarDataManagement">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="<?= base_url('absent_type'); ?>">Absent type</a>
                        </li>
                        <li>
                            <a href="<?= base_url('attendance_machine'); ?>">Attendance Machine</a>
                        </li>
                        <li>
                            <a href="<?= base_url('bank'); ?>">Bank</a>
                        </li>
                        <li>
                            <a href="<?= base_url('company'); ?>">Company</a>
                        </li>
                        <li>
                            <a href="<?= base_url('division'); ?>">Division</a>
                        </li>
                        <li>
                            <a href="<?= base_url('education'); ?>">Education</a>
                        </li>
                        <li>
                            <a href="<?= base_url('employee_group'); ?>">Employee Group</a>
                        </li>
                        <li>
                            <a href="<?= base_url('employee_status'); ?>">Employee Status</a>
                        </li>
                        <li>
                            <a href="<?= base_url('gender'); ?>">Gender</a>
                        </li>
                        <li>
                            <a href="<?= base_url('hardware_brand'); ?>">Hardware Brand</a>
                        </li>
                        <li>
                            <a href="<?= base_url('hardware_category'); ?>">Hardware Category</a>
                        </li>
                        <li>
                            <a href="<?= base_url('inventory_category'); ?>">Inventory Category</a>
                        </li>
                        <li>
                            <a href="<?= base_url('inventoryitem'); ?>">Inventory Item</a>
                        </li>
                        <li>
                            <a href="<?= base_url('marriage_status'); ?>">Marriage Status</a>
                        </li>
                        <li>
                            <a href="<?= base_url('plant'); ?>">Plant</a>
                        </li>
                        <li>
                            <a href="<?= base_url('position'); ?>">Position</a>
                        </li>
                        <li>
                            <a href="<?= base_url('tax_status'); ?>">Tax Status</a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php if (in_groups('superadmin')) : ?>
                <li class="side-nav-title">Setting</li>

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#accountmanagement" aria-expanded="false" aria-controls="accountmanagement" class="side-nav-link">
                        <i class="uil-user-square"></i>
                        <span> Account Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="accountmanagement">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url('register'); ?>">Register</a>
                            </li>
                            <li>
                                <a href="<?= base_url('account'); ?>">Data Account</a>
                            </li>
                            <li>
                                <a href="<?= url_to('forgot'); ?>">Reset Password</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#AuthGroups" aria-expanded="false" aria-controls="AuthGroups" class="side-nav-link">
                        <i class="uil-user-square"></i>
                        <span> Auth Groups </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="AuthGroups">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="<?= base_url('auth_groups'); ?>">Data</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->