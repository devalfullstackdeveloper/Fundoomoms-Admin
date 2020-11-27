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
                        <form method="post" id="editBanner" action="<?= base_url() ?>Ct_banner/addbanner"  enctype="multipart/form-data">
                            <div class="alert alert-success alert-dismissible  alert-msg successModal1" style="display: none;">
                            </div>
                            <div class="alert alert-danger alert-dismissible  alert-msg errorModel" style="display: none;">
                            </div>
                            <!-- <input type="hidden" name="helpid" id="helpid" value="<?= $helpData[0]['helpid'] ?>"> -->
                            <input type="hidden" name="s_id" id="s_id" value="<?= $syllabusData[0]['sl_id'] ?>">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>

                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Class</label>
                                            <select class="form-control" name="s_for" id="s_for" required="">
                                                <option value="">--SELECT--</option>
                                                <?php
                                                foreach ($classList as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['class_id']; ?>" <?php if($syllabusData[0]['s_for']==$value['class_id']) echo "selected"; ?>><?php echo $value['title']; ?></option>
                                                <?php    
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        
                                        
                                        <div class="form-group mb-4 descDiv" >
                                            <label for="bannerTitle">Description</label>
                                            <textarea name="descr"><?= $syllabusData[0]['description'] ?></textarea>
                                            <input type="hidden" name="description" id="description">
                                        </div>

                                        
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 text-right">
                                    <input type="submit" class="btn btn-primary mr-2" value="Submit">
                                    <a href="<?= base_url() ?>Ct_syllabus/index/" class="btn btn-outline-primary ml-2">Cancel</a>
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
   

  
    
</script>