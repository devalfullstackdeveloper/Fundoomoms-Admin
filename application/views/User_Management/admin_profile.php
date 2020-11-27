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
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">

                        <form method="post" id="createUser" autocomplete="off">
                            <input type="hidden" name="userId" id="userId" value="<?= $userData[0]['id'] ?>">
                            <div class="alert alert-success alert-dismissible alert-msg successModal1" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="sucmsg"></span>
                            </div>
                             <div class="alert alert-danger alert-dismissible alert-msg errorModel" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="errmsg"></span>
                            </div>
                            <div class="alert alert-primary alert-dismissible alert-msg processingModel" style="display: none;">
                              Please wait......<i class="fa fa-spinner fa-spin"></i>     
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
                                <div class="col-lg-12">
                                    <div class="form-group mb-4">
                                        <?php
                                        if(empty($userData[0]['user_img'])){
                                            $userImage = base_url()."app-assets/images/default-user.png";
                                        }else{
                                            $userImage = base_url()."".$userData[0]['user_img'];
                                        }
                                        ?>
                                        <img id="blah" alt="your image" src="<?= $userImage ?>" width="80" height="80" />
                                        <input type="file" name="userImg" id="userImg" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" maxlength="75" style="display: none;">
                                        &nbsp;&nbsp;
                                        <a href="javascript:void(0);" onclick="$('#userImg').click();">Upload Profile Picture</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="userName">Username<span style="color: red;">*</span></label>
                                            <input type="text" id="username" maxlength="75" tabindex="1" name="username" class="form-control input-mask" placeholder="Enter username" value="<?= $userData[0]['email'] ?>">
                                    </div>
                                </div>
                                
                            </div> 

                               

                            

                            <div class="row">
                                
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" tabindex="2" id="password" class="form-control input-mask" placeholder="Enter Password" autocomplete="off" value="<?= $userData[0]['pwd'] ?>">
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="position: absolute; right: 20px;bottom: 35px;"></span>
                                            <i id="passworderr"></i>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                   <div class="form-group mb-4">
                                            <label for="cpassword">Confirm Password</label>
                                            <input type="password" name="cpassword" tabindex="3" id="cpassword" class="form-control input-mask" placeholder="Enter confirm Password" autocomplete="off" value="<?= $userData[0]['pwd'] ?>">
                                            <span toggle="#cpassword" class="fa fa-fw fa-eye field-icon toggle-password" style="position: absolute; right: 20px;bottom: 35px;"></span>
                                            <i id="passworderr"></i>
                                    </div>
                                </div>

                            </div>

                           
                            <div class="row">
                                <div class="col-lg-12 text-left">
                                    <input type="submit" class="btn btn-primary ml-2 btns" value="Submit">
                                     <a href="<?=base_url()?>Ct_dashboard/viewUser" class="btn btn-outline-primary mr-2 btns">Cancel</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <!-- End Page-content -->
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    Copyright © <script>document.write(new Date().getFullYear())</script> Fundoomoms. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s&libraries=places,geometry"></script> -->
<script type="text/javascript">
    
     $("#overlay").fadeIn(300);

    $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

    $("#userName").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

    var x = e.which || e.keycode;
     if ((x >= 65 && x <= 90)){
         return true;
     }else if(x==8){
        return true;    
     }else if(x==17){
        return true; 
     }else if(x==116){  
        return true; 
     }else if(x>=37 && x<=40){
        return true;
     }else if(x==9){
        return true;
     }else if(x==32){
        return true;               
     }else{
        e.preventDefault();
        return false;
     }
  });

     $("#overlay").fadeOut(300);

</script>