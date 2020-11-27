<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> Login </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url() ?>app-assets/images/favicon.png">

        <!-- Bootstrap Css -->
        <link href="<?= base_url() ?>app-assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?= base_url() ?>app-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?= base_url() ?>app-assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Custome Css-->
        <link href="<?= base_url() ?>app-assets/css/style.css" id="app-style" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-login text-center">
                                <div class="bg-login-overlay"></div>
                                <div class="position-relative">
                                    <h5 class="text-white font-size-20">Welcome !</h5>
                                    <p class="text-white-50 mb-0">Login to continue to FundooMoms.</p>
                                    <a href="<?= base_url() ?>" class="logo logo-admin mt-4">
                                        <img src="<?= base_url() ?>app-assets/images/group_780.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="p-2">
                                    <form class="form-horizontal" method="post" action="<?= base_url() ?>Ct_dashboard/login">
                                        <?php
                                        /* Alert Message */
                                        if ($this->session->flashdata('success')) {
                                            ?>
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <?= $this->session->flashdata('success') ?>
                                            </div>
                                            <?php } elseif ($this->session->flashdata('warning')) { ?>
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <?= $this->session->flashdata('warning') ?>
                                            </div>
                                            <?php } elseif ($this->session->flashdata('error')) { ?>
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <?= $this->session->flashdata('error') ?>
                                            </div>
                                            <?php } ?>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php if(isset($_COOKIE['YORKUSEREMAIL'])){ echo $_COOKIE['YORKUSEREMAIL']; } ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password" value="<?php if(isset($_COOKIE['YORKUSERPASS'])){ echo $_COOKIE['YORKUSERPASS']; } ?>">
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input" name="remember" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <a href="<?= base_url() ?>Ct_dashboard/ForgotPassword" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">
<!--                            <p>Don't have an account ? <a href="pages-register.html" class="font-weight-medium text-primary"> Signup now </a> </p>-->
                            <p>Copyright © 2020 FundooMoms. All Rights Reserved.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
<!--        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>-->
        <script src="<?= base_url() ?>app-assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/metisMenu.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/simplebar.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/waves.min.js"></script>

        <script src="<?= base_url() ?>app-assets/js/app.js"></script>

    </body>

</html>