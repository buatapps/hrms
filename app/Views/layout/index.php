<!DOCTYPE html>
<html lang="en">
<?= $this->include('layout/header'); ?>

<body>

    <!-- Begin page -->
    <div class="wrapper">
        <?= $this->include('layout/topbar'); ?>
        <?php
        $sidebars = [
            'superadmin'    => 'leftsidebar',
            'admin-hr'      => 'leftsidebaradminhr',
            'admin-ga'      => 'leftsidebaradminga',
            'admin-ga-it'   => 'leftsidebaradmingait',
            'admin'         => 'leftsidebaradmin',
            'Japan'         => 'leftsidebarjapan',
            'assisten-manager' => 'leftsidebarassistenmanager',
            'senior-manager' => 'leftsidebarseniormanager',
        ];

        // ambil sidebar pertama yang cocok dengan role user
        $sidebarToInclude = '';
        foreach ($sidebars as $group => $sidebar) {
            if (in_groups($group)) {
                $sidebarToInclude = $sidebar;
                break;
            }
        }

        // include sidebar
        if ($sidebarToInclude) {
            echo $this->include("layout/$sidebarToInclude");
        }
        ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <?= $this->renderSection('content'); ?>

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © HRMS - Namicoh
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->


    <?= $this->include('layout/footerscript'); ?>

</body>

</html>