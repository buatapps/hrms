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
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarDashboardAbsensi" aria-expanded="false" aria-controls="sidebarDashboardAbsensi">
                                <span> Dashboard Absensi </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarDashboardAbsensi">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('dashboard'); ?>">Employee Late</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('dashboard/absent'); ?>">Employee Absent</a>
                                    </li>
                                </ul>
                            </div>
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
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarOverTime" aria-expanded="false" aria-controls="sidebarOverTime">
                                <span> Overtime </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarOverTime">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="<?= base_url('overtime/form'); ?>">Form</a>
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
                                        <a href="<?= base_url('attendance/report_user'); ?>">Report per User</a>
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
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->