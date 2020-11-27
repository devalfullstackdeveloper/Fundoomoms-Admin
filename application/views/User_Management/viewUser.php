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

                    <?php
                    /* _P_1 is Create Permission */
                    if($role_id == 1 || in_array($active_menu."_P_1", $permission)){
                       ?>
                    <div class="page-title-right">
                        <a href="<?= base_url() ?>Ct_dashboard/createUser" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Add
                        </a>
                    </div>
                    <?php
                    }else{
                        echo $breadCrumb;
                    }
                    ?>
                    
                     <input type="hidden" name="" id="base_url" value="<?php echo base_url(); ?>">
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-4">
                <div class="card m-0 p-0">
                    <div class="card-body m-0 p-0">
                        <div class="count-box count-heading-top">
                        	<?php
                            	$moms = getMultiWhere('user_register',array(),array('role'=>'5','status'=>'1'),'1');
                            ?>                    
                	        <div class="count-img"><img src="<?= base_url() ?>app-assets/images/Group 1117@2x.png" /></div>
                            <div class="count-content"><span class="featured-count"><?php echo $totActiveMoms['totMoms'];/*$moms*/ ?></span><br /><p>Grand Total of Mom’s</p></div>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="col-md-4">
                <div class="card m-0 p-0">
                    <div class="card-body m-0 p-0">
                        <div class="count-box count-heading-top">
                        	<?php
                            	 $moms = getMultiWhere('user_register',array(),array('class'=>'1','role'=>'5','status'=>'1'),'1');
                            ?>
                        	<div class="count-img bg-blue"><img src="<?= base_url() ?>app-assets/images/Group 1118@2x.png" /></div>
                            <div class="count-content"><span class="featured-count"><?php echo $totEarlyChild1['totMoms']; /*$moms;*/ ?></span><br /><p>Early Childhood I</p></div>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="col-md-4">
                <div class="card m-0 p-0">
                    <div class="card-body m-0 p-0">
                        <div class="count-box count-heading-top">
                        	<?php
                            	$moms = getMultiWhere('user_register',array(),array('class'=>'2','role'=>'5','status'=>'1'),'1');
                            ?>
                        	<div class="count-img bg-blue1"><img src="<?= base_url() ?>app-assets/images/Group 1119@2x.png" /></div>
                            <div class="count-content"><span class="featured-count"><?php echo $totEarlyChild2['totMoms']; /*$moms;*/ ?></span><br /><p>Early Childhood II</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4" data-select2-id="12">
            <div class="col-12">
                <div class="card">
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
                    <div class="LoadList">
                            
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
                    Copyright © <script>document.write(new Date().getFullYear())</script> Fundoomoms. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); 
$currentMonth = date("m");
?>

<script type="text/javascript">
    var baseURL = $("#base_url").val();
    $("#overlay").fadeIn(300);

    loadData1('<?= date("Y-m-01") ?>','<?= date("Y-m-t") ?>','all','all','all');

    // function loadData(start,end,cClass,access,status){
    //     // alert(start+' '+end+' '+cClass+' '+access+' '+status);
    //     $.post(baseURL+'Ct_dashboard/loaduserList',{start:start,end:end,class:cClass,access:access,status:status},function(data){
    //         $(".LoadList").html(data);
    //     });
    // }
    
    //loadData();
    $("#overlay").fadeOut(300);

    
    
    

    $(document).on('click','.exportBtn',function(){
        var months = {
            'January' : '01',
            'February' : '02',
            'March' : '03',
            'April' : '04',
            'May' : '05',
            'June' : '06',
            'July' : '07',
            'August' : '08',
            'September' : '09',
            'October' : '10',
            'November' : '11',
            'December' : '12'
        }
        var cmonData = $("#reportrange span").text();
        // var cdata = cmonData.split(" ");
        // var cmon = months[cdata[0]];
        explode = cmonData.split('-');
        var start = new Date(explode[0]);
        var end = new Date(explode[1]);
        var smom = moment(start);
        var smomdate = smom.format('YYYY-MM-DD');

        var emom = moment(end);
        var emomdate = emom.format('YYYY-MM-DD');

        // var cmon = $(".fMonth").val();
        var cls = $(".cClass").val();
        var access = $(".access").val();
        // window.location.href=baseURL+'Ct_dashboard/ExportMomsList/'+cmon+'/'+cls+'/'+access;
        window.location.href=baseURL+'Ct_dashboard/ExportMomsList/'+smomdate+'/'+emomdate+'/'+cls+'/'+access;
        // var url = decodeURI(baseURL+'Ct_bookrequest/ExportRequest/'+smomdate+'/'+emomdate+'/'+cls+'/'+status);
    });
</script>
<style>
    .sidelabel {
    text-align: left !important; 
}
    </style>