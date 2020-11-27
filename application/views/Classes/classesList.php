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
                       
                        <table id="datatable-buttons1"  class="table table-borderless nowrap">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Child Age</th>
                                    <th class="text-center">Curriculum Days</th>
                                    <th class="text-center">Validity</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Free Days</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                foreach ($classesList as $i => $classData) {
                                    ?>
                                    <tr>
                                        <td><?= $classData['title']; ?></td>
                                        <td><?= $classData['child_age'] ?></td>
                                        <td class="text-center"><?= $classData['c_days']; ?></td>
                                        <td class="text-center"><?= $classData['validity']; ?></td>
                                        <td class="text-center"><?= $classData['price']; ?></td>
                                        <td class="text-center"><?php
                                        // if(!empty($classData['package'])){
                                        //     $package = json_decode($classData['package']);
                                        //     foreach ($package->package as $key => $value) {
                                        //     $pname = getData("tb_package",array('ptitle','package_id'),'package_id',$value);    

                                        //     if($pname[0]['package_id']=="1"){
                                        //         echo "<span class='free-user badge badge-warning'>Free Demo</span> / ";
                                        //     }else{
                                        //         echo "<span class='paid-user badge badge-success'>Full Course</span>";
                                        //     }

                                        //     }
                                        // }
                                        echo $classData['free_days'];
                                        ?></td>
                                        <td class="text-center">
                                             <a href="<?= base_url() ?>Ct_class/edit/<?= $classData['class_id'] ?>" class="btn btn-inline btn-sm btn-primary p-0 " data-toggle="tooltip" data-placement="top" data-original-title="Edit" title="edit">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <!-- <a title="delete" class=" btn-inline  ml-2 p-0 btn btn-sm btn-primary" onclick="deleteClass('<?= $classData['class_id']; ?>')">&nbsp;<i class="fa fa-trash"></i>&nbsp;</a> -->
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
    $("#overlay").fadeIn(300);
    // $("#datatable-buttons1").dataTable({
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bFilter": false,
    //     "bInfo": false,
    //     "bAutoWidth": false,
    //     "searching": false,
    //     'columnDefs': [ {
    //         'targets': [0,1,2,3,4,5,6,7], // column index (start from 0)
    //         'orderable': false, // set orderable false for selected columns
    //     }]
    // });

    $("#overlay").fadeOut(300);

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>
