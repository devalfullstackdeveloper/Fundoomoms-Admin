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
                        
                        <form method="post" id="createLesson" action="<?= base_url() ?>Ct_curriculum/addLesson"  enctype="multipart/form-data">
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
                                    <div>
                                        <div class="form-group mb-4">
                                            <?php
                                            // $class_1 = $class_2 = '';
                                            // $child_class = urldecode($child_class);
                                            // if($child_class == 'Early Childhood I') {
                                            //     $class_1 = "selected='selected'";
                                            // } elseif($child_class == 'Early Childhood II') {
                                            //     $class_2 = "selected='selected'";
                                            // }
                                            ?>
                                            <label for="child_class">Class</label>
			                                <select id="child_class" name="child_class" class="form-control select2" disabled="disabled">
			                                	 <?php
                                                    foreach ($classList as $key => $value) {
                                                    ?>
                                                    <option value="<?= $value['class_id'] ?>" childAge="<?= $value['child_age'] ?>" <?php if($value['class_id']==$child_class) echo "selected"; ?>><?= $value['title'] ?></option>
                                                    <?php    
                                                    }
                                                ?>
			                                </select>
                                        </div>

                                        <input type="hidden" name="childClass" id="childClass" value="<?php echo $child_class; ?>">
                                        
                                        <div class="form-group mb-4">
                                            <label for="lesson_title">Lesson Title</label>
                                            <input type="text" id="lesson_title" maxlength="50" tabindex="1" name="lesson_title" class="form-control input-mask">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">
                                    	<div class="form-group mb-4 mt-4">
                                            <?php
                                            $cAge = getData('tb_class',array('child_age'),'class_id',$child_class);
                                            ?>
                                            <h6>Child Age</h6><span id="childAge"><?php echo (count($cAge)>0) ? $cAge[0]['child_age'] : '';  ?></span>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                            <label class="d-block" for="files">Upload Icon</label>
                                            <p>
                                                <button type="button" onclick="$('#files').click();" id="uplBtn" class="btn btn-primary btn-sm">Choose File</button>
                                            </p>
                                            <input style="display: none;" type="file" id="files" class="form-control" name="image" >
                                            <label id="fileErr" style="display: none; color: red">Please Upload Icon</label>
                                            <label id="infoErr" class="infoErr" style=" color: red">.png, .svg files only</label><br>
                                            <label id="infoErr" class="infoErr" style=" color: red">max file size 15KB</label>
                                    </div>

                                </div>
                                <div class="col-lg-12 text-right">
                                    <input type="button" class="btn btn-primary ml-2 mr-2" onclick="LessonSubmit('add');"  value="Submit">
                                    <a href="<?=base_url()?>Ct_curriculum/viewLesson" class="btn btn-outline-primary mr-2 cncle">Cancel</a>
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

    $("#overlay").fadeIn(300);

    $(document).ready(function() {
                var childClass = $("#childClass").val();
                console.log(childClass);
                if(childClass == 'Early Childhood I') {
                    jQuery("#childAge").html("3 to 4 Years");
                } else if(childClass == 'Early Childhood II') {
                    jQuery("#childAge").html("4 to 5 Years");
                }

                if(window.File && window.FileList && window.FileReader) {
                    $("#files").on("change",function(e) {
                        var files = e.target.files ,
                            filesLength = files.length ;
                        for (var i = 0; i < filesLength ; i++) {
                            var f = files[i]
                            var fileReader = new FileReader();
                            fileReader.onload = (function(e) {
                                var file = e.target;
                                var file = e.target;
                                $(".remove").click();
                                $(".imgDiv").remove();
                                $("<span class=\"pip\">" +
                                    "<img width='100' height='100' class=\"imageThumb remove\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                                    "" +
                                    "</span>").insertAfter("#files");
                                $(".remove").click(function(){
                                    $(this).parent(".pip").remove();
                                });
                                /*$("<img></img>",{
                                    class : "imageThumb",
                                    src : e.target.result,
                                    title : file.name
                                }).insertAfter("#files");*/
                            });
                            fileReader.readAsDataURL(f);
                        }
                    });
                } else { alert("Your browser doesn't support to File API") }
            });

            $(document).on('click','.removeD',function(){
                $(this).parents('.imgDiv').find('.pImg').val($(this).attr('imgname'));
               $(this).parent(".pip").remove();
            });
            
       $("#overlay").fadeOut(300);     
</script>