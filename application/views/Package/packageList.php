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


                    <div class="page-title-right">

                        <a href="<?= base_url() ?>Ct_packages/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Package
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                        <table id="datatable-buttons1"  class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>Package Type</th>
                                    <th>Days [For Free]</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                foreach ($packageList as $i => $classData) {
                                    ?>
                                    <tr>
                                        <td><?= $classData['ptitle']; ?></td>
                                        <td><?= $classData['type'] ?></td>
                                        <td><?= $classData['days']; ?></td>
                                        <td>
                                             <a href="<?= base_url() ?>Ct_packages/edit/<?= $classData['package_id'] ?>" class="btn btn-inline p-0 text-dark" title="edit">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <button title="delete" class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deletepackage('<?= $classData['package_id']; ?>')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        </td>
                                    </tr>
                                    <?php
                                    $j++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                        
                                    </tfoot>
                        </table>
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
    $("#datatable-buttons1").dataTable({});
</script>
