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


                    <!-- <div class="page-title-right">

                        <a href="<?= base_url() ?>Ct_class/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Class
                        </a>
                    </div>
 -->
                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">
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
                        <?php
                       // print_r($users);
                        ?>
                       <div class="loadhtml">

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
    var baseURL = $("#baseUrl").val();
    $("#overlay").fadeIn(300);

    function Loaddata(){
        $.post(baseURL+'Ct_dashboard/loadUserNotification',{class:'all',access:'all',type:'all',ntype:'all'},function(data){
            $(".loadhtml").html(data);
    });
    }

    $(document).on('change','.cClass, .access, .ntype',function(){
        var cClass = $(".cClass").val();
        var access = $(".access").val();
        var ntype = $(".ntype").val();
        $.post(baseURL+'Ct_dashboard/loadUserNotification',{class:cClass,access:access,ntype:ntype},function(data){
            $(".loadhtml").html(data);
        }); 
    });
    Loaddata();

     $("#overlay").fadeOut(300);
</script>
