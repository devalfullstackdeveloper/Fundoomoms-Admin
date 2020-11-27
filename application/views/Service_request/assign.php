<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
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
                        <!-- <a href="<?= base_url() ?>Ct_service_center/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Dealer Information
                        </a> -->
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <!--            <div class="row">-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="" id="serId" value="<?php echo $ServiceData->ser_id; ?>">
                        <input type="hidden" name="" id="base_url" value="<?= base_url(); ?>">
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
                        // $current_time = date('h:i A');
                        // $sunrise = $serviceCenter[0]['sc_open_time'];
                        // $sunset = $serviceCenter[0]['sc_close_time'];
                        // $date1 = DateTime::createFromFormat('H:i A', $current_time);
                        // $date2 = DateTime::createFromFormat('H:i A', $sunrise);
                        // $date3 = DateTime::createFromFormat('H:i A', $sunset);
                        // $dateView = "";
                        // if ($date1 > $date2 && $date1 < $date3) {
                        //     $dateView = '<b>Open</b> Closes ' . $serviceCenter[0]['sc_close_time'];
                        // } else {
                        //     $dateView = '<b>Close</b> Open ' . $serviceCenter[0]['sc_open_time'];
                        // }
                        
                        ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                            <div class="col-lg-12 ">
                                <div class="row">
                                    <div class="col-lg-6 text-left">
                                        <h5>Service Request ID: <b><?= $ServiceData->ref_id; ?></b></h5>
                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <a href="<?= base_url() ?>Ct_service_request/edit/<?= $ServiceData->ser_id ?>" class="btn btn-primary btn-sm float-right">Edit</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-8">

                        
                        <div class="row">
                            <div class="col-lg-12"><br></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4"><?php if(empty($ServiceData->technician)){ ?> <p style="color: red;">Request Not assigned yet.</p> <?php 
                            }else{

                            }

                             ?></div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                 
                                 <?php
                                    if(empty($ServiceData->technician)){
                                 ?>
                                 <label for="userName">Assign To Technician</label>
                                 <select class="form-control select2" id="technician">
                                    <option value=""></option>
                                     <?php
                                     foreach ($techlist as $key => $value) {
                                     ?>
                                     <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                     <?php
                                     }
                                 ?>
                                 </select>
                                 <?php    
                                 }else{
                                    $techData = $this->user->getRows(array("id"=>$ServiceData->technician));
                                    echo "<br>";
                                 ?>
                                 <label for="userName">Assign To</label>
                                 <div class="row">
                                    <div class="col-lg-6">
                                         <u><b><?= $techData['name']; ?></b></u>&nbsp;&nbsp;<a href="<?= base_url() ?>Ct_dashboard/editUser/<?= $techData['id']; ?>"><i class="mdi mdi-pencil"></i></a>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-6">
                                        <i class="mdi mdi-phone"></i>&nbsp;+91 <?= $techData['mobile']; ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <i class="mdi mdi-email"></i>&nbsp; <?= $techData['email']; ?>
                                    </div>
                                 </div>
                                
                                 
                                 <?php   
                                 }
                                 ?>
                                 
                            </div>
                            <div class="col-lg-6">
                                <label for="userName">Region</label><br>
                                <?php
                                 $region = $this->user->citiesData($ServiceData->region);

                                 echo $region[0]['ct_name'];
                                 if(empty($ServiceData->transf_region)){
                                    if($ServiceData->s_status=="3"){
                                        $class = "";
                                        $color = "#9ba1a9";
                                    }else{
                                        $class = "changeR";
                                        $color = "";
                                    }
                                 ?>
                                 <u><a href="javascript:void(0);" class="<?php echo $class ?>" style="color: <?= $color; ?>">Transfer service request to another region</a></u>
                                <?php  }else{ 
                                    $cregion = $this->user->citiesData($ServiceData->transf_region);
                                    if($ServiceData->s_status=="3"){
                                        $class = "";
                                        $color = "#9ba1a9";
                                    }else{
                                        $class = "changeR";
                                        $color = "";
                                    }
                                ?>
                                 <u><a href="javascript:void(0);" class="" style="color: <?= $color; ?>">Transfer request from <?= $_SESSION['LoginUserData']['name']; ?>( <?= $cregion[0]['ct_name'] ?> Service Incharge)</a></u>   
                                <?php    
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><br></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                Status : 
                                <select id="serSt">
                                    <?php
                                        foreach ($serviceStatus as $key => $value) {
                                    ?>
                                    <option value="<?= $value['ss_id']; ?>" <?php if($value['ss_id']==$ServiceData->s_status){ echo "selected"; } ?> ><?php echo $value['stext']; ?></option>
                                    <?php
                                        }
                                    ?>  
                                </select>
                            </div>
                            <div class="col-lg-6 text-left">
                                Created Date : <?php echo date("d/m/Y",strtotime($ServiceData->created_date)); ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                Vehicle Location : <?php echo $ServiceData->vehicle_location; ?>
                                
                            </div>
                            <div class="col-lg-6 text-left">
                                Vehicle Location : <?php echo $ServiceData->veh_regno; ?>
                            </div>
                        </div>
                        <br>
                            
                        <div class="row">
                            <div class="col-lg-6">
                                Vehicle Register Date : <?php echo  date("d F Y",strtotime($ServiceData->veh_regdate)); ?>
                                
                            </div>
                            <div class="col-lg-6 text-left">
                                KM Run : <?php echo $ServiceData->km_run; ?>
                            </div>
                        </div>    
                        <br>
                        <div class="row">
                            <?php
                                $trailer = $this->Service_request->GetTrailerData($ServiceData->trailer_type)->tt_name; 
                                 $defect =  $this->Service_request->GetDefectData($ServiceData->defect_detail)->dd_name;
                            ?>
                            <div class="col-lg-6">
                                Trailer Type: <?php echo $trailer ?>
                                
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-lg-6 ">
                                Defect Detail : <?php echo $defect; ?>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            
                            <div class="col-lg-6">
                                <label for="userName">Axle SerialNumberPlate photo</label><br>
                                <img src="<?= base_url().$ServiceData->a_sno_plate ?>" width="100" height="100">
                            </div>
                            <div class="col-lg-6 text-left">
                                <label for="userName">Defect Photo</label><br>
                                <?php
                                $defectPhot = explode(",", $ServiceData->defect_photo);
                                foreach ($defectPhot as $key => $value) {
                                    if(empty($value)){}else{
                                ?>
                                <img src="<?= base_url().$value ?>" width="100" height="100">
                                <?php
                                    }
                                }
                                ?>  
                            </div>
                        </div>


                        </div>
                        <?php
                            $cData = $this->user->getRows(array("id"=>$ServiceData->customer));
                        ?>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <b>Customer Contact Details</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"><br></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table width="100%">
                                        <tr>
                                            <td>Driver Name</td>
                                            <td>ID</td>
                                        </tr>
                                        <tr>
                                            <td><b><?= $cData['name']; ?></b></td>
                                            <td><b><?= $cData['ref_id']; ?></b></td>
                                        </tr>
                                    </table>    
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-lg-12"><br></div>
                            </div>

                            <div class="row">
                                 <div class="col-lg-12">
                                    <table width="100%">
                                        <tr>
                                            <td>Gender</td>
                                            
                                        </tr>
                                        <tr>
                                            <td><b><?= $cData['gender']; ?></b></td>
                                            
                                        </tr>
                                    </table>    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12"><br></div>
                            </div>

                            <div class="row">
                                 <div class="col-lg-12">
                                    <table width="100%" >
                                        <tr>
                                            <td width="10%"><i class="mdi mdi-phone"></i></td>
                                            <td>Contact Number</td>
                                        </tr>
                                        <tr>
                                            <td width="10%"></td>
                                            <td><b>+91 <?= $cData['mobile'] ?></b></td>
                                        </tr>
                                    </table>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"><br></div>
                            </div>

                            <div class="row">
                                 <div class="col-lg-12">
                                    <table width="100%" >
                                        <tr>
                                            <td width="10%"><i class="mdi mdi-phone"></i></td>
                                            <td>Alernater Contact Number</td>
                                        </tr>
                                        <tr>
                                            <td width="10%"></td>
                                            <td><b>+91 <?= $cData['alt_mobile'] ?></b></td>
                                        </tr>
                                    </table>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"><br></div>
                            </div>

                            <div class="row">
                                 <div class="col-lg-12">
                                    <table width="100%">
                                        <tr>
                                            <td width="10%"><i class="mdi mdi-email"></i></td>
                                            <td>Email ID</td>
                                        </tr>
                                        <tr>
                                            <td width="10%"></td>
                                            <td><b><?= $cData['email'] ?></b></td>
                                        </tr>
                                    </table>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12"><br></div>
                            </div>
                            <?php
                                $citi = $this->user->cities($cData['state'],$cData['city']);
                                $state = $this->user->states($cData['state']);
                                // echo $cData['state'];
                                // print_r($citi);
                            ?>
                            <div class="row">
                                 <div class="col-lg-12">
                                    <table width="100%">
                                        <tr>
                                            <td><i class="mdi mdi-location"></i></td>
                                            <td>Address</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><b><?= $cData['address'] ?>&nbsp;
                                                <?= $citi[0]['ct_name'].",".$state[0]['st_name']."-".$cData['zipcode']; ?></b></td>
                                        </tr>
                                    </table>    
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-left"><br><br></div>
                    </div>

                    <?php
                    if($ServiceData->s_status=="3"){
                    ?>

                    <div class="row">
                        <div class="col-lg-12 text-left"><b>Solutions</b></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-left">
                            <u><?php echo $techData['name']; ?></u>&nbsp;&nbsp;Technician
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12"><?php echo $ServiceData->tech_solution; ?></div>
                    </div>

                <?php } ?>

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

<div class="modal fade" id="ChangeRegionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Transfer Service Request</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="CHANGEREGIONFORM" method="post">
        <input type="hidden" name="serid" value="<?= $ServiceData->ser_id; ?>">
      <div class="modal-body">
           <div class="alert alert-success successModal " style="display: none;">
                
                Region Changed SuccessFully
            </div> 
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><b>Region</b></label>
            <select class="form-control" name="changecity" id="changecity">
                <option value=""></option>
                <?php
                    foreach ($CityList as $key => $value) {
                ?>
                    <option value="<?= $value['ct_id'] ?>"><?= $value['ct_name'] ?></option>
                <?php
                    }
                ?>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label"><b>Note</b></label>
            <textarea class="form-control" id="message-text" name="note" rows="5"></textarea>
          </div>
        
      </div>
      <div class="modal-footer text-left">
        <button type="submit" class="btn btn-primary btn1">Transfer Request</button>
        <button type="button" class="btn btn-primary btn2" style="display: none;">
            <i class="mdi mdi-refresh mdi-spin"></i>Please Wait...</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>

      </form>
    </div>
  </div>
</div>
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>

