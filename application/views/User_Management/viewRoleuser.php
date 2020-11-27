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
                        
                        $userInfo = $this->user->getRows(array('id'=>$userData['created_by']));

                        ?>
                        <input type="hidden" name="" id="customerId" value="<?= $userData['id']; ?>">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url() ?>">
                        <div class="row">
                            <div class="col-lg-4"><h3><b><?php echo $page_name ?></b></h3></div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"><a href="<?= base_url() ?>Ct_dashboard/editUser/<?= $userData['id'] ?>" class="btn btn-primary btn-sm float-right">Edit</a></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-info">
                                    Active Service Requests <?php print_r(User_Status_Wise_Service_Request($userData['id'],"2","technician")); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><h6><?= $page_name ?> Name <b><?= $userData['name']; ?></b></h6></div>
                            <div class="col-lg-4 text-left">ID: <b><?=$userData['ref_id']; ?></b></div>
                        </div>
                        <div class="row">
                            &nbsp;
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><i class="mdi mdi-phone"></i> Contact Number <b>+91 <?=$userData['mobile']; ?></b></div>
                            <?php
                                 ?>
                            <div class="col-lg-4"><i class="mdi mdi-phone"></i> Alternate Contact Number <b>+91 <?=$userData['alt_mobile']; 
                            ?></b></div>
                        <?php  ?>
                        </div>
                        <div class="row">
                            &nbsp;
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><i class="mdi mdi-email"></i> Email ID <b><?=$userData['email'] ?></b></div>
                        </div>
                        <div class="row">
                            &nbsp;
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><i class="mdi mdi-location"></i> Address <b><?=$userData['address'] ?></b></div>
                        </div>
                        <div class="row">
                            <hr>
                        </div>

                         <div class="row">
                            <div class="col-lg-4"><b>Created By : </b> <?= isset($userInfo['name']) ? $userInfo['name'] : "" ?></div>
                            <div class="col-lg-8"><b>Created Date : </b> <b><?= date('d/m/Y', strtotime($userData['added_on'])) ?></b></div>
                        </div>   

                        <div class="row">
                            &nbsp;<br><hr>
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <h5><b>Latest Service Requests</b></h5>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    
                                        
                                        

                                        
                                        
                                        
                                        

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 LoadTable">
                                
                            </div>
                        </div> 

                    </div>
                </div>
            </div>
            <!-- end col -->
            <!--            </div>            -->
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
<script type="text/javascript">
    $("#datatable-buttons1").dataTable({
        "searching": false,
        "bLengthChange": false,
        "bInfo": false,
    });
</script>