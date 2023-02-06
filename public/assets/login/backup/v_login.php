<!doctype html>
<html lang="en">

<head>
    <title>Sistem Login</title>

    <link rel="icon" href="<?php echo base_url() . '/assets/img/favicon.ico' ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/login'); ?>/css/style.css">

</head>

<body>
    <section class="ftco-section" style="background: #24406d;">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(<?= base_url('assets/login'); ?>/images/itp-background.jpg);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                            <?php endif ?>
                            <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('success'); ?></div>
                            <?php endif ?>
                            <div class="d-flex">
                                <div class="w-100">
                                    <h2 class="heading-section">ITP</h2>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="https://www.instagram.com/itppadang/" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-instagram"></span></a>
                                        <a href="https://www.facebook.com/itppadang" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                    </p>
                                </div>
                            </div>
                            <form action="<?= route_to('auth.login'); ?>" method="POST" class="signin-form" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="form-group mt-3">
                                    <input type="text" name="Username" class="form-control" required>
                                    <label class="form-control-placeholder" for="username">Username</label>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" name="Password" class="form-control" required>
                                    <label class="form-control-placeholder" for="password">Password</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="#">Forgot Password</a>
                                    </div>
                                </div>
                            </form>
                            <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url('assets/login'); ?>/js/jquery.min.js"></script>
    <script src="<?= base_url('assets/login'); ?>/js/popper.js"></script>
    <script src="<?= base_url('assets/login'); ?>/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/login'); ?>/js/main.js"></script>

</body>

</html>