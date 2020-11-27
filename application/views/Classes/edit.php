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
                        <!--                        <h4 class="card-title mb-4">Example</h4>-->
                        <form method="post" id="updateClass" action="<?= base_url() ?>Ct_class/addclass"  enctype="multipart/form-data">
                            <input type="hidden" name="classid" id="classid" value="<?= $classData['class_id'] ?>">
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
                                            <label for="bannerTitle">Class Name</label>
                                            <input type="text" name="classname" id="classname" class="form-control" placeholder="Class Title" maxlength="35" value="<?= $classData['title'] ?>">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Child Age</label>
                                            <input type="text" name="child_age" id="child_age" class="form-control" maxlength="15" placeholder="Child Age" value="<?= $classData['child_age'] ?>">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" maxlength="" placeholder="Enter Price" value="<?= $classData['price'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">
                                        
                                    <div class="form-group mb-4">
                                            <label for="descr">Curriculum Days</label>
                                           <input type="text" name="curriculum_days" id="curriculum_days" class="form-control" maxlength="3" placeholder="curriculum days" value="<?= $classData['c_days'] ?>">
                                    </div>

                                     <div class="form-group mb-4" style="display: none;">
                                        <label for="descr">Packages</label>
                                        <select class="form-control select2" id="packages" name="packages[]" multiple="">
                                            <?php
                                            foreach ($packageList as $key => $value) {
                                                $pack = json_decode($classData['package']);
                                            ?>
                                            <option value="<?= $value['package_id'] ?>" selected><?= $value['ptitle'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>   
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="descr">Free Days</label>
                                        <input type="text" name="free_days" id="free_days" class="form-control" value="<?= $classData['free_days'] ?>">
                                    </div>

                                    <div class="form-group mb-4">
                                            <label for="descr">Validity</label>
                                           <input type="text" name="validity" id="validity" class="form-control" maxlength="3" placeholder="validity" value="<?= $classData['validity'] ?>">
                                    </div>


                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <input type="submit" class="btn btn-primary mr-2 btn1 " value="Submit">
                                    <button type="button" class="btn btn-primary mr-2 btn2 hideAll" style="display: none;">
                                        Please Wait...
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </button>
                                    <a href="<?= base_url() ?>Ct_class/index" class="btn btn-outline-primary ml-2 btns">Cancel</a>
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
    $("#overlay").fadeIn(300);
    setTimeout(function(){
        $("#overlay").fadeOut(300);
    },1000);
    $(".select2").select2();
</script>