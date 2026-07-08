<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>HRMS - Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php base_url(); ?>assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="<?php base_url(); ?>assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="<?php base_url(); ?>assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="<?php base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="<?php base_url(); ?>" class="logo-dark">
                        <span><img src="<?php base_url(); ?>assets/images/logo-dark.png" alt="dark logo" height="40"></span>
                    </a>
                    <a href="<?php base_url(); ?>" class="logo-light">
                        <span><img src="<?php base_url(); ?>assets/images/logo.png" alt="logo" height="22"></span>
                    </a>
                </div>

                <?= view('Myth\Auth\Views\_message_block') ?>

                <div class="my-auto">
                    <!-- title-->
                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access account.</p>

                    <!-- form -->
                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <?php if ($config->validFields === ['email']): ?>
                            <div class="mb-3">
                                <label for="login" class="form-label"><?= lang('Auth.email') ?></label>
                                <input class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" type="email" id="login" required="" name="login" placeholder="<?= lang('Auth.email') ?>" autofocus>
                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <label for="login" class="form-label"><?= lang('Auth.emailOrUsername') ?></label>
                                <input class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" type="text" id="login" required="" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>" autofocus>
                                <div class="invalid-feedback">
                                    <?= session('errors.login') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <?php if ($config->activeResetter): ?>
                                <a href="<?= url_to('forgot') ?>" class="text-muted float-end"><small><?= lang('Auth.forgotYourPassword') ?></small></a>
                            <?php endif; ?>
                            <label for="password" class="form-label"><?= lang('Auth.password') ?></label>
                            <input class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" type="password" required="" id="password" name="password" placeholder="<?= lang('Auth.password') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        </div>
                        <?php if ($config->allowRemembering): ?>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?> id="checkbox-signin">
                                    <label class="form-check-label" for="checkbox-signin"><?= lang('Auth.rememberMe') ?></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> <?= lang('Auth.loginAction') ?></button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <?php if ($config->allowRegistration) : ?>
                    <footer class="footer footer-alt">
                        <p class="text-muted"><a href="<?= url_to('register') ?>" class="text-muted ms-1"><b><?= lang('Auth.needAnAccount') ?></b></a></p>
                    </footer>
                <?php endif; ?>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Company Slogan!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent. I love it very much! . <i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Namicoh Indonesia Component
                </p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->
    <!-- Vendor js -->
    <script src="<?php base_url(); ?>assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php base_url(); ?>assets/js/app.min.js"></script>

</body>

</html>