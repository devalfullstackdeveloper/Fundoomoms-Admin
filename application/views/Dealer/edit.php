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
                        <form method="post" id="createServiceCenter" action="<?= base_url() ?>Ct_dealer/editService">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span></span>
                            </div>
                            <input type="hidden" name="id" value="<?= $userData['dl_id'] ?>">
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
                                        <label for="sc_name">Dealer Name</label>
                                        <input type="text" id="sc_name" value="<?=$userData['dl_name']?>"  name="sc_name" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_contact">Contact</label>
                                        <input type="text" id="sc_contact" value="<?=$userData['dl_contact']?>" maxlength="10" name="sc_contact" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_open_time">Email</label>
                                        <input type="email" id="email" value="<?=$userData['dl_email']?>"  name="email" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="sc_location">Location</label>
                                        <input type="text" id="sc_location" value="<?=$userData['dl_location']?>" name="sc_location" onblur="getLatLang();" class="form-control input-mask">
                                        <input type="hidden" name="latitude" id="latitude" value="<?=$userData['dl_lat']?>">
                                        <input type="hidden" name="langitude" id="langitude" value="<?=$userData['dl_long']?>">
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
                                                <option value="<?= $stateData['st_id'] ?>" <?php if($stateData['st_id']==$userData['dl_state']) echo "selected"; ?>><?= $stateData['st_name'] ?></option>
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
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="open_time">Open Time</label>
                                        <input type="time" value="<?=$userData['dl_open_time']?>" id="sc_open_time"  name="open_time" class="form-control input-mask">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="close_time">Close Time</label>
                                        <input type="time" id="close_time" value="<?=$userData['dl_close_time']?>"  name="close_time" class="form-control input-mask">
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 text-right">
                                    <a href="<?= base_url() ?>Ct_dealer/index" class="btn btn-outline-primary mr-2">Cancel</a>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s&libraries=places,geometry"></script>

<script type="text/javascript">
    var src1 = document.getElementById('sc_location');
    var autocomplete1 = new google.maps.places.Autocomplete(src1);

    setTimeout(function(){
        $("#state").trigger('change');
    },1000);

    function getLatLang(){
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
</script>