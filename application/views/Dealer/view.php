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
                    if($role_id == 1 || in_array($active_menu."_P_1", $permission)){ ?>
                    <div class="page-title-right">
                        <a href="<?= base_url() ?>Ct_dealer/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Dealer
                        </a>
                    </div>
                    <?php }else{
                        echo $breadCrumb;
                    } ?>

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
                                    
                                    <th>ID</th>
                                    <th>Dealer Name</th>
                                    <th>Contact Number</th>
                                    <th>Region</th>
                                    <th>Open-Close Time</th>
                                    <?php if($role_id == 1 || in_array($active_menu."_P_3", $permission) || in_array($active_menu."_P_4", $permission)){ ?>
                                    <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($serviceCenter as $i => $serviceCenterData) {
                                    $state = $this->user->states($serviceCenterData['dl_state']);
                                    $current_time = date('H:i');
                                    $sunrise = $serviceCenterData['dl_open_time'];
                                    $sunset = $serviceCenterData['dl_close_time'];
                                    $date1 = DateTime::createFromFormat('H:i', $current_time);
                                    $date2 = DateTime::createFromFormat('H:i', $sunrise);
                                    $date3 = DateTime::createFromFormat('H:i', $sunset);
                                    
                                    $dateView = "";
                                    if ($date1 > $date2 && $date1 < $date3){
                                        $dateView = '<b>Open</b> Closes '.$serviceCenterData['dl_close_time'];
                                    }else{
                                         $dateView = '<b>Close</b> Open '.$serviceCenterData['dl_open_time'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?= ($i + 1) ?></td>
                                        
                                        <td><a href="<?=base_url()?>Ct_dealer/serviceView/<?=$serviceCenterData['dl_id']?>"><?=$serviceCenterData['dl_reference']?></a></td>
                                        <td><?= $serviceCenterData['dl_name'] ?></td>
                                        <td><?= $serviceCenterData['dl_contact'] ?></td>
                                        <td><?= isset($state[0]['st_name']) ? $state[0]['st_name'] : "" ?></td>
                                        <td><?= $dateView ?></td>
                                        <?php if($role_id == 1 || in_array($active_menu."_P_3", $permission) || in_array($active_menu."_P_4", $permission)){ ?>
                                        <td>
                                           <?php
                                           /* _P_3 For Edit Permission */
                                           /* _P_4 For Delete Permission */
                                           if($role_id == 1 || in_array($active_menu."_P_3", $permission)){
                                               ?>
                                                <a href="<?= base_url() ?>Ct_dealer/editService/<?= $serviceCenterData['dl_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                           <?php }
                                           if($role_id == 1 || in_array($active_menu."_P_4", $permission)){
                                               ?>
                                                <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteDealer(<?= $serviceCenterData['dl_id'] ?>);">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                           <?php } ?>
                                        </td>
                                    <?php } ?>
<!--                                        <td><a href="<?= base_url() ?>Ct_dealer/editService/<?= $serviceCenterData['dl_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteDealer(<?= $serviceCenterData['dl_id'] ?>);">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        </td>-->
    <!--                                            <td>
                                            
                                            
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