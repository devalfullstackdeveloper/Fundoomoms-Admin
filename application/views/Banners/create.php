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
                        <form method="post" id="createBanner" action="<?= base_url() ?>Ct_banner/addbanner"  enctype="multipart/form-data">
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
                                            <label for="bannerTitle">Add Title (Max 25 Letters)</label>
                                            <textarea name="bannerTitle" id="bannerTitle" tabindex="1" class="form-control input-mask" maxlength="25" placeholder="Description"></textarea>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="bannerTitle">Position</label>
                                            <input type="number" min="1" max="100" maxlength="3" id="sortorder" tabindex="3" name="sortorder" class="form-control input-mask">
                                        </div>
                                        
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-4 mt-lg-0">
                                        <div class="form-group mb-4">
                                            <label for="descr">Add Description (Max 250 Characters)</label>
                                           <textarea name="descr" id="desc" tabindex="2" class="form-control input-mask" maxlength="250" placeholder="Description"></textarea>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="d-block" for="files">Upload Image</label>
                                            <p>
                                                <button type="button" onclick="$('#files').click();" id="uplBtn" class="btn btn-dark btn-sm">Choose File</button>
                                            </p>
                                            <input style="display: none;" type="file" id="files" class="form-control" name="image" >
                                            <label id="fileErr" style="display: none; color: red">Please Upload Image</label>
                                            <label class="badge badge-info">Size must be 400x300</label>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <a href="<?= base_url() ?>Ct_banner/index" class="btn btn-outline-primary mr-2">Cancel</a>
                                    <input type="button" class="btn btn-primary ml-2" onclick="BannerSubmit('add');" value="Submit">
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
                <div class="col-sm-2">
<!--                                    <script>document.write(new Date().getFullYear())</script> © Qovex.-->
                </div>
                <div class="col-sm-10">
                    <div class="text-sm-right d-none d-sm-block">
                        Copyright © <script>document.write(new Date().getFullYear())</script> York Transport Equipment (Asia) Pte Ltd. All rights reserved.
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
</script>