<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>HRMS - Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="<?= base_url(); ?>assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="<?= base_url(); ?>assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg">

    <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns='http://www.w3.org/2000/svg' width='100%' height='100%' viewBox='0 0 800 800'>
            <g fill-opacity='0.22'>
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.1);" cx='400' cy='400' r='600' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.2);" cx='400' cy='400' r='500' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.3);" cx='400' cy='400' r='300' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.4);" cx='400' cy='400' r='200' />
                <circle style="fill: rgba(var(--ct-primary-rgb), 0.5);" cx='400' cy='400' r='100' />
            </g>
        </svg>
    </div>

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5 col-sm-12">
                    <div class="card">
                        <!-- Logo-->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="<?= base_url(); ?>">
                                <span><img src="<?= base_url(); ?>assets/images/logo.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold"><?= lang('Auth.register') ?></h4>
                            </div>

                            <?= view('Myth\Auth\Views\_message_block') ?>

                            <form action="<?= url_to('register') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="mb-2">
                                    <label for="username" class="form-label"><?= lang('Auth.username') ?></label>
                                    <input class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" type="text" id="username" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                                </div>

                                <div class="mb-2">
                                    <label for="emailaddress" class="form-label"><?= lang('Auth.email') ?></label>
                                    <input class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" type="email" id="emailaddress" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                                    <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                                </div>

                                <div class="mb-2">
                                    <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="password" id="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="pass_confirm" class="form-label"><?= lang('Auth.repeatPassword') ?></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="pass_confirm" id="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary" type="submit"> <?= lang('Auth.register') ?> </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-xl-12 col-lg-12 col-sm-12 text-center">
                            <p class="text-muted"><?= lang('Auth.alreadyRegistered') ?> <a href="<?= url_to('login') ?>" class="text-muted ms-1"><b><?= lang('Auth.signIn') ?></b></a></p>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        <script>
            document.write(new Date().getFullYear())
        </script> © HRMS - Namicoh
    </footer>

    <!-- Vendor js -->
    <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>