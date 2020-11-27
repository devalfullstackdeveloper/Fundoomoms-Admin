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
                        <a href="<?= base_url() ?>Ct_customer/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create Customer
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
                        <table id="datatable-buttons" class="table table-striped table-bordered  nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    
                                    <th>Customer Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($customerlist as $i => $customerlistData) {
                                ?>
                                    <tr>
                                        <td><?= ($i + 1) ?></td>
                                        <td><?= $customerlistData['cust_name'] ?></td>
                                        <td><?= $customerlistData['contact'] ?></td>
                                        <td><?= $customerlistData['email'] ?></td>
                                        <td><?= $customerlistData['address'] ?></td>
                                        <td><a href="<?= base_url() ?>Ct_customer/editCustomer/<?= $customerlistData['cust_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteCustomer(<?= $customerlistData['cust_id'] ?>);">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <!--            </div>            -->
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