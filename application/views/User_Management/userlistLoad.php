<style>
    .dataTables_filter .custom-select, .dataTables_filter label{margin-right: 10px}
    .dataTables_filter label{float: right;}
    .custom-select.custom-select-sm{max-width: 10%;min-width: 55px;}
    div.dataTables_wrapper div.dataTables_filter input{max-width: 115px!important}
</style>

<div class="row">
    <div class="col-md-6">
        <h4 class="card-title list-title">Mom's List</h4>
    </div>
    <div class="col-md-6 text-right">
        <!-- <button type="button" class="btn btn-primary btn-sm exportBtn mt-3 mr-3">Export</button> -->
        <button type="button" class="btn btn-primary btn-sm exportBtn mt-3 mr-3" data-toggle="tooltip" data-placement="top" title="Export"><i class="fas fa-download"></i></button>
    </div>
</div>

<table id="datatable-buttons1" class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID </th>
                                    <th>Parents Name</th>
                                    <th>Child Name</th>
                                    <th>Class</th>
                                    <th>Validity</th>
                                    <th>Mobile Number</th>
                                    <th>Curriculum<br />Completed Days</th>
                                    <th>Access</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
                                
                                if($userList) {
                                foreach ($userList as $i => $userData) {
                                    if($userData['role'] != 1){
                                $inactive = getInactiveUser();
                                $payment = getData('payment_details',array('user_id,pay_status'),'user_id',$userData['id']);
                                $class = getData('tb_class',array('title'),'class_id',$userData['class']);
                                if(!empty($userData['user_img'])){
                                    $image=$userData['user_img'];
                                }else{
                                    $image = 'app-assets/images/default-user.png';
                                }

                                if(in_array($userData['id'], $inactive)){
                                    $userSt = "in-active";
                                    $activeclass = '<span class="inactive-circle"></span>';    
                                }else{
                                    $userSt = "active";
                                    $activeclass = '<span class="active-circle"></span>'; 
                                    
                                }
                                
                                if(count($payment)>0){            
                                    if(empty($userData['is_view'])){
                                        $trcolor = "";
                                    }else if($userData['is_view']=="0"){
                                        $trcolor = "#ded7d7";
                                    }else{
                                        $trcolor = "";
                                    }
                                ?>
                                    <tr style="">
                                        <td><?= $activeclass ?><a href="<?= base_url() ?>Ct_dashboard/CustomerDetail/<?= $userData['id'] ?>"><?= $userData['ref_id'] ?></a>&nbsp;&nbsp;</td>
                                        <td class="parent_name"><?php
                                        if(!empty($userData['user_img'])){
                                            $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$userData['user_img'];
                                            if(file_exists($fullUrl)){
                                                $image = $userData['user_img'];
                                                
                                            }else{
                                                $image = 'app-assets/images/default-user.png';
                                                
                                            }   
                                        ?>    
                                            <img class="img-fluid" src="<?= base_url().$image ?>" />&nbsp;<?= $userData['name'] ?>
                                        <?php     
                                        }else{

                                        ?>
                                             <img class="" src="<?= base_url().$image ?>" />

                                            &nbsp;<?= $userData['name'] ?>
                                        <?php    
                                        }
                                        ?>
                                        </td>
                                        <td><?= isset($userData['child_name']) && $userData['child_name'] != "" ? $userData['child_name'] : 'N/A' ?></td>
                                        <td><?php
                                        echo (count($class)>0) ? $class[0]['title'] : 'N/A';
                                        ?>
                                        </td>
                                        <td><?php 
                                        if(count($payment)>0){
                                            $validity = getValidity($userData['id']);
                                            if(isset($validity) && $validity != ""){
                                                echo $validity['validity'];    
                                            }else{
                                                echo 'N/A';    
                                            }                                            
                                        }else{
                                            echo 'N/A';    
                                        }
                                        ?>
                                        </td>
                                        <td><?= isset($userData['mobile']) && $userData['mobile'] != "" ? $userData['mobile'] : 'N/A' ?></td>
                                        <td><?php 
                                        if(count($payment)>0){
                                            $validity = getValidity($userData['id']);
                                            echo $validity['completed'];
                                        }else{
                                            echo 'N/A';
                                        }
                                        ?>
                                        </td>
                                        <td class="op1"><?php 
                                        // echo count($payment);
                                        if(count($payment)> 0){
                                            if($payment[0]['pay_status'] > 0){
                                                echo "<label class='paid-user badge badge-md badge-success'>Full Course</label>";
                                            }else{
                                                echo "<label class='free-user badge badge-md badge-warning'>Free Demo</label>";    
                                            }
                                            
                                            // echo "full";
                                        }else{
                                            echo 'N/A';
                                            // echo "free";
                                        }
                                        ?>
                                        </td>
                                        
                                        <td><?php echo date("d-M-Y", strtotime($userData['added_on'])); ?></td>
                                        
                                    <?php } ?>
                                    </tr>
                                    <?php
                                    }
                                    }
                                }
                                ?>
                            </tbody>
                            
                        </table>


                        <script type="text/javascript">
    $(document).ready(function() {
    
  		$('[data-toggle="tooltip"]').tooltip();   
	

        var table =  $('#datatable-buttons1').DataTable({
            "scrollX": true,
            "autoWidth": false,
            "columnDefs": [ {
                            "targets": 0,
                            "orderable": false
                            },
                            { "width": "70px", "targets": 0 },
                            { "width": "100px", "targets": 1 },
                            { "width": "100px", "targets": 2 },
                            { "width": "100px", "targets": 3 },
                            { "width": "70px", "targets": 4 },
                            { "width": "100px", "targets": 5 },
                            { "width": "100px", "targets": 6 },
                            { "width": "100px", "targets": 7 },
                            { "width": "100px", "targets": 8 }
            ],
            "dom" : "<'row mb-2'<'col-sm-12 col-md-1 pl-4 actinc'l><'col-sm-12 col-md-11'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "bAutoWidth": true,
            "scrollX": true,      
            "order": [[ 0, "desc" ]],
            // "lengthMenu": [[10, 10, 25, 50], ["10", 10, 25 ,50]],
            // oLanguage: {
            //     sLengthMenu: "_MENU_",
            // },
            "bLengthChange" : false, //thought this line could hide the LengthMenu
            "bInfo":false, 

            
            initComplete: function () {
                var Mon1 = '<select class="custom-select custom-select-sm activeStatus selectpicker">';
                    Mon1 += '<option value = "all" <?php if($status=='all') echo "selected"; ?>>All</option>';
                    Mon1 += '<option value = "active" <?php if($status=='active') echo "selected"; ?> data-thumbnail="<?= base_url()."app-assets/images/avatar-1.jpg" ?>">Active</option>';
                    Mon1 += '<option value = "inactive" <?php if($status=='inactive') echo "selected"; ?>>inactive</option>';
                    Mon1 += '</select>';   
                $(".actinc").append(Mon1);             

                var Mon = '<select class="custom-select custom-select-sm fMonth">';
                <?php
                $monArr = array("all"=>"All","01"=>"January","02"=>"February","03"=>"March","04"=>"April",
                            "05"=>"May","06"=>"June","07"=>"July","08"=>"August",
                            "09"=>"September","10"=>"October","11"=>"November","12"=>"December");
                foreach ($monArr as $key => $value) {
                    $selected = "";
                    if(!empty($fmonth)){
                        if($fmonth==$key){
                            $selected = 'selected';
                        }
                    }else{
                        $currentMonth = date("m");
                        if($currentMonth == $key){
                            $selected = 'selected';
                        }    
                    }
                    
                    // $selected = ($key==date("m")) ? 'selected' : '';
                    // $cName = ($key==date("m")) ? $printM='This Month' : $printM = $value;
                    $cName = ($key==date("m")) ? $printM=$value : $printM = $value;
                ?>
                Mon +='<option value="<?php echo $key ?>" <?php echo $selected; ?>><?php echo $printM; ?></option>';
                <?php
                }
                ?>
                Mon +='</select>';

                var date1 = '<div id="reportrange" class="custom-date" style="float:left;">';
                    // date1 +='<i class="fa fa-calendar"></i>&nbsp;';
                    date1 +='<span></span> <i class="bx bx-calendar"></i>';
                    date1 +='</div><input type="hidden" id="ranges">';

                $("#datatable-buttons1_filter").append(date1);

                var cClass = '<span>Class</span><select class="custom-select custom-select-sm cClass">';
                cClass +='<option value="all" <?php if($cClass=='all') echo "selected"; ?>>All</option>';
                <?php
                foreach ($classList as $key => $value) {
                ?>
                cClass +='<option value=<?php echo $value['class_id'] ?> <?php if($cClass==$value['class_id']) echo "selected"; ?>><?php echo $value['title']; ?></option>';
                <?php    
                }
                ?>
                cClass +='</select>';
                $(cClass).insertAfter($("#reportrange"));

                var acc = '<span>Access</span><select class="custom-select custom-select-sm access">';
                acc +='<option value="all" <?php if($access=='all') echo "selected"; ?>>All</option>';
                acc +='<option value="freedemo" <?php if($access=='freedemo') echo "selected"; ?>>Free Demo</option>';
                acc +='<option value="fullcourse" <?php if($access=='fullcourse') echo "selected"; ?>>Full Course</option>';
                acc +='<select>';

                $(acc).insertAfter($(".cClass"));
            },

            

        });
       
    });

    setTimeout(function(){
        $("#ranges").val('<?php echo $start." - ".$end; ?>');
    },1000)
    


</script>