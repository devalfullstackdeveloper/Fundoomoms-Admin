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

                        <a href="<?= base_url() ?>Ct_userManagement/createRoleUser" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create User
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">
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
                        <table id="datatable-buttons" class="table table-borderless nowrap">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Region</th>
                                    <th>User Status</th>
                                    <th>Create Date</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                foreach ($userlist as $i => $userData) {
                                    if($j<=9){ $cnt = "0".$j; }else{ $cnt = $j; }
                                    if($userData['status']=="1"){ $color="green"; $status="Active"; }else{ $color=""; $status="inActive"; }
                                    $region = $this->user->cities($userData['state'],$userData['city']);
                                    ?>
                                    <tr>
                                        <td><?= $cnt; ?></td>
                                        <td><a href="<?= base_url() ?>Ct_userManagement/RoleUserView/<?= $userData['id']; ?>"><?= $userData['ref_id']; ?></a></td>
                                        <td><?= $userData['name']; ?></td>
                                        <td><?= $userData['mobile']; ?></td>
                                        <td><?= $userData['email']; ?></td>
                                        <td><?= $region[0]['ct_name']; ?></td>
                                        <td align="center"><b style="color:<?= $color; ?> "><?= $status; ?></b></td>
                                        <td><?= date("d/m/Y",strtotime($userData['added_on'])); ?></td>
                                        <td>
                                             <a href="<?= base_url() ?>Ct_userManagement/EditUserRole/<?= $userData['id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteRoleUser('<?= $userData['id']; ?>')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        </td>
                                    </tr>
                                    <?php
                                    $j++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                        
                                    </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
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
