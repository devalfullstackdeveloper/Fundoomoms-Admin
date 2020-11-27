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
                        <!--                        <h4 class="card-title mb-4">Example</h4>-->
                        <form method="post" id="createServiceRequest" enctype="multipart/form-data">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span></span>
                            </div>
                            <input type="hidden" name="" id="baseUrl" value="<?= base_url() ?>">
                                
                                <div class="alert alert-danger alert-dismissible errormsg" style="display: none;">
                                          
                                </div>
                                <div class="alert alert-success alert-dismissible" style="display: none;">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    
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
                                
                                <div class="col-lg-4">
                                    <div>
                                        <div class="form-group">
                                            <label for="userName">Vehicle Location</label>
                                            <input type="text" id="vehicleLoc" tabindex="1" name="vehicleLoc" class="form-control input-mask" onblur="GetRegion();" >
                                            <input type="hidden" name="region" id="region">
                                        </div>

                                        <div class="form-group">
                                            <label for="userName">Trailer Type</label>
                                            <select name="trailertype" id="trailertype" class="form-control"  tabindex="5">
                                                <option value="">Select Trailer Type</option>
                                                <?php
                                                foreach ($trailerData as $tt => $traler) {
                                                ?>
                                                    <option value="<?= $traler['tt_id']; ?>"><?= $traler['tt_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="userName">Contact No. of Driver</label>

                                            <input type="text" id="drivercontact" tabindex="9" maxlength="14"  name="drivercontact" class="form-control input-mask contact" value="+91|" >
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                
                                                <div class="col-lg-5">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" tabindex="10" class="custom-control-input selcust" name="customer1" id="existingCustomer" value="existcust" >
                                                        <label class="custom-control-label" for="existingCustomer">Existing Customer</label>
                                                    </div>        
                                                </div>
                                                <div class="col-lg-2">
                                                    OR
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" tabindex="10"  class="custom-control-input selcust" name="customer1" id="addnewcust" value="newcust">
                                                        <label class="custom-control-label" for="addnewcust">Add New Customer</label>
                                                    </div>    
                                                </div>

                                            </div>
                                            
                                                
                                        </div>

                                        <div class="form-group custSelect">
                                            <label for="userName"></label>
                                            <select class="form-control select2" name="customer" tabindex="11" id="customer" >
                                                <option value="">Select an existing customer</option>
                                                <?php
                                                    foreach($customerlist as $key => $value){
                                                ?>
                                                <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                                <?php        
                                                    }
                                                ?>
                                            </select>
                                        </div>


                                          

                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="mobile">Vehicle Registration No</label>
                                            <input id="vehicleregno" name="vehicleregno" tabindex="2" type="text" class="form-control input-mask" placeholder="--|--|--|----" >
                                        </div>

                                        <div class="form-group">
                                            <label for="userName">Defect Details (Optional)</label>
                                            <select name="defect" id="defect" class="form-control" tabindex="6">
                                                <option value="">Select Service</option>
                                                <?php
                                                foreach ($defectData as $dd => $defect) {
                                                ?>
                                                    <option value="<?= $defect['dd_id']; ?>"><?= $defect['dd_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        

                                        
                                       
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="mobile">Vehicle Registration Date</label>
                                            <input id="vehicleregdate" name="vehicleregdate" tabindex="3"  max="<?php echo date("Y-m-d"); ?>" type="date" class="form-control input-mask" >
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Upload Defect Photo</label><br>
                                            <button type="button" tabindex="7" class="btn  btn-dark btndefectPhoto"><i class="fa fa-camera"></i>&nbsp;&nbsp;Choose File</button>
                                            <input type="file" name="defectphoto[]" id="defectphoto" style="display: none;" multiple=""><br>
                                             <label id="defectlabel"></label>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="mobile">KM Run</label>
                                            <input id="kmrun" name="kmrun" tabindex="4" type="text" class="form-control input-mask" placeholder="KM" >
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Upload Axle Serial Number Plate</label><br>
                                            <button type="button" tabindex="8" class="btn  btn-dark serialPhotobtn"><i class="fa fa-camera"></i>&nbsp;&nbsp;Choose File</button>
                                            <input type="file" name="serialPhoto" id="serialPhoto" style="display: none;"><br>
                                            <label id="axlelabel"></label>
                                        </div>
                                       
                                    </div>
                                </div>
                                
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div>
                                        <div class=" custdiv" style="display: none;">
                                            <label for="userName">Customer Name</label>
                                            <input type="text" id="customername"  name="cname" class="form-control input-mask tabindex " >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                         <div class=" custdiv" style="display: none;">
                                            <label for="userName" class="pb-2 d-block">Gender</label>
                                            <label><input type="radio" name="gender" id="gendermale" value="male" class="tabindex">&nbsp;Male</label>
                                            &nbsp;
                                            <label><input type="radio" name="gender" id="genderfemale" value="female" class="tabindex">&nbsp;Female</label>
                                        </div> 
                                    </div>
                                </div>

                                

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div>
                                         <div class=" custdiv" style="display: none;">
                                            <label for="userName">Email</label>
                                            <input type="text" id="customeremail"  name="email" class="form-control input-mask tabindex" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                        <div class=" custdiv" style="display: none;">
                                            <label for="userName">Contact Number</label>
                                            <input type="text" id="customercontact" maxlength="14" name="contact" class="form-control input-mask tabindex contact " value="+91|">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                        <div class=" custdiv" style="display: none;">
                                            <label for="userName">Alternate Contact Number</label>
                                            <input type="text" id="altcustomercontact" maxlength="14"  name="alt_contact" class="form-control input-mask tabindex contact" value="+91|">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12"><label><b>Address</b></label></div>
                                <div class="col-lg-4">
                                    <div>
                                        <div class=" custdiv" style="display: none;">
                                            <label for="userName">Address Line</label>
                                            <input type="text" id="custaddr" name="address" class="form-control input-mask tabindex " onblur="getLatLang();" autocomplete="off">
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="langitude" id="langitude">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                        <div class=" custdiv" style="display: none;">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="userName">State</label>
                                                    <select name="state" id="custstate" class="form-control tabindex " onchange="getcity();">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($stateList as $s => $statedata) {
                                                        ?>
                                                        <option value="<?= $statedata['st_id'] ?>"><?= $statedata['st_name']; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label for="userName">City</label>
                                                    <select name="city" id="custcity" class="form-control tabindex ">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div>
                                        <div class="custdiv" style="display: none;">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="userName">Zipcode</label>
                                                    <input type="text" id="custzip" name="zipcode" class="form-control input-mask tabindex ">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="userName">Country</label>
                                                    <input type="text" id="custcountry" name="country" class="form-control input-mask tabindex ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                              

                            

                            <div class="row">
                                <div class="col-lg-12 text-left">
                                    
                                    <input type="submit" class="btn btn-primary ml-2 btn1"  value="Submit">
                                    <button type="button" name="" class="btn btn-primary ml-2 btn2" disabled="" style="display: none;">
                                        <i class="fa fa-spinner fa-spin"></i>&nbsp;&nbsp;Submitting...
                                    </button>
                                    <a href="<?=base_url()?>Ct_service_request/index" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <!-- <input type="button" class="btn btn-primary ml-2" onclick="CreateUserSubmit('add');" value="Submit"> -->
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

