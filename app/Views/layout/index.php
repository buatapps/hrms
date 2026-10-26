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

    <!-- Global Loading Overlay -->
    <div id="globalLoadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div style="text-align: center;">
            <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                <span class="sr-only">Loading...</span>
            </div>
            <div style="color: white; margin-top: 15px; font-size: 16px;">Sedang memuat data...</div>
        </div>
    </div>

    <script>
        // Function to show loading
        function showLoading() {
            const overlay = document.getElementById('globalLoadingOverlay');
            if (overlay) {
                overlay.style.display = 'flex';
            }
        }

        // Function to hide loading
        function hideLoading() {
            const overlay = document.getElementById('globalLoadingOverlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        // Show loading on page load/reload
        window.addEventListener('beforeunload', function() {
            showLoading();
        });

        // Show loading on form submit
        document.addEventListener('submit', function(e) {
            // Check if form has a specific class to skip loading
            if (!e.target.classList.contains('no-loading')) {
                showLoading();
            }
        });

        // Show loading on button click (for buttons with specific class)
        document.addEventListener('click', function(e) {
            // Target buttons with data-loading attribute
            if (e.target.hasAttribute('data-loading') || 
                e.target.closest('[data-loading]') ||
                e.target.type === 'submit') {
                showLoading();
            }
        });

        // Hide loading when page fully loaded
        window.addEventListener('load', function() {
            hideLoading();
        });

        // Hide loading if there's an error
        window.addEventListener('error', function() {
            hideLoading();
        });

        // For AJAX requests (if using jQuery)
        if (typeof jQuery !== 'undefined') {
            $(document).ajaxStart(function() {
                showLoading();
            });
            $(document).ajaxStop(function() {
                hideLoading();
            });
            $(document).ajaxError(function() {
                hideLoading();
            });
        }

        // For fetch API
        const originalFetch = window.fetch;
        window.fetch = function() {
            showLoading();
            return originalFetch.apply(this, arguments).finally(function() {
                hideLoading();
            });
        };
    </script>


    <?= $this->include('layout/footerscript'); ?>

</body>

</html>