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
                    </div> -->

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url(); ?>">
                        <div class="alert alert-primary alert-dismissible sucDiv mb-3" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="sucmsg"></span>
                        </div>
                        <div class="alert alert-danger alert-dismissible errDiv" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <span class="errmsg"></span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 pt-3 text-right">
                                
                            </div>
                        </div>
                        <div class="LoadRequest">
                            
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
    
    $(document).on('click','.exportBtn',function(){
        var cls  = $(".cClass").val();
        var explode = $("#ranges").val();
        explode = explode.split('-');
        var start = new Date(explode[0]);
        var end = new Date(explode[1]);
        var smom = moment(start);
        var smomdate = smom.format('YYYY-MM-DD');

        var emom = moment(end);
        var emomdate = emom.format('YYYY-MM-DD');

        var status = $(".sch").val();
        var url = decodeURI(baseURL+'Ct_bookrequest/ExportRequest/'+smomdate+'/'+emomdate+'/'+cls+'/'+status);

        // alert(baseURL+'Ct_bookrequest/ExportRequest/'+start+'/'+end+'/'+cls+'/'+status);
        window.location.href=url;
    });

    // function loadBook(){
    // var cmonth = '<?php echo date('m'); ?>';
    // var sclass = 'all';
    // var sch = 'all';
    //     $.post(baseURL+'Ct_bookrequest/requestLoad',{fmonth:cmonth,fclass:sclass,fstatus:sch,fromlist:'1'},function(data){
    //         $(".LoadRequest").html(data);
    //     });
    // }
    setTimeout(function(){
    $("#overlay").fadeIn(300);
        // loadData1('<?= date("Y-m-01") ?>','<?= date("Y-m-t") ?>','all','all');
    $("#overlay").fadeOut(300);
},1000);
</script>
