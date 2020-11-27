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
                        <form method="post" id="createBanner" action="<?= base_url() ?>Ct_help/addHelp"  enctype="multipart/form-data">
                            <div class="alert alert-success alert-dismissible  alert-msg successModal1" style="display: none;">
                            </div>
                            <div class="alert alert-success alert-dismissible  alert-msg errorModel" style="display: none;">
                            </div>
                            <!-- <input type="hidden" name="helpid" id="helpid" value="<?= $helpId ?>"> -->

                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="form-group col-lg-6 mb-4">
                                            <label for="bannerTitle">Title</label>
                                            <textarea name="title" id="title" tabindex="1" class="form-control input-mask"  placeholder="Title" required=""></textarea>
                                        </div>

                                        <div class="form-group col-lg-6 mb-4">
                                            <label for="bannerTitle">Category</label>
                                            <select class="form-control" name="helpid" id="helpid" required="">
                                                <option value="">--SELECT--</option>
                                                <?php
                                                foreach ($helpData as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['help_id']; ?>"><?php echo $value['title']; ?></option>
                                                <?php    
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 mb-4">
                                            <label for="bannerTitle">Type</label>
                                            <select class="form-control" name="htype" id="htype" required="">
                                                <option value="">--SELECT--</option>
                                                <option value="1">Article</option>
                                                <option value="2">Video</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-lg-12 mb-4 descDiv">
                                            <label for="bannerTitle">Description</label>
                                            <textarea name="descr"></textarea>
                                            <input type="hidden" name="help_descr" id="help_descr">
                                        </div>

                                        <div class="form-group col-lg-6 mb-4 vidDiv" style="display: none;">
                                            <label for="bannerTitle" class="errup">Upload Video</label><br>
                                            <input type="file" name="files[]" id="video_url" style="display: none;" multiple="">
                                            <a href="javascript:void(0);" class="btn btn-info btn-sm btnchooseimage"><i class="fa fa-upload"></i>Upload</a>
                                            <br>
                                            <span class="fileSel" style="display: none;"><b style="color: green;">File Selected</b></span>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 text-right">
                                    <input type="submit" class="btn btn-primary mr-2" value="Submit">
                                    <a href="<?= base_url() ?>Ct_help/index/" class="btn btn-outline-primary ml-2">Cancel</a>
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
                Copyright &copy; <script>document.write(new Date().getFullYear())</script> Fundoomoms.All rights reserved.
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

    $("#overlay").fadeOut(300);
    $(document).on('click','.btnchooseimage',function(){
        $("#video_url").click();
    });

    $(document).on('change','#htype',function(){
        if($(this).val()=="1"){
            $(".descDiv").show();
            $(".vidDiv").hide();
        }else if($(this).val('2')){
            $(".descDiv").hide();
            $(".vidDiv").show();
        }else{
            $(".descDiv").show();
            $(".vidDiv").hide();
        }
    }); 

    $(document).on('change','#video_url',function(){
        $(".fileSel").show();
    });

    var baseURL = $("#baseUrl").val();

    $("#createBanner").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            
             $("#help_descr").val(CKEDITOR.instances.descr.getData());
             $("#overlay").fadeIn(300);
            e.preventDefault();
            
            $.ajax({
                url : baseURL +'Ct_help/addHelp',
                type : 'post',
                data : new FormData(this),
                contentType : false,
                cache : false,
                processData : false,
                success : function (data) {
                   var data = JSON.parse(data);
                   var errHtml='';
                   if(data['status']==true){
                        // alert(data['message']);
                        $("#createBanner")[0].reset();
                        $("#overlay").fadeOut(300);
                      // $(".successModal1").show();
                      // $(".successModal1").html(data['message']);

                      Swal.fire({
                            title : "Success!", 
                            text: data['message'],
                            type: "success",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           window.location.href=baseURL+'Ct_help/index';
                        });

                      setTimeout(function(){
                        $(".successModal1").hide();
                        $(".successModal1").html('');
                        
                      },2000);
                   }else{
                        // errHtml+=data['message'];
                        // $(".errorModel").html(errHtml);
                        // $(".errorModel").show();
                        // $(".processingModel").hide();
                        $("#overlay").fadeOut(300);
                        Swal.fire({
                            title : "Warning!", 
                            text: data['message'],
                            type: "warning",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                                
                                if(data['data']=='descr'){
                                    $(".cke_inner").addClass('border border-danger');
                                    $(".cke_inner").focus();
                                }else{
                                    $("#"+data['data']).addClass('border border-danger');    
                                    $("#"+data['data']).focus();
                                }

                                

                                
                            
                        });
                        setTimeout(function(){
                            $(".errorModel").html("");
                            $(".errorModel").hide();
                            
                        },6000);
                    $("#createBanner")[0].reset();
                   }
                },
                error:function(xhr){

                    if(xhr.status==500){
                        $("#createBanner")[0].reset();
                        $(".errorModel").html('Something Went Wrong! Please Try Again');
                        $(".errorModel").show();
                        $(".processingModel").hide();
                    }
                }
            });
           
        }
    });

    CKEDITOR.replace( 'descr' );
</script>