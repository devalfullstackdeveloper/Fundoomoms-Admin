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
                        <?= $breadCrumb ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!--                        <h4 class="card-title mb-4">Example</h4>-->
                        <form method="post" id="editPackage" action="<?= base_url() ?>Ct_class/addpackage"  enctype="multipart/form-data">
                            <input type="hidden" name="packageid" id="packageid" value="<?= $packageData['package_id'] ?>">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg errormsgBtn hideAll" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="errormsg"></span>
                            </div>
                            <div class="alert alert-success alert-dismissible successBtn hideAll" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <span class="sucmsg"></span>
                            </div>
                            <div class="alert alert-warning alert-dismissible warningBtn hideAll" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                     <span class="warningmsg"></span>
                                </div>
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Package Title</label>
                                            <input type="text" name="ptitle" id="ptitle" class="form-control" placeholder="Package Title" maxlength="35" value="<?= $packageData['ptitle'] ?>">
                                        </div>
                                        <div class="form-group mb-4 freeDays" style="<?php if($packageData['type']=='free'){ ?> display: block; <?php }else{ ?> display: none; <?php } ?>">
                                                <label for="descr">Free Days</label>
                                               <input type="text" name="pdays" id="pdays" class="form-control" maxlength="3" placeholder="Days of Free Package" value="<?= $packageData['days'] ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">
                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Package Type</label>
                                            <select class="form-control" name="ptype" id="ptype">
                                                <option value="">--SELECT--</option>
                                                <option value="free" <?php if($packageData['type']=='free') echo "selected"; ?>>Free</option>
                                                <option value="premium" <?php if($packageData['type']=='premium') echo "selected"; ?>>Premium</option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                                <div class="col-lg-12 text-right">
                                    <a href="<?= base_url() ?>Ct_class/index" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <input type="submit" class="btn btn-primary ml-2 btn1 " value="Submit">
                                    <button type="button" class="btn btn-primary ml-2 btn2 hideAll" style="display: none;">
                                        Please Wait...
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
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
<script type="text/javascript">
     $(".select2").select2();
</script>