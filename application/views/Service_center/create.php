<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

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
                        <form method="post" id="createServiceCenter" action="<?= base_url() ?>Ct_service_center/addService">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span></span>
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
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_name">Service Center Name</label>
                                        <input type="text" id="sc_name"  name="sc_name" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_contact">Contact</label>
                                        <input type="text" id="sc_contact"  maxlength="10" name="sc_contact" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_open_time">Open Time</label>
                                        <!-- <div class="input-group bootstrap-timepicker timepicker">
                                            <input id="sc_open_time" name="sc_open_time" type="text" class="form-control input-small">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                        </div> -->
                                        
                                        <input type="text" id="sc_open_time" autocomplete="off"  name="sc_open_time" class="form-control input-mask" style="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_close_time">Close Time</label>
                                        <input type="text" id="sc_close_time"  autocomplete="off" name="sc_close_time" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_location">Location</label>
                                        <input type="text" id="sc_location"  name="sc_location" onblur="getLatLang();" class="form-control input-mask">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="langitude" id="langitude">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="userName">State</label>
                                        <select id="state" name="state" tabindex="7" class="form-control select2" onchange="getCity();">
                                            <option value="">Select State</option>
                                            <?php
                                            foreach ($state as $i => $stateData) {
                                                ?>
                                                <option value="<?= $stateData['st_id'] ?>"><?= $stateData['st_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="userName">City</label>
                                        <select id="city" tabindex="8" name="city" class="form-control select2">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <a href="<?= base_url() ?>Ct_dashboard/viewUser" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <input type="button" class="btn btn-primary ml-2" onclick="CreateServiceRequestSubmit('add');" value="Submit">
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
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s&libraries=places,geometry"></script>

<script type="text/javascript">

     $('#sc_open_time').timepicker({
        interval: 15,
        scrollbar: true,
        timeFormat: 'H:mm',
     });

     $("#sc_close_time").timepicker({
        interval: 15,
        scrollbar: true,
        timeFormat: 'H:mm',
     });

     var options = {
        // types: ['(cities)'],
        componentRestrictions: {country: 'in'}//Turkey only
    };

    var src1 = document.getElementById('sc_location');
    var autocomplete1 = new google.maps.places.Autocomplete(src1,options);

    function getLatLang(){
        var link = "https://maps.googleapis.com/maps/api/geocode/json?address="+$('#sc_location').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s";

        console.log(link); 
        $.get("https://maps.googleapis.com/maps/api/geocode/json?address="+$('#sc_location').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s",{},function(data){
            // var obj = Json.parse(data);
            var lat = data.results[0]['geometry']['location']['lat'];
            var lng = data.results[0]['geometry']['location']['lng'];    
            $("#latitude").val(lat);
            $("#langitude").val(lng);

            $.post("http://103.101.59.95/vehicleserviceapp/api/authentication/location/",{lat:lat,long:lng},function(data){
                // console.log(data.data['city']);
                $("#state").val(data.data['state']);
                $("#state").trigger('change');

                setTimeout(function(){
                    $("#city").val(data.data['city']);
                    $("#city").trigger('change');
                },1000);
                
            });

        });
        
    }

     $("#sc_name").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

        var x = e.which || e.keycode;
         if ((x >= 65 && x <= 90)){
             return true;
         }else if(x==8 || x==17 || x==116 || x==9 || x==32){
            return true;    
         }else if(x>=37 && x<=40){
            return true;
         }else{
            e.preventDefault();
            return false;
         }
  });

     $("#sc_contact").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

        var x = e.which || e.keycode;
         if ((x >= 48 && x <= 57)){
             return true;
         }else if(x==8 || x==17 || x==116 || x==9){
            return true;    
         }else if(x>=96 && x<=105){
            return true;
         }else{
            e.preventDefault();
            return false;
         }
  });
</script>