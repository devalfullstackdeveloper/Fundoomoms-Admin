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
                        <form method="post" id="createBanner" action="<?= base_url() ?>Ct_banner/addbanner"  enctype="multipart/form-data">
                            <div class="alert alert-success alert-dismissible  alert-msg successModal1" style="display: none;">
                            </div>
                            <div class="alert alert-success alert-dismissible  alert-msg errorModel" style="display: none;">
                            </div>
                            <!-- <input type="hidden" name="helpid" id="helpid" value="<?= $helpData[0]['helpid'] ?>"> -->
                            <input type="hidden" name="hsub_id" id="hsub_id" value="<?= $helpData[0]['hsub_id'] ?>">
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="bannerTitle">Title</label>
                                            <textarea name="title" id="title" tabindex="1" class="form-control input-mask"  placeholder="Title" required=""><?= $helpData[0]['title'] ?></textarea>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="bannerTitle">Category</label>
                                            <select class="form-control" name="helpid" id="helpid" required="">
                                                <option value="">--SELECT--</option>
                                                <?php
                                                foreach ($helpmain as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['help_id']; ?>" <?php if($helpData[0]['helpid']==$value['help_id']) echo "selected"; ?>><?php echo $value['title']; ?></option>
                                                <?php    
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="bannerTitle">Type</label>
                                            <select class="form-control" name="htype" id="htype" required="">
                                                <option value="">--SELECT--</option>
                                                <option value="1" <?php if($helpData[0]['htype']=="1") echo "selected"; ?>>Article</option>
                                                <option value="2" <?php if($helpData[0]['htype']=="2") echo "selected"; ?>>Video</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-lg-12 descDiv" style="<?php echo ($helpData[0]['htype']=="1") ? 'display: block;' : 'display: none;'; ?>">
                                            <label for="bannerTitle">Description</label>
                                            <textarea name="descr"><?= $helpData[0]['help_descr'] ?></textarea>
                                            <input type="hidden" name="help_descr" id="help_descr">
                                        </div>

                                        <div class="form-group col-lg-6 vidDiv" style="<?php echo ($helpData[0]['htype']=="2") ? 'display: block;' : 'display: none;'; ?>">
                                            <label for="bannerTitle">Update Video</label><br>
                                            <input type="file" name="files[]" id="video_url" style="display: none;">
                                            <button type="button" class="btn btn-primary btn-sm btnchooseimage"><i class="fa fa-upload"></i>&nbsp;Upload Video</button>
                                            <br>
                                            <span class="fileSel" style="display: none;"><b style="color: green;">File Selected</b></span>
                                        </div>

                                        <div class="form-group col-lg-6 vidPreDiv" style="<?php echo ($helpData[0]['htype']=="2") ? 'display: block;' : 'display: none;'; ?>">
                                                <?php 
                                                    if(!empty($helpData[0]['video_url'])){
                                                    $vidoes = json_decode($helpData[0]['video_url']);   

                                                    foreach ($vidoes as $key => $value) {
                                                      
                                                    $vType = explode(".", $value);
                                                ?>
                                                <video width="100" height="100" controls >
                                                    <source src="<?php echo  base_url()."".$value; ?>" type="video/<?php echo $vType[1]; ?>">
                                                </video>
                                                <?php } }  ?>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="col-lg-12 text-right">
                                    <input type="submit" class="btn btn-primary mr-2" value="Submit">
                                    <a href="<?= base_url() ?>Ct_help/index/" class="btn btn-outline-primary">Cancel</a>
                                    
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
                url : baseURL +'Ct_help/updateHelp',
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
                                
                                $(".cke_inner").addClass('border border-danger');
                                $(".cke_inner").focus();

                                // $("#"+data['data']).addClass('border border-danger');    
                                // $("#"+data['data']).focus();
                            
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