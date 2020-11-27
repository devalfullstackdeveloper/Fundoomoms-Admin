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
                    
                    <?php
                    /* _P_1 is Create Permission */
                    if($role_id == 1 || in_array($active_menu."_P_1", $permission)){
                       ?>
                    <!-- <div class="page-title-right">
                        <a href="<?= base_url() ?>Ct_dashboard/createUser" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Add
                        </a>
                    </div> -->
                    <?php
                    }else{
                        echo $breadCrumb;
                    }
                    ?>
                    

                </div>
            </div>
        </div>
        
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row customer-detail" data-select2-id="12">
                        	<div class="col-3">
                        		<h6>Class</h6>
                                <select id="child_class" name="child_class" class="custom-select custom-select-sm">
                                    <?php
                                    foreach ($classList as $key => $value) {
                                    ?>
                                    <option value="<?= $value['class_id'] ?>" totalDay="<?php echo getCountCur($value['class_id']); ?>" childAge="<?= $value['child_age'] ?>" cDays="<?= $value['c_days'] ?>"><?= $value['title'] ?></option>
                                    <?php     
                                    }
                                    ?>
                                	
                                </select>
                        	</div>
                        	<div class="col-2">
                        		<h6>Child Age</h6><b><span id="childAge">2 to 3 Years</span></b>
                        	</div>
                        	<div class="col-2">
                        		<h6>Curriculum Days</h6><span><b class="badge bg-light day-badge" id="classDays">180</b></span>
                        	</div>
                        	<div class="col-2">
                        		<h6>Added Curriculum</h6><span><b id="totalDay1">0 Days</b></span>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>



		<div class="row viewprogressbar" data-select2-id="12">
            
        </div>

		<div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body posnt p-0">
                        <div class="scroll-box">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h6 class="card-title list-title">All Days</h6>
                                </div>
                                <div class="col-lg-8 text-right">
                                            <button class="btn btn-primary btn-sm importBtn mr-3 mt-3" >Import Curriculum</button>
                                            <input type="file" name="" id="importCur" style="display: none;">
                                            <button class="btn btn-primary btn-sm exportbtn mr-3 mt-3" >Export Curriculum</button>
                                    
                                </div>
                            </div>                        
	                    <div class="all-days scrollbar">
                        
                        </div>
                        <label class="prevbtn"><img class="img-fluid" src="<?= base_url() ?>app-assets/images/Group 1126.png"></label>
                        <label class="nexttbtn"> <img class="img-fluid" src="<?= base_url() ?>app-assets/images/Group 1125.png"></label>
                        </div>
                        <div class="curriculum_day_details">
                        </div>
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
                        Copyright &copy; <script>document.write(new Date().getFullYear())</script> Fundoomoms. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>
<style>
video {
    height: 300px !important;
    width: 585px !important;
    }
</style>
<script type="text/javascript">
    $("#overlay").fadeIn(300);

    
    $(document).on('click','.prevbtn',function(){
        var vscroll = $(".scrollbar").scrollLeft();
        // alert(vscroll);
        if(vscroll>0){
            $(".scrollbar").scrollLeft(vscroll-35);    
        }else{
            $(".scrollbar").scrollLeft(0);
        }
        
    });

    $(document).on('click','.nexttbtn',function(){
        var vscroll = $(".scrollbar").scrollLeft();
        $(".scrollbar").scrollLeft(vscroll+35);    
        
    });

    $(document).on('click','.importBtn',function(){
        $("#importCur").click();
    });

    $('input[type="file"]').change(function(e){
        var fd = new FormData();
        var files = e.target.files[0];
        fd.append('importFile',files);
        $("#overlay").fadeIn(300);
        $.ajax({
            url: baseURL+'Ct_curriculum/importCurriculum',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                // location.reload();
// location.reload();
                var data = JSON.parse(response);

                // // console.log(data['exist']);
                if(data['status']==true){

                    $("#overlay").fadeOut(300);
                    var emsg = "";
                    if(data['exist']!=''){
                        var ex = JSON.parse(data['exist']);
                        var ex1 = '';
                        $.each(ex,function(i, e){
                            ex1 +=' and '+i+' '+e+''
                            
                        });
                        if(ex1!=''){
                            emsg +=ex1+' skipped beacuses its already saved ';      
                        }
                        // alert(emsg);
                    }
                    Swal.fire({
                        title : "Import!", 
                        text: "File Imported Suceessfully "+emsg,
                        type: "success",
                        confirmButtonColor: "#c41e3b",
                        confirmButtonText: "OK"
                    }).then((result) => {$("#child_class").trigger('change'); $("#importCur").val('');});
                }else{
                    $("#overlay").fadeOut(300);
                    Swal.fire({
                        title : "Import!", 
                        text: "The file you are trying to imprort in not properly imported! Please try again",
                        type: "warning",
                        confirmButtonColor: "#c41e3b",
                        confirmButtonText: "OK"
                    }).then((result) => {$("#child_class").trigger('change'); $("#importCur").val('');});
                }

                // GetProjectImages($("#projects_id_for_estimate").val());

                // GetProjectImages($("#projects_id_for_estimate").val());
            },
        });
    });

    $(document).on('click','.exportbtn',function(){
        var cls = $("#child_class").val();
        window.location.href=baseURL+'Ct_curriculum/ExportCurriculum/'+cls;
    });

    $("#overlay").fadeOut(300);
</script>