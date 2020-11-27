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

                    <div class="page-title-right ml-auto mr-3">
                        <?= $breadCrumb ?>
                    </div>


                    <div class="page-title-right">

                        <a href="<?= base_url() ?>Ct_notification/create" class="btn york-button waves-effect waves-light mb-2 font-weight-bold">
                            <i class="bx bx-plus font-size-16 align-middle mr-2 font-weight-bold"></i> Create New
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
                        
                        <table id="datatable-buttons1"  class="table table-borderless white-space-wrap">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Class</th>
                                    <th>Day Type</th>
                                    <th>User Type</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($notificationList as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?=($key + 1)?></td>
                                        <td><?=$class[$value['class_id']]?></td>
                                        <td><?=$value['day_type']?></td>
                                        <td>
                                            <?php
                                            if($value['type'] == "exusers"){
                                                echo "Specific User";
                                            }elseif ($value['type'] == "freeusers") {
                                                echo "Free Demo Users";
                                            }elseif ($value['type'] == "allusers") {
                                                echo "All Users";
                                            }elseif ($value['type'] == "premiumusers") {
                                                echo "Full Cource User";
                                            }
                                            ?>
                                        </td>
                                        <td><?php 
                                        if(!empty($value['message'])){
                                        	$msg = explode(" ", $value['message']);
                                        	foreach ($msg as $k => $v) {
                                        		if($k==10){
                                        			echo "...";
                                        			break;
                                        		}else{
                                        			echo $v." ";
                                        		}
                                        	}
                                        }
                                        ?></td>
                                        <td class="op1">
                                            <a href="<?=base_url()?>Ct_notification/edit/<?=$value['notifi_id']?>" class="btn btn-sm btn-primary" title="edit" data-toggle="tooltip" data-placement="bottom" data-original-title="Edit">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <a title="delete" class="btn btn-sm btn-primary" onclick="deleteNotification('<?= $value['notifi_id'] ?>')" data-toggle="tooltip" data-placement="bottom" data-original-title="Delete">&nbsp;<i class="fa fa-trash"></i>&nbsp;</a>
                                        </td>
                                    </tr>
                                    <?php
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
                    Copyright © <script>document.write(new Date().getFullYear())</script> Fundoomoms. All rights reserved.
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
    $("#datatable-buttons1").dataTable({
        "bAutoWidth": true,
            "scrollX": true,      
            // "order": [[ 1, "desc" ]],
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50 ,100]],
            oLanguage: {
                sLengthMenu: "_MENU_",
            },
        "columnDefs": [ {
                        "targets": 0,
                        "orderable": false
                        },
                        { "width": "50px", "targets": 0 },
                        { "width": "100px", "targets": 1 },
                        { "width": "100px", "targets": 2 },
                        { "width": "100px", "targets": 3 },
                        { "width": "200px", "targets": 4 },
                        { "width": "100px", "targets": 5 }
                    ]  
    });
    $("#overlay").fadeOut(300);
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>
