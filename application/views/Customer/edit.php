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
                        <form method="post" id="createCustomer" action="<?= base_url() ?>Ct_customer/editCustomer">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span></span>
                            </div>
                            <input type="hidden" name="id" id="custid" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['id'];  }else{ echo $userData['cust_id']; } ?>">
                            <input type="hidden" name="" id="baseUrl" value="<?= base_url() ?>" >
                            <input type="hidden" name="cityid" id="cityid" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['cityid'];  }else{ echo $userData['city']; } ?>">
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
                                    <div class="form-group mb-4">
                                        <label for="sc_name">Customer Name</label>
                                        <input type="text" id="cname"  name="cust_name" class="form-control input-mask" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['cust_name'];  }else{ echo $userData['cust_name']; } ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="sc_contact">Gender</label><br>
                                        <input type="radio" name="gender" id="genderm" class="" 
                                        <?php 
                                            if($this->session->flashdata('custdata')){
                                             if(isset($this->session->flashdata('custdata')['gender'])){   
                                                 if($this->session->flashdata('custdata')['gender']=="male"){
                                                    echo "checked";
                                                 }   
                                                }
                                            }else{ 
                                                if($userData['gender']=="male"){ echo "checked"; 
                                            } } ?> value="male">&nbsp;&nbsp;Male&nbsp;&nbsp;
                                        <input type="radio" name="gender" id="genderf" class="" <?php 
                                            if($this->session->flashdata('custdata')){
                                                if(isset($this->session->flashdata('custdata')['gender'])){
                                                     if($this->session->flashdata('custdata')['gender']=="female"){
                                                        echo "checked";
                                                     }   
                                                }
                                            }else{ 
                                                if($userData['gender']=="female"){ echo "checked"; 
                                            } } ?> value="female">&nbsp;&nbsp;Female
                                    </div>
                                </div>
                            </div>
                            <div class="row">    

                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="sc_open_time">Email</label>
                                        <input type="email" id="email" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['email'];  }else{ echo $userData['email']; } ?>" name="email" class="form-control input-mask">
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="sc_location">Contact Number</label>
                                        <input type="number" id="contact" maxlength="10" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['contact'];  }else{ echo $userData['contact']; } ?>"  name="contact" class="form-control input-mask">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="sc_location">Alternate Contact Number</label>
                                        <input type="number" id="alt_contact" maxlength="10" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['alt_contact'];  }else{ echo $userData['alt_contact']; } ?>" name="alt_contact" class="form-control input-mask">
                                    </div>
                                </div>

                            </div>    

                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                        <label for="userName">Address Line</label>
                                        <input type="text" id="address" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['address'];  }else{ echo $userData['address']; } ?>" name="address" class="form-control input-mask">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="userName">State</label>
                                        <select id="state" tabindex="8" name="state" class="form-control select2"  onchange="getCityCust(this.val);">
                                            <option value="">Select State</option>
                                            <?php
                                            foreach ($state as $j => $stateData) {
                                            ?>
                                                <option value="<?= $stateData['st_id']; ?>" 
                                                <?php 
                                                if($this->session->flashdata('custdata')){ 
                                                    if($this->session->flashdata('custdata')['state']==$stateData['st_id']){
                                                        echo "selected";
                                                    }
                                                }else{
                                                    if($userData['state']==$stateData['st_id']){ 
                                                        echo "selected";
                                                } 
                                            }   ?>><?= $stateData['st_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="userName">City</label>
                                        <select id="city" name="city" tabindex="7" class="form-control select2" >
                                            <option value="">Select City</option>

                                        </select>
                                    </div>
                                </div>
                                
                                

                                 <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="userName">Zip Code</label>
                                        <input type="text" id="zipcode" value="<?php if($this->session->flashdata('custdata')){ echo $this->session->flashdata('custdata')['zipcode'];  }else{ echo $userData['zipcode']; } ?>"  name="zipcode" class="form-control input-mask">
                                    </div>
                                </div>

                                 <div class="col-lg-2">
                                    <div class="form-group mb-4">
                                        <label for="userName">Country</label>
                                        <input type="text" id="country" value="<?php 
                                        if($this->session->flashdata('custdata')){
                                         echo $this->session->flashdata('custdata')['country'];
                                        }else{ echo $userData['country']; } ?>"  name="country" class="form-control input-mask">
                                    </div>
                                </div>


                                <div class="col-lg-12 text-center">
                                    <a href="<?= base_url() ?>Ct_customer/index" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <input type="button" class="btn btn-primary ml-2" onclick="CreateCustomerSubmit('edit');" value="Submit">
                                </div>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s&libraries=places,geometry"></script>

<script type="text/javascript">

    getCityCust();

    function getCityCust(){
    var state = $("#state").val();
    
    var baseURL = $("#baseUrl").val();
    var ajxUrl = baseURL + "Ct_dashboard/cityFromState";
    $.ajax({
        url:ajxUrl,
        method:"POST",
        data: {
            state:state,
    
        },
        dataType: "json",
        success:function(data)
        {
            var html = '<option value="">Select City</option>';
            var cityid = $("#cityid").val();
            // alert(cityid);
            $(data).each(function(i, v){
                if(v.ct_id==cityid){
                    html += '<option value="'+v.ct_id+'" selected>'+v.ct_name+'</option>';
                }else{
                    html += '<option value="'+v.ct_id+'">'+v.ct_name+'</option>';    
                }
                
            });
            $("#city").html(html);
        }
    });
}

</script>