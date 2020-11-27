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
                    <input type="hidden" name="" id="baseUrl" value="<?php echo base_url(); ?>">

                </div>
            </div>
        </div>
        
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row" data-select2-id="12">
                        	<div class="col-4">
                        		<label for="child_class">Class</label><br>
                                <select id="child_class" name="child_class" class="custom-select">
                                	<?php
                                    foreach ($classList as $key => $value) {
                                    ?>
                                    <option value="<?= $value['class_id'] ?>" <?php if(isset($class)) if($value['class_id']==$class) echo "selected"; ?> childAge="<?= $value['child_age'] ?>"><?= $value['title'] ?></option>
                                    <?php    
                                    }
                                    ?>
                                </select>
                        	</div>
                        	<div class="col-4">
                        		<h6>Child Age</h6><p class="pt-12" id="childAge"></p>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>

		<div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <h6>List of Lesson</h6>
                    <div class="page-title-right">
                         <a id="createLesson" href="javascript:void(0)" class="btn york-button waves-effect waves-light mb-2 font-weight-bold pl-0">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Add Lesson
                        </a>
                    </div>
                    <div class="row curriculum_class_1" data-select2-id="12">
                        
                    </div>
                     
                </div>
            </div>
        </div>
        
    </div>
    <!-- End Page-content -->

    </div>
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

<script type="text/javascript">

     var baseURL = $("#baseUrl").val();
    $(document).on('change','#child_class',function(){
         $("#overlay").fadeIn(300);
        var cAge = $(this).children("option:selected").attr('childAge');
        $("#childAge").html(cAge);

        $.post(baseURL+'Ct_curriculum/loadLesson',{class:$(this).val()},function(data){
            $(".curriculum_class_1").html(data);
            $("#overlay").fadeOut(300);
        });
    });

    setTimeout(function(){
        $("#child_class").trigger('change');
    },1000);
    

     $("#overlay").fadeIn(300);

    $(document).on('click','#createLesson',function(){
        var Class = $("#child_class").val();
        window.location.href=baseURL+'Ct_curriculum/createLesson/'+Class;
    }); 

     $("#overlay").fadeOut(300);
	// $(document).ready(function() {
	// 	$("#child_class").change(function(){
 //        	var child_class = $(this).children("option:selected").val();
 //        	if(child_class == 'Early Childhood I') {
	// 			jQuery("#childAge").html("3 to 4 Years");
 //                $(".curriculum_class_1").removeClass("hide");
 //                $(".curriculum_class_2").addClass("hide");
	// 		} else if(child_class == 'Early Childhood II') {
	// 			jQuery("#childAge").html("4 to 5 Years");
 //                $(".curriculum_class_1").addClass("hide");
 //                $(".curriculum_class_2").removeClass("hide");
	// 		}
 //        });

 //        $("#createLesson").click(function(e) {
 //            e.preventDefault();
 //            var child_class = $('#child_class').children("option:selected").val();
 //            console.log(child_class);
 //            var createLesson = "<?php echo base_url() ?>"+"Ct_curriculum/createLesson/"+child_class;
 //            console.log(createLesson);
 //            window.location.href = createLesson;
 //        });
	// });
</script>
<script>
    $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
    </script>
