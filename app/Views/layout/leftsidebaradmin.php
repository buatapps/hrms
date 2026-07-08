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
                            <a href="<?= base_url('employee/employee_division/' . user()->division_id); ?>">Data Employee</a>
                        </li>
                        <li>
                            <a href="<?= base_url('overtimes'); ?>">Overtimes</a>
                        </li>
                        <!-- <li>
                            <a href="<?= base_url('contract'); ?>">Contract</a>
                        </li>
                        <li>
                            <a href="<?= base_url('employee/schedule'); ?>">Schedule</a>
                        </li> -->

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
                    </ul>
                </div>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->