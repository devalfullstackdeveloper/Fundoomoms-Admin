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
                            <input type="hidden" name="curriculum_id" id="curriculum_id" value="<?= $curriculumData[0]['curriculum_id'] ?>">
                            
                            <input type="hidden" name="childClass" id="childClass" value="<?php echo $curriculum_class; ?>">

                            <input type="hidden" name="curriculum_day" id="curriculum_day" value="<?php echo $curriculum_day; ?>">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        
                                        <div class="col-lg-6">
                                             <?php
                                            $class_1 = $class_2 = '';
                                            $child_class = urldecode($curriculum_class);
                                            if($child_class == 'Early Childhood I') {
                                                $class_1 = "selected='selected'";
                                            } elseif($child_class == 'Early Childhood II') {
                                                $class_2 = "selected='selected'";
                                            }
                                            ?>
                                             <div class="form-group mb-4">
                                                    <label for="child_class">Class</label>
                                                    <select id="child_class" name="child_class" class="form-control select2" disabled="disabled">
                                                        <?php
                                                        foreach ($classList as $key => $value) {
                                                        ?>
                                                        <option value="<?= $value['class_id'] ?>" <?php if($child_class==$value['class_id']) echo "selected"; ?>><?= $value['title']; ?></option>
                                                        <?php    
                                                        }
                                                        ?>
                                                    </select>
                                              </div>
                                        </div>

                                        <?php
                                            $getCdata = getData('tb_class',array(),'class_id',$curriculum_class);
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="mt-4 mt-lg-0">
                                                <div class="form-group mb-4">
                                                    <h6>Child Age</h6><span id="childAge"><?php echo (count($getCdata)>0) ? $getCdata[0]['child_age'] : ''; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3">
                                             <a href="javascript:void(0);" class="btn btn-primary uploadImageBtn">Browse Image</a>
                                        </div>


                                    </div>

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="lesson">Curriculum Day</label>
                                                <input type="text" class="form-control" value="<?php echo $curriculum_day; ?>" readonly>
                                            </div>
                                        </div>

                                        <?php
                                         //echo $curriculumData[0]['curriculum_lesson'];
                                        ?>  

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="lesson">Lesson</label>
                                                <select id="lesson" name="lesson" class="form-control select2">
                                                    <option value="">Select Lesson</option>
                                                    <?php foreach ($lessons as $key => $lesson) {
                                                    ?>
                                                        <option value="<?= $lesson['lesson_id'] ?>" 
                                                            <?php if($curriculumData[0]['curriculum_lesson']==$lesson['lesson_id']){ echo "selected"; } ?>><?= $lesson['lesson_title'] ?></option>
                                                    <?php    
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label for="curriculum_description">Description</label>
                                                <textarea name="descr"><?= $curriculumData[0]['curriculum_lesson_description'] ?></textarea>
                                                <input type="hidden" name="curriculum_description" id="curriculum_description" value="<?php echo strip_tags($curriculumData[0]['curriculum_lesson_description']) ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-5 MobileDiv">

                                     

                                </div>


                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="submit" class="btn btn-primary ml-2"  value="Submit">
                                    <a href="<?=base_url()?>Ct_curriculum/viewCurriculum" class="btn btn-outline-primary mr-2">Cancel</a>
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

<div class="modal fade" id="UploadImageModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Upload / View Photo</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="UPLOADIMAGEFORM" method="post" enctype="multipart/form-data">
        
      <div class="modal-body">
            <div class="alert alert-warning processingModel " style="display: none;">
                Uploading&nbsp;&nbsp;&nbsp;<i class="fa fa-spinner fa-spin"></i>    
            </div>
            <div class="alert alert-danger errorModel " style="display: none;">
                
            </div>
           <div class="alert alert-success successModal1 " style="display: none;">
                    
            </div>

            <div class="form-group">
               <div class="row">
                <div class="col-lg-12">
                    <label class="form-group-label">Select Type</label>
                    <select class="form-control" id="uploadType" name="uploadType" style="cursor: pointer;">
                        <option value="">--Select Type--</option>
                        <option value="1">Image</option>
                        <option value="2">Video</option>
                        <option value="3">Pdf</option>
                        <option value="4">Docs</option>
                        <option value="5">PPT</option>
                    </select>
                </div>
               </div>
          </div>  

          <div class="form-group">
               <input type="file" name="PhotoFile" id="PhotoFile" style="display: none;">
               <button type="button" class="btn btn-primary btn-sm btnchooseimage"><i class="fa fa-upload"></i>Upload</button>

          </div>

          <div class="form-group">
               <label class="form-group-label">Sizes And File Types</label>
               <table class="table table-bordered table-striped" border="1">
                    <thead>
                        <th>File Types</th>
                        <th>Maximum Size</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>GIF, JPEG, PNG, JPG</td>
                            <td>2 MB</td>
                        </tr>
                        <tr>
                            <td>MP4, PDF, DOC</td>
                            <td>6 MB</td>
                        </tr>
                    </tbody>
               </table>
          </div>

          <div class="form-group PhotoLinks">
            
          </div>
                  
      </div>
      <div class="modal-footer text-left">

      </div>

      </form>
    </div>
  </div>
</div>
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>
<!-- <script src="<?php echo base_url(); ?>app-assets/js/clipboardjs/dist/clipboard.min.js"></script> -->
<script type="text/javascript">
    setTimeout(function(){
        InstantPreview(CKEDITOR.instances['descr'].getData(),$("#lesson").val());
    },1000);

     $("#overlay").fadeIn(300);

     setTimeout(function(){
        $("#overlay").fadeOut(300);
     },1000);
        

    //  function copyToClipboard(element,btnid) {

    //   var $temp = $("<input>");
    //   $("body").append($temp);
    //   $temp.val($(element).text()).select();
      
    //   document.execCommand("copy");
    //   $temp.remove();
    //   $("#"+btnid).text('copied');
    // }   
</script>