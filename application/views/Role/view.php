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
            <div class="col-8">
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
                                    <th>Role Name</th>
                                    <th>Report To</th>
                                    <?php if($role_id == 1 || in_array($active_menu."_P_3", $permission) || in_array($active_menu."_P_4", $permission)){ ?>
                                    <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($roleList as $i => $role) {
                                    $reportingTo = $this->role->roleList($role['role_reporting_to'],1);
                                    ?>
                                    <tr>
                                        <td><?= ($i + 1) ?></td>
                                        
                                        <td><a href="<?= base_url() ?>Ct_role/?rid=<?= $role['role_id'] ?>"><?= $role['role_name'] ?></a></td>
                                        <td><?= $reportingTo[0]['role_name'] ?></td>
                                        <?php if($role_id == 1 || in_array($active_menu."_P_3", $permission) || in_array($active_menu."_P_4", $permission)){ ?>
                                        <td>
                                           <?php
                                           /* _P_3 For Edit Permission */
                                           /* _P_4 For Delete Permission */
                                           if($role_id == 1 || in_array($active_menu."_P_3", $permission)){
                                               ?>
                                                <a href="<?= base_url() ?>Ct_role/edit/<?= $role['role_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                           <?php } ?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $id = 3;
                        if(isset($_GET['rid']) && $_GET['rid'] != ""){
                            $id = $_GET['rid'];
                        }
                        $roleData = $this->role->roleList($id);
                        ?>
                        <h5 class="bg-light p-3"><?=  isset($roleData[0]['role_name']) ? $roleData[0]['role_name'] : "" ?></h5>
                        <div id="tree"></div>
                        <input type="hidden" name="" id="roleId">
                        <div class="text-center mt-2">
                            <button id="btnSave" class="btn btn-primary btn-sm">Save Checked Permission</button>
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