<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $page_name ?></h4>

                    <div class="page-title-right">
                        <a href="<?= base_url() ?>Ct_service_center/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Service Center
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <!--            <div class="row">-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                        $current_time = date('h:i A');
                        $sunrise = $serviceCenter[0]['sc_open_time'];
                        $sunset = $serviceCenter[0]['sc_close_time'];
                        $date1 = DateTime::createFromFormat('H:i A', $current_time);
                        $date2 = DateTime::createFromFormat('H:i A', $sunrise);
                        $date3 = DateTime::createFromFormat('H:i A', $sunset);
                        $dateView = "";
                        if ($date1 > $date2 && $date1 < $date3) {
                            $dateView = '<b>Open</b> Closes ' . $serviceCenter[0]['sc_close_time'];
                        } else {
                            $dateView = '<b>Close</b> Open ' . $serviceCenter[0]['sc_open_time'];
                        }
                        $userInfo = $this->user->getRows(array('id'=>$serviceCenter[0]['sc_created_by']));
                        ?>
                        <div class="row">
                            <div class="col-lg-4"><h5><b><?= $serviceCenter[0]['sc_name'] ?></b></h5></div>
                            <div class="col-lg-4">ID: <b><?= $serviceCenter[0]['sc_ref'] ?></b></div>
                            <div class="col-lg-4"><a href="<?= base_url() ?>Ct_service_center/editService/<?= $serviceCenter[0]['sc_id'] ?>" class="btn btn-primary btn-sm float-right">Edit</a></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><p><?= $dateView ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><p><i class="mdi mdi-map-marker"></i> <?= $serviceCenter[0]['sc_location'] ?></p></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><p><i class="mdi mdi-phone"></i> +91 <?= $serviceCenter[0]['sc_contact'] ?></p><hr></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><b>Created By : </b> <?= isset($userInfo['name']) ? $userInfo['name'] : "" ?></div>
                            <div class="col-lg-8"><b>Created Date : </b> <?= date('d/m/Y', strtotime($serviceCenter[0]['created_date'])) ?></div>
                        </div>

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