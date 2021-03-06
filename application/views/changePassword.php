
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> Reset Password </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url() ?>app-assets/images/favicon.ico">

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
                                    <p class="text-white-50 mb-0">Reset Password.</p>
                                    <a href="javascript:void(0);" class="logo logo-admin mt-4">
                                        <img src="<?= base_url() ?>app-assets/images/group_780.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="p-2">
                                    <form class="form-horizontal" method="post" action="<?= base_url() ?>Ct_dashboard/resetPassword">
                                        <input type="hidden" name="userId" value="<?=$userData['id']?>">
                                        <?php
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
                                            <label for="username">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Submit</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <a href="<?php echo base_url() ?>" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Login?</a>
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
        <script src="<?= base_url() ?>app-assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/metisMenu.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/simplebar.min.js"></script>
        <script src="<?= base_url() ?>app-assets/js/waves.min.js"></script>

        <script src="<?= base_url() ?>app-assets/js/app.js"></script>

    </body>

</html>