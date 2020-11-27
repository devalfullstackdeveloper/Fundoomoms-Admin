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
                        <form method="post" id="createNotification"   enctype="multipart/form-data">
                            <div class="alert alert-danger alert-dismissible d-none alert-msg errormsgBtn hideAll" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="errormsg"></span>
                            </div>
                            <div class="alert alert-success alert-dismissible successBtn hideAll" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="sucmsg"></span>
                            </div>
                            <div class="alert alert-warning alert-dismissible warningBtn hideAll" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="warningmsg"></span>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Class</label>
                                            <select class="form-control" name="class_id" id="class_id">
                                                <option value="">--SELECT--</option>
                                                <?php
                                                foreach ($classList as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value['class_id'] ?>"><?= $value['title']; ?></option>
                                                    <?php    
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-4 curDay" style="display: none;">
                                            <label for="bannerTitle">Curriculum Day</label>
                                            <select class="form-control select2" name="curriculum_day[]" id="curriculum_day" multiple="" style="width: 100%;">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">

                                        <div class="form-group mb-4" style="display: none;">
                                            <label for="bannerTitle">Package</label>
                                            <select class="form-control select2" multiple="" name="package_id[]" id="package_id">


                                            </select>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Day Type</label>
                                            <select class="form-control" name="daytype" id="daytype">
                                                <option value="">--SELECT--</option>
                                                <option value="everyday">Everyday</option>
                                                <option value="specific">Specified Curriculum Day</option>
                                                
                                            </select>
                                        </div>

                                        
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                 <label for="bannerTitle">Users Type</label>
                                 <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="allusers" id="allusers" name="usertype" onchange="return $('.exusertable').hide()">
                                            <label class="form-check-label" id="allusers" for="allusers">
                                                All Users
                                            </label>
                                        </div>       
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="freeusers" id="freeusers" name="usertype" onchange="return $('.exusertable').hide()">
                                            <label class="form-check-label" id="freeusers" for="freeusers">
                                                Free Demo Users
                                            </label>
                                        </div> 
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="premiumusers" id="premiumusers" name="usertype" onchange="return $('.exusertable').hide()">
                                            <label class="form-check-label" id="premiumusers" for="premiumusers">
                                                Full Cource User
                                            </label>
                                        </div> 
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="exusers" id="exusers" name="usertype" onclick="showUsers('exusertable');">
                                            <label class="form-check-label" id="exusers" for="exusers">
                                                Specific Users
                                            </label>
                                        </div> 
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="exusers" id="exusers" name="usertype" onclick="showUsers('exnotusertable');">
                                            <label class="form-check-label" id="exusers" for="exusers">
                                                Notification Users
                                            </label>
                                        </div> 
                                    </div>


                                </div>
                                <br>
                            </div>
                            <div class="col-lg-12 exnotusertable" style="display: none;">
                                <table id="datatable-buttons2" class="table table-borderless wp-100">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Parents Name</th>
                                    <th>Child Name</th>
                                    <th>Class</th>
                                    <th>Mobile Number</th>
                                    <th>Access</th>
                                    <th>Type</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                             if(count($userNotList)>0){
                                foreach ($userNotList as $key => $value) {

                                    if(array_key_exists('noused',$value)){
                                        $type = "Not Used";
                                        $userData = getMultiWhere('user_register',array('id','name','child_name','class','mobile','added_on'),array('id'=>$value['noused']));
                                    }else if(array_key_exists('noahed', $value)){
                                        $type = "Not Used From Fifteen Days";
                                        $userData = getMultiWhere('user_register',array('id','name','child_name','class','mobile','added_on'),array('id'=>$value['noahed']));
                                    }

                                    
                                if(count($userData)>0){    
                                    $payment = getData('payment_details',array('user_id'),'user_id',$userData[0]['id']);
                                    $class = getData('tb_class',array('title'),'class_id',$userData[0]['class']);
                             ?>
                                <tr>
                                    <th><input type="checkbox" name="exusers[]" value="<?=$userData['id']?>"></th>
                                    <td><?= $userData[0]['id']; ?></td>
                                    <td><?= $userData[0]['name']; ?></td>
                                    <td><?= $userData[0]['child_name']; ?></td>
                                    <td><?php echo (count($class)>0) ? $class[0]['title'] : ''; ?></td>
                                    <td><?= $userData[0]['mobile']; ?></td>
                                    <td><?php if($payment[0]['pay_status']=="1"){
                                            echo "<label class='paid-user badge badge-md badge-success'>Full Course</label>";
                                            // echo "full";
                                        }else{
                                            echo "<label class='free-user badge badge-md badge-warning'>Free Demo</label>";
                                            // echo "free";
                                        } ?></td>
                                    <td><?= $type; ?></td>
                                    <td><?php echo (!empty($userData[0]['added_on'])) ? date("d-m-Y",strtotime($userData[0]['added_on'])) : ''; ?></td>
                                </tr>
                             <?php       
                                    }
                                }
                             }
                             ?>       
                            </tbody>
                            
                        </table>
                            </div>
                            <div class="col-lg-12 exusertable" style="display: none;">
                             <br>
                               <!-- <table id="datatable-buttons1" class="table table-borderless nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($userList as $key => $value) {
                                        if($value['id'] != 1){
                                            ?>
                                            <tr>
                                                <th><input type="checkbox" name="exusers[]" value="<?=$value['id']?>"></th>
                                                <th><?= $value['name'] ?></th>
                                                <th><?= $value['email'] ?></th>
                                                <th><?= $value['mobile'] ?></th>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table> -->
                            <table id="datatable-buttons1" class="table table-borderless nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>ID</th>
                                        <th width="15%">Parents Name</th>
                                        <th>Child Name</th>
                                        <th>Class</th>
                                        <th>Validity</th>
                                        <th>Mobile Number</th>
                                        <th>Curriculum<br />Completed Days</th>
                                        <th>Access</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    if($userList) {
                                        foreach ($userList as $i => $userData) {
                                            $payment = getData('payment_details',array('user_id'),'user_id',$userData['id']);
                                            $class = getData('tb_class',array('title'),'class_id',$userData['class']);
                                            $image = (!empty($userData['user_img'])) ? $pic=$userData['user_img'] : $pic = 'app-assets/images/list_profile.png';            
                                            ?>
                                            <tr>
                                                <th><input type="checkbox" name="exusers[]" value="<?=$userData['id']?>"></th>
                                                <td><a href="<?= base_url() ?>Ct_dashboard/CustomerDetail/<?= $userData['id'] ?>"><?= $userData['ref_id'] ?></a></td>
                                                <td class="parent_name"><?php
                                                if(!empty($userData['user_img'])){
                                                    ?>    
                                                    <img class="img-fluid" style="width: 22%; height: auto; border-radius: 20px;
                                                }" src="<?= base_url()."".$userData['user_img'] ?>" />&nbsp;<?= $userData['name'] ?>
                                                <?php     
                                            }else{
                                                ?>
                                                <img class="img-fluid"  src="<?= base_url()."app-assets/images/list_profile.png" ?>" />&nbsp;<?= $userData['name'] ?>
                                                <?php    
                                            }
                                            ?>
                                        </td>
                                        <td><?= $userData['child_name'] ?></td>
                                        <td><?php
                                        echo (count($class)>0) ? $class[0]['title'] : '';
                                        ?>
                                    </td>
                                    <td><?php 
                                    if(count($payment)>0){
                                        $validity = getValidity($userData['id']);
                                        echo $validity['validity'];
                                    }
                                    ?>
                                </td>
                                <td><?= $userData['mobile'] ?></td>
                                <td><?php 
                                if(count($payment)>0){
                                    $validity = getValidity($userData['id']);
                                    echo $validity['completed'];
                                }
                                ?>
                            </td>
                            <td><?php 
                                        // echo count($payment);
                            if(count($payment)> 0){
                                echo "<label class='paid-user badge badge-md badge-success'>Full Course</label>";
                                            // echo "full";
                            }else{
                                echo "<label class='free-user badge badge-md badge-warning'>Free Demo</label>";
                                            // echo "free";
                            }
                            ?>
                        </td>

                        <td><?php echo date("d-M-Y", strtotime($userData['added_on'])); ?></td>

                    <?php } ?>
                </tr>
                <?php
            }
            ?>
        </tbody>

    </table>
</div>

<div class="col-lg-12">
    <label for="bannerTitle">Type a message</label>
    <!-- <textarea name="message" id="message" class="form-control" rows="5" placeholder="Notifcation Message"></textarea> -->
    <textarea name="descr" id="descr" ></textarea>
    <input type="hidden" name="message" id="message">
</div>

<div class="col-lg-12">
    <br>
</div>

<div class="col-lg-12 text-right">
    <input type="submit" class="btn btn-primary mr-2 btn1 " value="Submit">
    <button type="button" class="btn btn-primary mr-2 btn2 hideAll" style="display: none;">
        Please Wait...
        <i class="fa fa-spinner fa-spin"></i>
    </button>
    <a href="<?= base_url() ?>Ct_class/index" class="btn btn-outline-primary ml-2">Cancel</a>
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
            <div class="col-sm-12">
                <div class="text-center">
                    Copyright © <script>document.write(new Date().getFullYear())</script> Fundoomoms. All rights reserved.
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

    $("#overlay").fadeIn(300);
 $(".select2").select2();
 CKEDITOR.replace( 'descr' );
 // $("#datatable-buttons1").DataTable();

 $(document).ready(function() {
        var table =  $('#datatable-buttons1').DataTable({
            "dom" : "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-10'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "bAutoWidth": false,
            "scrollX": true,      
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[-1, 10, 25, 50], ["all", 10, 25 ,50]],
            oLanguage: {
                sLengthMenu: "_MENU_",
            },

            initComplete: function () {
                var Mon = '<select class="custom-select custom-select-sm fMonth">';
                <?php
                $monArr = array("01"=>"January","02"=>"February","03"=>"March","04"=>"April",
                            "05"=>"May","06"=>"June","07"=>"July","08"=>"August",
                            "09"=>"September","10"=>"October","11"=>"November","12"=>"December");
                foreach ($monArr as $key => $value) {
                    $selected = ($key==date("m")) ? 'selected' : '';

                    $cName = ($key==date("m")) ? $printM='This Month' : $printM = $value;
                ?>
                Mon +='<option value=<?php echo $key ?> <?php if(!empty($fmonth)){ if($fmonth==$key){ echo "selected"; } }else{ echo $selected; } ?>><?php echo $printM; ?></option>';
                <?php
                }
                ?>
                Mon +='</select>';
                $("#datatable-buttons1_filter").append(Mon);

                var cClass = '<span>Class</span><select class="custom-select custom-select-sm cClass">';
                cClass +='<option value="all" <?php if($cClass=='all') echo "selected"; ?>>--All--</option>';
                <?php
                foreach ($classList as $key => $value) {
                ?>
                cClass +='<option value=<?php echo $value['class_id'] ?> <?php if($cClass==$value['class_id']) echo "selected"; ?>><?php echo $value['title']; ?></option>';
                <?php    
                }
                ?>
                cClass +='</select>';
                $(cClass).insertAfter($(".fMonth"));

                var acc = '<span>Access</span><select class="custom-select custom-select-sm access">';
                acc +='<option value="all" <?php if($access=='all') echo "selected"; ?>>--All--</option>';
                acc +='<option value="freedemo" <?php if($access=='freedemo') echo "selected"; ?>>Free Demo</option>';
                acc +='<option value="fullcourse" <?php if($access=='fullcourse') echo "selected"; ?>>Full Course</option>';
                acc +='<select>';

                $(acc).insertAfter($(".cClass"));
            },

        });
       
    });

 $("#overlay").fadeOut(300);

 var baseURL = $("#baseUrl").val();

function showUsers(type){
    if(type=='exusertable'){
        $(".exusertable").show();
        $(".exnotusertable").hide();
    }else if(type=="exnotusertable"){
        $(".exusertable").hide();
        $(".exnotusertable").show();
    }        
}
</script>