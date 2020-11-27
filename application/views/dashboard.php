<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $page_name ?></h4>

                    <?php
                    /* _P_1 is Create Permission */
                    if($role_id == 1 || in_array($active_menu."_P_1", $permission)){
                       ?>
                    <!-- <div class="page-title-right">
                        <a href="<?= base_url() ?>Ct_dashboard/createUser" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Add
                        </a>
                    </div> -->
                    <div class="page-title-right dropdown show">
                        <a href="#" class="btn york-button waves-effect waves-light mb-2 font-weight-bold dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Add
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?=base_url()?>Ct_curriculum/viewCurriculum/">Curriculum</a>
                            <a class="dropdown-item" href="<?=base_url()?>Ct_notification/create/">Notification</a>
                            <a class="dropdown-item" href="<?=base_url()?>Ct_syllabus/create/">Syllabus</a>
                            <a class="dropdown-item" href="<?=base_url()?>Ct_dashboard/createUser/">Add Mom's</a>
                        </div>
                    </div>
                    <!-- <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown link
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div> -->
                    <?php
                    }else{
                        echo $breadCrumb;
                    }
                    ?>

                    <input type="hidden" name="" id="base_url" value="<?php echo base_url(); ?>">
                    
                </div>
            </div>
        </div>

            <?php
             $monArr = array("01"=>"January","02"=>"February","03"=>"March","04"=>"April",
                            "05"=>"May","06"=>"June","07"=>"July","08"=>"August",
                            "09"=>"September","10"=>"October","11"=>"November","12"=>"December");
            ?>

         <div class="row">
                    <div class="col-lg-6">

                        <div class="dashbord-whit card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h4 for="child_class" class="card-title">Mom's</h4>
                                </div>
                                <div class="col-lg-8 text-right">
                                    <!--<select class=" custom-select-sm dashboard-select float-right" id="DashSelectMoms">
                                        <?php
                                        foreach ($monArr as $key => $value) {
                                        $selected = ($key==date("m")) ? 'selected' : '';
                                        $cName = ($key==date("m")) ? $printM=$value : $printM = $value;
                                    ?>
                                        <option class="selectd" value="<?= $key ?>" <?= $selected ?>><?= $cName ?></option>
                                    <?php        
                                        }
                                        ?>
                                    </select>-->

                                    <input type="hidden" name="" id="DashSelectMoms" value="<?php echo date("m"); ?>">

                                    <div id="reportrange" class="custom-date">
                                        
                                        <span></span> <i class="bx bx-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row LoadMoms">

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashbord-whit card-body">
                            
                            <div class="row">
                                    <label for="child_class"></label>

                                <div class="col-lg-12 text-right">
                                    <!--<select class="custom-select-sm custom-select dashboard-select" id="DashSelectMomsCharts">
                                        <?php
                                        foreach ($monArr as $key => $value) {
                                        $selected = ($key==date("m")) ? 'selected' : '';
                                        $cName = ($key==date("m")) ? $printM=$value : $printM = $value;
                                    ?>
                                        <option value="<?= $key ?>" <?= $selected ?>><?= $cName ?></option>
                                    <?php        
                                        }
                                        ?>
                                    </select>-->

                                    <div id="reportrange1" class="custom-date">
                                        <span></span> <i class="bx bx-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row LoadMomsChart align-items-center">
                            </div>

                        </div>
                    </div>
        </div>

            <div class="row mt-4">
                        <div class="col-lg-12">
                        
                            <div class="row">
                               
                                    <div class="col-lg-6">
                                    <div class="card-body dashbord-whit">
                                        <!-- <div class="rectangle">
                                            <p class="m-0 earlych">10 Early child| Crriculam</p>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <!--<select class="custom-select custom-select-sm dashboard-select" id="DashSelectClassChart">
                                                    <?php
                                                    foreach ($monArr as $key => $value) {
                                                    $selected = ($key==date("m")) ? 'selected' : '';
                                                    $cName = ($key==date("m")) ? $printM=$value : $printM = $value;
                                                ?>
                                                    <option value="<?= $key ?>" <?= $selected ?>><?= $cName ?></option>
                                                <?php        
                                                    }
                                                    ?>
                                                </select>-->

                                                <div id="reportrange2" class="custom-date">
                                                    <span></span> <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row LoadClassChart" style="margin-top: -20px;">

                                            

                                        </div>
                                    </div>
                                    </div>

                                        <div class="col-lg-6">
                                        <div class="dashbord-whit">
                                                <div class="addbtncur">
                                                    <span class="innrbt">
                                                <a href="<?=base_url()?>Ct_curriculum/viewCurriculum" class="btn yorkk-button waves-effect waves-light mb-2 font-weight-bold">
                                                    <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Add Curriculum</a></span>
                                                 </div>
                                            <?php
                                                $class1 = $this->tb_class->getAllRecords();
                                                foreach ($class1 as $key => $value) {
                                                if($value['class_id']=="2"){
                                                    $showClass = "fiveday";
                                                }else{
                                                    $showClass = "";
                                                } 
                                            ?>

                                                <div class="row">
                                              
                                                    <div class="col-lg-12">
                                                        <div class="card-body">
                                                        <h6 class="curriculum-title"><?= $value['title'] ?> Curriculum</h6>
                                                        <?php
                                                        $getRecords = $this->curriculum->countClassWise($value['class_id']);
                                                        ?>
                                                        <div class="progress">
                                                            <?php
                                                            $percentage = (180-($getRecords));
                                                                $percentage = (180-$percentage);  
                                                            ?>
                                                            <div class="progress-bar <?php echo $showClass; ?>" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="180"></div>
                                                        </div>
                                                        <span class="addedrecod">Added <?= $getRecords ?> Days Of Curriculum</span>
                                                        <span class="float-right number-add"><?php echo $value['c_days'];  ?> Days</span>
                                                        </div>
                                                    </div>

                                                </div>

                                            <?php } ?>    
                                                
                                        </div>
                                        </div>
                                    
                                </div>
                            
                        </div>
            </div>


            <div class="row mt-4 m-0 p-0 ">
            <div class="dashbord-whit mb-4">
                <div class="reqestcll"><p class="card-title list-title">Call Request</p></div>
                <div class="LoadList">
               
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

<script type="text/javascript">
  
    $(document).on('change','#DashSelectMoms',function(data){
        $.post(baseURL+'Ct_dashboard/LoadDashMoms',{month:$(this).val()},function(data){
            $(".LoadMoms").html(data);
        });
    });

    $(document).on('change','#DashSelectMomsCharts',function(data){
        $.post(baseURL+'Ct_dashboard/LoadDashCharte1',{month:$(this).val()},function(data){
            $(".LoadMomsChart").html(data);
        });
    });

    $(document).on('change','#DashSelectClassChart',function(data){
        $.post(baseURL+'Ct_dashboard/LoadDashClassChart',{month:$(this).val()},function(data){
            $(".LoadClassChart").html(data);
        });
    });

    // $("#DashSelectMoms").trigger('change');
    // $("#DashSelectMomsCharts").trigger('change');
    // $("#DashSelectClassChart").trigger('change');

    // function loadData(){
        
    //     $.post(baseURL+'Ct_dashboard/loaduserList',{month:'09',class:'all',access:'all'},function(data){
    //         $(".LoadList").html(data);
    //     });
    // }

    // loadData();

    // $(document).on('change','.fMonth, .cClass, .access',function(){
    //     var cmon = $(".fMonth").val();
    //     var cls = $(".cClass").val();
    //     var access = $(".access").val();
    //     $.post(baseURL+'Ct_dashboard/loaduserList',{month:cmon,class:cls,access:access},function(data){
    //         $(".LoadList").html(data);
    //     });
    // })

//     function loadBook(){
//     var cmonth = '<?php echo date("m"); ?>';
//     // var sclass = $(".cClass").val();
//     // var sch = $(".sch").val();
//     $.post(baseURL+'Ct_dashboard/load_dashboard_request',{fmonth:cmonth,fclass:'all',fstatus:'all'},function(data){
//         $(".LoadList").html(data);
//     });
//     }

// $(document).on('change','.fMonth, .cClass, .sch',function(){
//      var cmonth = $(".fMonth").val();
//     var sclass = $(".cClass").val();
//     var sch = $(".sch").val();
//     $.post(baseURL+'Ct_dashboard/load_dashboard_request',{fmonth:cmonth,fclass:sclass,fstatus:sch},function(data){
//         $(".LoadList").html(data);
//     });
// });



$("#overlay").fadeIn(300);
setTimeout(function(){
    // loadBook();
    $("#overlay").fadeOut(300);
},1000);
</script>