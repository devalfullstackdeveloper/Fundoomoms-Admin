<style>
    div.dataTables_wrapper div.dataTables_filter label{float: right;}
</style>
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

                        <a href="<?= base_url() ?>Ct_help/create/" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create 
                        </a>
                    </div>
                    <input type="hidden" name="" id="base_url" value="<?php echo base_url(); ?>">
                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">
                        <div class="alert alert-success alert-dismissible sucDiv" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="sucmsg"></span>
                        </div>
                        <div class="alert alert-danger alert-dismissible errDiv" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <span class="errmsg"></span>
                        </div>
                        
                        <div class="LoadList">
                            
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
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>
<script type="text/javascript">
    var baseURL = $("#base_url").val();
    $("#overlay").fadeIn(300);
    function LoadData(){
        $.post(baseURL+'Ct_help/loadHelpList',{type:'all'},function(data){
            $(".LoadList").html(data);
        });
    }

    LoadData();

    $("#overlay").fadeOut(300);
    
    $(document).on('change','.fhelp',function(){
        $.post(baseURL+'Ct_help/loadHelpList',{type:$(this).val()},function(data){
            $(".LoadList").html(data);
        });
    });


    function removeHelp(id){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_help/removeHelp";
        $.ajax({
            url:ajxUrl,
            method:"POST",
            data: {
                id:id
            },
            dataType: "json",
            success:function(data)
            {
                t.value && Swal.fire({
                    title : "Deleted!", 
                    text: "Help Removed Successfully",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
    }
</script>
