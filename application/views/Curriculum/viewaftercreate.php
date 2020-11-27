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
                        
                        <form method="post" id="createcurriculum">
                            <div class="alert alert-danger alert-dismissible  errormsg" style="display: none;">
                                
                            </div>
                            <div class="alert alert-success alert-dismissible" style="display: none;">
                                   
                            </div>
                            <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">
                                        <div class="form-group mb-4">
                                            <label for="child_class">Day</label>
                                            <input type="text" disabled="" name="" value="<?= $curriculum_day ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                            <?php 
                                            $class_1 = $class_2 = '';
                                            $child_class = urldecode($curriculum_class);

                                            // if($child_class == 'Early Childhood I') {
                                            //     $class_1 = "selected='selected'";
                                            // } elseif($child_class == 'Early Childhood II') {
                                            //     $class_2 = "selected='selected'";
                                            // }
                                            if($child_class == 1) {
                                                $class_1 = "selected='selected'";
                                            } elseif($child_class == 2) {
                                                $class_2 = "selected='selected'";
                                            }
                                            ?>
                                        <div class="form-group mb-4">
                                            <label for="child_class">Class</label>
			                                <select id="child_class" name="child_class" class="form-control select2" disabled="disabled">
			                                	<option value="Early Childhood I" <?php echo $class_1; ?>>Early Childhood I</option>
			                                    <option value="Early Childhood II" <?php echo $class_2; ?>>Early Childhood II</option>
			                                </select>
                                        </div>
                                        
                                        <input type="hidden" name="childClass" id="childClass" value="<?php echo $child_class; ?>">

                                        <input type="hidden" name="curriculum_day" id="curriculum_day" value="<?php echo $curriculum_day; ?>">

                                        
                                        
                                       


                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">
                                    	<div class="form-group mb-4">
                                            <h6 class="mb-3">Child Age</h6><span class="d-block pt-1" id="childAge"><?=isset($child_age[0]['child_age']) ? $child_age[0]['child_age'] : "" ?></span>
                                        </div>
                                    </div>
                                </div>

                                
                                
                            </div>

                            <div class=" carriculam-list-row">

                                <?php
                                if(count($curriculumData)>0){

                                    foreach ($curriculumData as $key => $value) {
                                        $icon = getData('lesson',array(),'lesson_id',$value['curriculum_lesson']);
                                        if($icon[0]['lesson_icon']!=''){
                                          $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$icon[0]['lesson_icon'];
                                          if(file_exists($fullUrl)){
                                            $img = base_url()."".$icon[0]['lesson_icon'];
                                          }else{
                                            $img = base_url()."app-assets/images/default_lession-38x38.png";
                                          }
                                        }else{
                                            $img = base_url()."app-assets/images/default_lession-38x38.png";
                                        }
                                ?>
                                <div class="carriculam-list">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <img src="<?php echo $img; ?>">
                                            <?= $icon[0]['lesson_title']; ?>
                                            <?php
                                             $descr = explode(" ", $value['curriculum_lesson_description']);
                                             foreach ($descr as $key1 => $value1) {
                                                 if($key1==100){

                                                    break;
                                                 }else{
                                                    echo $value1." ";
                                                 }
                                             }
                                            ?>
                                        </div>
                                        <div class="col-lg-4 text-right">
                                            <a href="<?php echo base_url()."Ct_curriculum/editCurriculumn/".$value['curriculum_id']."/".$curriculum_class."/".$curriculum_day; ?>" class="btn btn-sm btn-primary"  data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>                                            
                                            <a href="<?php echo base_url()."Ct_curriculum/getPreview/".$curriculum_class."/".$curriculum_day."/".$value['curriculum_lesson']; ?>" class="btn btn-sm btn-primary" title="Preview" data-toggle="tooltip"><i class="fa fa-play"></i></a>
                                            <a href="javascript:void(0);" title="Delete" onclick="deleteCurriculumonViewafter('<?php echo $value['curriculum_id']; ?>')" class="btn btn-sm btn-primary" data-toggle="tooltip" title="trash"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php }  } ?>

                            </div>

                            <div class="row">
                                <div class="col-lg-12 pt-3">
                                    
                                            <a href="<?php echo base_url()."Ct_curriculum/createCurriculum/".$curriculum_class."/".$curriculum_day; ?>" class="btn btn-primary mr-2">Add More Curriculum</a>
                                    
                                    
                                            <!-- <a href="<?php echo base_url()."Ct_curriculum/viewCurriculum" ?>" class="btn btn-sm btn-primary">Finish</a> -->
                                    
                                    
                                            <a href="<?php echo base_url()."Ct_curriculum/viewCurriculum" ?>" class="btn btn-outline-primary">Cancel</a>
                                    
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
                        Copyright &copy; <script>document.write(new Date().getFullYear())</script> Fundoomoms. All rights reserved.
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
    $(document).ready(function() {
                var childClass = $("#childClass").val();
                console.log(childClass);
                if(childClass == 'Early Childhood I') {
                    jQuery("#childAge").html("3 to 4 Years");
                } else if(childClass == 'Early Childhood II') {
                    jQuery("#childAge").html("4 to 5 Years");
                }
    });

    $("#overlay").fadeIn(300);



     setTimeout(function(){
        $("#overlay").fadeOut(300);
     },1000);
	
</script>