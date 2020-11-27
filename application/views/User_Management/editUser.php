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
                        <!--                        <h4 class="card-title mb-4">Example</h4>-->
                        <form method="post" id="editUser">
                            <input type="hidden" name="id" value="<?= $userData['id'] ?>">
                            <div class="alert alert-success alert-dismissible alert-msg successModal1" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="sucmsg"></span>
                            </div>
                             <div class="alert alert-danger alert-dismissible alert-msg errorModel" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="errmsg"></span>
                            </div>
                            <div class="alert alert-success alert-dismissible alert-msg processingModel" style="display: none;">
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
                                        if(empty($userData['user_img'])){
                                            $userImage = base_url()."app-assets/images/default-user.png";
                                        }else{
                                            $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$userData['user_img'];
                                            if(file_exists($fullUrl)){
                                                $userImage = base_url()."".$userData['user_img'];
                                            }else{
                                                $userImage = base_url().'app-assets/images/default-user.png';
                                                
                                            }   
                                            // $userImage = base_url()."".$userData['user_img'];
                                        }
                                        ?>
                                        <img id="blah" alt="your image" src="<?= $userImage ?>" width="80" height="80" />
                                        <input type="file" name="userImg" id="userImg" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" maxlength="75" style="display: none;">
                                        &nbsp;&nbsp;
                                        <a href="javascript:void(0);" onclick="$('#userImg').click();">Upload Profile Picture</a>
                                        <br><p><span style="color :red">file type must be JPEG, JPG, PNG</span><br>
                                        <span style="color :red">max file size 1MB</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="userName">Parents Name<span style="color: red;">*</span></label>
                                            <input type="text" id="parentsname" maxlength="75" tabindex="1" name="parentsname" class="form-control input-mask" placeholder="Enter Parent's Name" value="<?= $userData['name']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="email">Email<span style="color: red;">*</span></label>
                                            <input id="email" type="email" tabindex="2" name="email" class="form-control input-mask" placeholder="Enter Parents Email" value="<?= $userData['email']; ?>" readonly>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="child_name">Child Name<span style="color: red;">*</span></label>
                                            <input type="text" id="child_name" maxlength="75"  tabindex="3" name="child_name" class="form-control input-mask" placeholder="Enter Child Name" value="<?= $userData['child_name']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                     <div class="form-group mb-4">
                                            <label for="state">Child Age<span style="color: red;">*</span></label>
                                            <select id="child_age" name="child_age" tabindex="4" class="form-control select2" >
                                                <option value="" disabled="">Select Child Age</option>
                                                <?php
                                                foreach ($classList as $key => $value) {
                                                ?>
                                                <option disabled="" value="<?= $value['child_age'] ?>" classId="<?= $value['class_id'] ?>" classTitle="<?= $value['title'] ?>" <?php echo ($value['child_age']==$userData['child_age']) ? 'selected' : ''; ?>><?= $value['child_age']; ?></option>  
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                     <div class="">
                                            <?php
                                            $cTitle = getData("tb_class",array('title'),'class_id',$userData['class']);
                                            ?>
                                            <label for="state" id="classTitle"><?php echo (count($cTitle)>0) ? $cTitle[0]['title'] : ''; ?></label>
                                            <input type="hidden" name="class" id="class" value="<?= $userData['class'] ?>">
                                    </div>
                                </div>
                            </div>   

                            

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="mobile">Mobile Number<span style="color: red;">*</span></label>
                                            <input id="mobile" name="mobile" tabindex="5" type="text" maxlength="14" class="form-control input-mask mobile" value="+91|<?= $userData['mobile']; ?>" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-4">
                                            <label for="password">Set Password</label>
                                            <input type="password" name="password" tabindex="6" id="password" class="form-control input-mask" placeholder="Enter Password" value="<?= $userData['pwd'] ?>" readonly>
                                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="position: absolute; right: 20px;bottom: 35px;"></span>
                                            <i id="passworderr"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="row loadingDiv" style="display: none;">
                                <div class="col-lg-12 text-left">
                                   
                                    <input type="hidden" name="isSend" id="isSendedit" value="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-left">

                                    <input type="submit" class="btn btn-primary ml-2 btns" value="Submit">
                                    <input type="button" class="btn btn-primary ml-2 btns btnsendMailedit" value="Send">&nbsp;&nbsp;
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

    // var options = {
    //     // types: ['(cities)'],
    //     componentRestrictions: {country: 'in'}//Turkey only
    // };

    // var src1 = document.getElementById('address');
    // var autocomplete1 = new google.maps.places.Autocomplete(src1,options);

    // function getLatLang(){
    //     var link = "https://maps.googleapis.com/maps/api/geocode/json?address="+$('#address').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s";

    //     console.log(link); 
    //     $.get("https://maps.googleapis.com/maps/api/geocode/json?address="+$('#address').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s",{},function(data){
    //         // var obj = Json.parse(data);
    //         var lat = data.results[0]['geometry']['location']['lat'];
    //         var lng = data.results[0]['geometry']['location']['lng'];    
    //         $("#latitude").val(lat);
    //         $("#langitude").val(lng);

    //         $.post("http://103.101.59.95/vehicleserviceapp/api/authentication/location/",{lat:lat,long:lng},function(data){
    //             // console.log(data.data['city']);
    //             $("#state").val(data.data['state']);
    //             $("#state").trigger('change');

    //             setTimeout(function(){
    //                 $("#city").val(data.data['city']);
    //                 $("#city").trigger('change');
    //             },1000);
                
    //         });

    //     });
        
    // }

  //   $("#userName").on('keydown keyup', function(e) {
  //   // var value = String.fromCharCode(e.which) || e.key;



  //   var x = e.which || e.keycode;
  //    if ((x >= 65 && x <= 90)){
  //        return true;
  //    }else if(x==8){
  //       return true;    
  //    }else if(x==17){
  //       return true; 
  //    }else if(x==116){  
  //       return true; 
  //    }else if(x>=37 && x<=40){
  //       return true;
  //    }else if(x==9){
  //       return true;
  //    }else if(x==32){
  //       return true;               
  //    }else{
  //       e.preventDefault();
  //       return false;
  //    }
  // });

  $("#overlay").fadeIn(300);
    $("#overlay").fadeOut(300);
    $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

</script>