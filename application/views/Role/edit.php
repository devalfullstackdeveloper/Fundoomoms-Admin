<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>


<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $page_name ?></h4>
                    <?= $breadCrumb ?>
                    <!--                    <div class="page-title-right">
                                            <a href="<?= base_url() ?>Ct_banner/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                                                <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Banner
                                            </a>
                                        </div>-->

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <!--            <div class="row">-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" id="editRole" action="<?= base_url() ?>Ct_role/edit/<?= $roleData[0]['role_id'] ?>"  enctype="multipart/form-data">
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
                                <?php
                            }
                            ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="bannerTitle">Role Name</label>
                                        <input type="text" id="role_name" value="<?= $roleData[0]['role_name'] ?>" tabindex="1" name="role_name" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="bannerTitle">Reporting To</label>
                                        <select name="reporting_to" id="reporting_to" class="form-control">
                                            <option value="">Select Reporting To</option>
                                            <?php
                                            foreach ($roleList as $key => $value) {
                                                if ($value['role_id'] != $roleData[0]['role_id']) {
                                                    ?>
                                                    <option value="<?= $value['role_id'] ?>" <?= $value['role_id'] == $roleData[0]['role_reporting_to'] ? 'selected' : '' ?>><?= $value['role_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <a href="<?= base_url() ?>Ct_role/index" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <input type="button" class="btn btn-primary ml-2" onclick="roleSubmit();" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- end col -->
            <!--            </div>            -->
        </div>
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
<!--                                    <script>document.write(new Date().getFullYear())</script> © Qovex.-->
                </div>
                <div class="col-sm-10">
                    <div class="text-sm-right d-none d-sm-block">
                        Copyright © <script>document.write(new Date().getFullYear())</script> York Transport Equipment (Asia) Pte Ltd. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>