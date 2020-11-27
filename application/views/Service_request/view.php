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
                        <a href="<?= base_url() ?>Ct_service_request/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Service Request
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
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url() ?>">
                        <?php
                            if($_SESSION['LoginUserData']['is_admin']=="1"){
                                $all = $this->Service_request->GetAllService('all',"","1");
                                $new = $this->Service_request->GetAllService('1',"","1");
                                $inpr = $this->Service_request->GetAllService('2',"","1");
                                $comp = $this->Service_request->GetAllService('3',"","1");
                            }else{
                                $all = $this->Service_request->GetAllService("all",$_SESSION['LoginUserData']['city'],"0");
                                $new = $this->Service_request->GetAllService("1",$_SESSION['LoginUserData']['city'],"0");
                                $inpr = $this->Service_request->GetAllService("2",$_SESSION['LoginUserData']['city'],"0");
                                $comp = $this->Service_request->GetAllService("3",$_SESSION['LoginUserData']['city'],"0");
                            }
                        ?>
                            <div class="alert alert-dark alert-dismissible">
                                <div class="row">
                                    <div class="col-md-4">
                                       <b><?= $all ?></b> Total Requests
                                    </div>
                                    <div class="col-md-2">
                                       <b><?= $new ?></b> New Requests
                                    </div>
                                    <div class="col-md-2">
                                       <b><?= $inpr ?></b> in Process
                                    </div>
                                    <div class="col-md-2">
                                       <b><?= $comp ?></b> Completed
                                    </div>
                                    <div class="col-md-2">
                                        Cancelled
                                    </div>
                                </div>    
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
                        <div class="LoadTable">
                        <!-- <table id="datatable-buttons1" class="table table-striped table-bordered  nowrap data1">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    
                                    <th>ID</th>
                                    <th>Vehicle Location</th>
                                    <th>Trailer Type</th>
                                    <th>Service Request Type</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Assign To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i=1;
                                foreach ($serviceReqlist as $j => $serviceData) {
                                 $trailer = $this->Service_request->GetTrailerData($serviceData['trailer_type'])->tt_name; 
                                 $defect =  $this->Service_request->GetDefectData($serviceData['defect_detail'])->dd_name; 
                                 $status =  $this->Service_request->GetServicestatusData($serviceData['s_status'])->stext;
                                 $state = $this->Service_request->GetCityData($serviceData['region'])->ct_name;
                                  
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><u><a  href="<?= base_url() ?>Ct_service_request/AssignService/<?= $serviceData['ser_id']; ?>"><?= $serviceData['ref_id']; ?></a></u></td>
                                    <td><?= $serviceData['vehicle_location']; ?></td>
                                    <td><?= $trailer; ?></td>
                                    <td><?= $defect; ?></td>
                                    <td><?= $state; ?></td>
                                    <td><label style="cursor: pointer;" onclick="window.location.href='<?= base_url() ?>Ct_service_request/AssignService/<?= $serviceData['ser_id']; ?>'" class="badge badge-info"><?= $status; ?></label></td>
                                    <td><?php echo date("d/m/Y",strtotime($serviceData['created_date'])); ?></td>
                                    <td><?php 
                                    if(!empty($serviceData['technician'])){
                                        $techData = $this->user->getRows(array("id"=>$serviceData['technician']));
                                     if(count($techData)>0){ 
                                        echo $techData['name']; 
                                     }else{ 
                                        echo "-";
                                     }
                                    }else{
                                        
                                        echo "-";
                                    }
                                     ?>
                                         
                                     </td>
                                    <td>
                                        <?php if($_SESSION['LoginUserData']['is_admin']=="1"){ ?>
                                        <a href="<?= base_url() ?>Ct_service_request/edit/<?= $serviceData['ser_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteService('<?= $serviceData['ser_id']; ?>');">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        <?php } ?>    
                                    </td>
                                </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                
                            </tfoot>
                        </table> -->

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
<script type="text/javascript">
    $("#datatable-buttons1").dataTable({
        initComplete: function () {
            
            var sel = '<b style="float:left;">Status&nbsp;&nbsp;</b><select class="ss_status custom-select custom-select-sm" style="float:left; width: auto;">';
            sel +='<option value="all">All</option>';
            sel +='<option value="1">New</option>';
            sel +='<option value="2">In Process</option>';
            sel +='<option value="3">Completed</option>';
            sel +='<option value="4">Cancelled</option>';
            sel +='</select>';
            $("#datatable-buttons1_filter").append(sel)
        }
    });


</script>