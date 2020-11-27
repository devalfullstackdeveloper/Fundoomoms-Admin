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

                        <a href="javascript:void(0);" class="btn york-button waves-effect waves-light mb-2 font-weight-bold uploadImageBtn">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Upload 
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">
                        
                        <div>
                        <table id="datatable-buttons1"  class="table table-borderless white-space-wrap">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="" id="allCheck"></th>
                                    <th>Sr No.</th>
                                    <th>File Name</th>
                                    <!-- <th>Link</th> -->
                                    <th>Type</th>
                                    <th>Upload Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                // die(print_r($gallaryList));
                                foreach ($gallaryList as $i => $classData) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" class="remNote" name="" id="checkId<?= $j; ?>" value="<?= $classData['image_id'] ?>"></td>
                                        <td><?= $j ?></td>
                                        <td class="ico-box op1">
                                        <?php 
                                        echo $classData['image_name'];
                                        // if($classData['type']=="2"){
                                            // $vType = explode(".", $classData['path']);
                                        ?>
                                        <!-- <video controls >
                                              <source src="<?php echo  base_url()."".$classData['path']; ?>" type="video/<?php echo $vType[1]; ?>">
                                        </video> -->
                                        <?php
                                        // }else{
                                        //     if($classData['type']=="1"){
                                        //     $img = base_url()."".$classData['path'];
                                        //    }else if($classData['type']=="3"){
                                        //     $img = base_url()."app-assets/images/pdf-file-icon.png";
                                        //    }else if($classData['type']=="4"){
                                        //      $img = base_url()."app-assets/images/docs-icon.png";
                                        //    }else if($classData['type']=="5"){
                                        //      $img = base_url()."app-assets/images/ppt-file-icon.png";
                                        //    }  
                                        ?>    
                                            <!-- <img src="<?php echo $img; ?>"> -->
                                        <?php     
                                        // }
                                        ?>
                                        </td>
                                        <!-- <td><?php echo base_url()."".$classData['path'] ?></td> -->
                                        <td class="op1"><b class="badge badge-md badge-primary"><?php if($classData['type']=="1"){
                                            echo "Image";
                                        }else if($classData['type']=="2"){
                                            echo "Video";
                                        }else if($classData['type']=="3"){
                                            echo "PDF";
                                        }else if($classData['type']=="4"){
                                            echo "Document";
                                        }else if($classData['type']=="5"){
                                            echo "PPT";
                                        }      
                                        ?>
                                            
                                        </b></td>
                                        <td><?=date('Y-m-d', strtotime($classData['added_on']))?></td>
                                        <td class="d-flex op1">
                                            
                                            <!-- <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark removePhoto" remId="<?= $classData['image_id'] ?>">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button> -->

                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary removePhoto" onclick="deleteImageGalary(<?=$classData['image_id']?>)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" remId="<?= $classData['image_id'] ?>"><i class="fa fa-trash"></i></a>

                                            <p id="p1<?php echo $j;  ?>" style="display: none;"><?php echo base_url()."".$classData['path'];  ?></p>

                                            <a onclick="copyToClipboard('#p1<?php echo $j; ?>','btnid<?php echo $j; ?>')" class="btn btn-sm btn-primary" id="btnid<?php echo $j; ?>"><i class="fa fa-copy"></i></a>

                                            
                                                

                                        </td>
                                    </tr>
                                    <?php
                                    $j++;
                                }
                                ?>
                            </tbody>
                        </table>


                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
    <!-- End Page-content -->
</div>
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


<div class="modal fade" id="UploadImageModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Upload - Video / Photo</b></h5>
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
            
          <div class="form-group text-right">
               <input type="file" name="PhotoFile" id="PhotoFile" style="display: none;">
               <a href="javascript:void(0);" class="btn btn-primary btnchooseimage"><i class="fa fa-upload"></i> Upload</a>
          </div>

          <div class="form-group">
               <label class="form-group-label">Sizes And File Types</label>
               <table class="table table-borderless">
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
                           <td>MP4, PDF, DOC, PPT</td>
                            <td>6 MB</td>
                        </tr>
                    </tbody>
               </table>
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
<script src="<?php echo base_url(); ?>app-assets/js/clipboardjs/dist/clipboard.min.js"></script>
<script type="text/javascript">
    $("#overlay").fadeIn(300);
    var baseURL = $("#baseUrl").val();
    $("#datatable-buttons1").dataTable({
        "dom" : "<'row mb-2'<'col-sm-12 col-md-6 pl-4'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "columnDefs": [ {
                        "targets": 0,
                        "orderable": false
                        },
                        { "width": "10%", "targets": 0 },
                        { "width": "10%", "targets": 1 },
                        { "width": "20%", "targets": 2 },
                        // { "width": "35%", "targets": 3 },
                        { "width": "20%", "targets": 3 },
                        { "width": "20%", "targets": 4 },
                        { "width": "20%", "targets": 5 }
 ],
        "bAutoWidth": true,
            "scrollX": true,      
            // "order": [[ 1, "desc" ]],
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50 ,100]],
            oLanguage: {
                sLengthMenu: "_MENU_",
            },
            "language": {                
                "infoFiltered": ""
            },

          initComplete: function () {
            var btn = '<button type="button" id="deleteBtn" style="float:left;" class="btn btn-sm btn-primary">Delete all</button>';
            $("#datatable-buttons1_length").append(btn);
          },   
    });

    $("#overlay").fadeOut(300);
    // new ClipboardJS('.CopyPhoto');

    function copyToClipboard(element,btnid) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      $("#"+btnid).text('copied');
    }

    $(document).on('click','#allCheck',function(){
        if($(this).prop('checked') == true){
            $(".remNote").each(function(){
                $(this).prop('checked',true);
            });
        }else{
            $(".remNote").each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $(document).on('click','#deleteBtn',function(){
        var ids = [];
        $(".remNote").each(function(){
            if($(this).prop('checked')==true){
                ids.push($(this).val());
            }
        });
        if(ids.length>0){
            $.post(baseURL+'Ct_gallary/RemoveAllImage',{imageids:ids},function(data){
                var data = JSON.parse(data);
                if(data.count==ids.length){
                    Swal.fire({
                        title : "Success!", 
                        text: "Files Removed Successfully",
                        type: "success",
                        confirmButtonColor: "#951c70",
                        confirmButtonText: "OK"
                    }).then((result) => { location.reload(); });
                }else{
                    Swal.fire({
                        title : "Error!", 
                        text: "Some file have not been deleted! please try again",
                        type: "error",
                        confirmButtonColor: "#951c70",
                        confirmButtonText: "OK"
                    }).then((result) => { });
                }   
            });
        }else{
            Swal.fire({
                    title : "Notice!", 
                    text: "Please Select atleast one checkbox",
                    type: "warning",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => { });
        }
    });
</script>
