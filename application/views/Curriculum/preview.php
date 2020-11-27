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
                        <a href="<?= base_url() ?>Ct_curriculum/viewCurriculum" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-reply font-size-16 align-middle mr-2 font-weight-bold"></i> Back
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <!--            <div class="row">-->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="smartphone">
                                  
                                  <div class="contentsm">
                                    <iframe src="<?= base_url() ?>Ct_curriculum/loadPreview/<?php echo $class."/".$day."/".$lesson; ?>" style="width:100%;border:none;height:100%" ></iframe>
                                  </div>

                            </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <!--            </div>            -->
        </div>
    <!-- </div>
    End Page-content

   
</div> -->
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>