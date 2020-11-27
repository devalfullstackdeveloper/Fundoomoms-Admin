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

                    <?php
                    /*_P_1 For Create*/
                    /*_P_6 For Preview*/
                    if($role_id == 1 || in_array($active_menu."_P_1", $permission) || in_array($active_menu."_P_6", $permission)){
                        ?>
                    <div class="page-title-right">
                    <?php
                       if($role_id == 1 || in_array($active_menu."_P_1", $permission)){
                           ?>
                            <a href="<?= base_url() ?>Ct_banner/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                                <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Banner
                            </a>
                           <?php
                       }
                       if($role_id == 1 || in_array($active_menu."_P_6", $permission)){
                           ?>
                            <a href="<?= base_url() ?>Ct_banner/ViewBannerInMobile" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                                <i class="bx bx-mobile font-size-16 align-middle mr-2 font-weight-bold"></i> Mobile Preview
                            </a>
                           <?php
                       }
                       ?>
                        </div>
                        <?php
                    }else{
                        echo $breadCrumb;
                    }
                    ?>
                    

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
                        <?php } ?>
                        <table id="datatable-buttons" class="table table-striped table-bordered  nowrap">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    
                                    <th>Banner Image</th>
                                    <th>Title</th>
                                    <th>Position</th>
                                    <th>Created Date</th>
                                    <?php if($role_id == 1 || in_array($active_menu."_P_3", $permission) || in_array($active_menu."_P_4", $permission)){ ?>
                                    <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($bannerList as $i => $bannerData) {
                                    ?>
                                    <tr>
                                        <td><?= ($i + 1) ?></td>
                                        
                                        <td>
                                            <img src="<?= base_url() . $bannerData['mb_img'] ?>" width="200" height="100">
                                        </td>
                                        <td><?= $bannerData['mb_title'] ?></td>
                                        <td><?= $bannerData['mb_position'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($bannerData['mb_created_on'])) ?></td>
                                        <?php if($role_id == 1 || in_array($active_menu."_P_3", $permission) || in_array($active_menu."_P_4", $permission)){ ?>
                                        <td>
                                           <?php
                                           /* _P_3 For Edit Permission */
                                           /* _P_4 For Delete Permission */
                                           if($role_id == 1 || in_array($active_menu."_P_3", $permission)){
                                               ?>
                                                <a href="<?= base_url() ?>Ct_banner/editBanner/<?= $bannerData['mb_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                           <?php }
                                           if($role_id == 1 || in_array($active_menu."_P_4", $permission)){
                                               ?>
                                                <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteBanner(<?= $bannerData['mb_id'] ?>);">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>    
                                           <?php } ?>
                                        </td>
                                        <?php } ?>
    <!--                                            <td>
                                            
                                            <button class="btn btn-danger btn-sm ml-2" onclick="deleteUser(<?= $userData['id'] ?>);">Delete</button>
                                                                                            <button type="button" class="btn btn-danger btn-sm ml-2 waves-effect waves-light" id="sa-warning">Click me</button>
                                        </td>-->
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
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