<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s&libraries=places,geometry"></script>
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
                        <form method="post" id="createRoleUser" enctype="multipart/form-data">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span></span>
                            </div>

                            <div class="alert alert-danger alert-dismissible errormsg" style="display: none;">
                                          
                                </div>
                                <div class="alert alert-success alert-dismissible" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    
                                </div>
                            <input type="hidden" name="" id="baseUrl" value="<?= base_url() ?>">
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
                                <div class="col-lg-12">
                                    <div class="form-group mb-4">
                                        <img id="blah" alt="your image" src="<?= base_url() ?>app-assets/images/default-user.png" width="80" height="80" />
                                        <input type="file" name="userImg" id="userImg" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" maxlength="75">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" tabindex="1" name="name" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="role">Assign Role</label>
                                        <select id="role" name="role" tabindex="2" class="form-control">
                                            <option value=""> --- Select Role --- </option>
                                            <?php
                                            foreach ($roleList as $i => $val) {
                                                ?>
                                                <option value="<?= $val['role_id'] ?>"><?= $val['role_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">User Status</label>
                                    <div class="form-group mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="userStatus" onchange="checkUserStatus(this);" name="userStatus">
                                            <label class="form-check-label" id="userStatusLabel" for="userStatus">
                                                Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" tabindex="1" name="email" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="mobile">Contact Number</label>
                                        <input type="text" id="mobile" tabindex="1" maxlength="10" name="mobile" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="name">Alternate Contact Number</label>
                                        <input type="text" id="alt_mobile" tabindex="1" name="alt_mobile" maxlength="10" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-12"><label><b>Address</b></label></div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="address">Address Line</label>
                                        <input type="text" id="address" onblur="getLatLang();" tabindex="1" name="address" class="form-control input-mask">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="langitude" id="langitude">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="state">Region</label>
                                        <select class="form-control" id="state" name="state" onchange="getCity();">
                                            <option value="">Select Region</option>
                                            <?php
                                            foreach ($state as $i => $val) {
                                                ?>
                                                <option value="<?= $val['st_id'] ?>"><?= $val['st_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="address">City</label>
                                        <select class="form-control" id="city" name="city">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="address">Zipcode</label>
                                        <input type="zipcode" id="zipcode" tabindex="1" name="zipcode" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="country">Country</label>
                                        <input type="text" id="country" tabindex="1" name="country" value="India" class="form-control input-mask">
                                    </div>
                                </div>

                                <div class="col-lg-12 text-right">
                                   <a href="<?= base_url() ?>Ct_userManagement/userView/6" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <input type="submit" class="btn btn-primary ml-2"  value="Submit">
                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <!-- End Page-content -->
</div>
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
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>