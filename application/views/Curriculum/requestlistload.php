
<style>
    .dataTables_filter .custom-select, .dataTables_filter label{margin-left: 0;margin-right: 10px}
    .custom-select.custom-select-sm{max-width: 10%}
    div.dataTables_wrapper div.dataTables_filter input{max-width: 115px!important}
</style>
<table id="datatable-buttons1"  class="table table-borderless ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Parents Name</th>
                                    <th>Child Name</th>
                                    <th>Class</th>
                                    <th>Validity</th>
                                    <th>Mobile Number</th>
                                    <th>Preferred Time</th>
                                    <th>Scheduled</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $j=1;
                                foreach ($requestList as $i => $reqData) {

                                    $user = getData('user_register',array('name','child_name','mobile','class','ref_id'),"id",$reqData['user_id']);
                                    if(count($user)>0){
                                        $class = getData("tb_class",array('title'),"class_id",$user[0]['class']);
                                    }else{
                                        $class = array();
                                    }
                                    $lastSt = $this->bookcall->getLastStatus($reqData['book_id']);
                                    $validity = getValidity($reqData['user_id']);

                                    $stClass = '';
                                    $trcolor='';
                                        if($lastSt['current_status']=='1'){
                                            $stClass = 'schedule-new';
                                            
                                        }elseif($lastSt['current_status']=='2'){
                                            $stClass = 'schedule-reshedule';
                                        }elseif($lastSt['current_status']=='3'){
                                            $stClass = 'schedule-pending';
                                        }elseif($lastSt['current_status']=='4'){
                                            $stClass = 'schedule-followup';
                                        }elseif($lastSt['current_status']=='5'){
                                            $stClass = 'schedule-overdue';
                                            $trcolor='#ff8686';
                                        }elseif($lastSt['current_status']=='6'){
                                            $stClass = 'schedule-completed';
                                        }
                                    ?>
                                    <tr style="color:<?= $trcolor ?>">
                                        <td><a href="<?php echo base_url()."Ct_dashboard/CustomerDetail/".$reqData['user_id']; ?>"><?= $user[0]['ref_id'] ?></a></td>
                                        <td class="parent_name"><?php echo (count($user)>0) ? $user[0]['name'] : ''; ?></td>
                                        <td><?php echo (count($user)>0) ? $user[0]['child_name'] : ''; ?></td>
                                        <td><?php echo (count($class)>0) ? $class[0]['title'] : ''; ?></td>
                                        <td><?php echo (count($validity)) ? $validity['validity'] : ''; ?></td>
                                        <td class="op1"><?php echo (count($user)>0) ? $user[0]['mobile'] : ''; ?></td>
                                        <td><?= $reqData['prefer_time']; ?></td>
                                        <td class="op1"><?php
                                        //echo $lastSt['current_status'];
                                        
                                        ?>
                                        <select class="changeStatus <?=$stClass?>" style="cursor: pointer;">
                                            <option value="1" <?php echo ($lastSt['current_status']=='1') ? 'selected' : ''; ?> <?php echo ((int)$lastSt['current_status']>1) ? 'disabled' : ''; ?> reqId="<?= $reqData['book_id'] ?>" >New</option>
                                            <option value="2" <?php echo ($lastSt['current_status']=='2') ? 'selected' : ''; ?> <?php echo ($lastSt['current_status']>2) ? 'disabled' : ''; ?> reqId="<?= $reqData['book_id'] ?>">Reschedule Call</option>
                                            <option value="3" <?php echo ($lastSt['current_status']=='3') ? 'selected' : ''; ?> <?php echo ($lastSt['current_status']>3) ? 'disabled' : ''; ?> reqId="<?= $reqData['book_id'] ?>">Pending</option>
                                            <option value="4" <?php echo ($lastSt['current_status']=='4') ? 'selected' : ''; ?> <?php  echo ($lastSt['current_status']>4) ? 'disabled' : ''; ?> reqId="<?= $reqData['book_id'] ?>">Follow Up</option>
                                            <option value="5" <?php echo ($lastSt['current_status']=='5') ? 'selected' : ''; ?> <?php echo ($lastSt['current_status']>5) ? 'disabled' : ''; ?> reqId="<?= $reqData['book_id'] ?>">Overdue</option>
                                            <option value="6" <?php echo ($lastSt['current_status']=='6') ? 'selected' : ''; ?> <?php echo ($lastSt['current_status']>6) ? 'disabled' : ''; ?> reqId="<?= $reqData['book_id'] ?>">Completed</option>
                                        </select>
                                        <?php
                                        ?></td>
                                    </tr>
                                    <?php
                                    $j++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                        
                                    </tfoot>
                        </table>


<script type="text/javascript">
    $("#datatable-buttons1").dataTable({
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
                        { "width": "100px", "targets": 7 }
        ],
        "dom" : "<'row'<'col-sm-12 col-md-1 pl-4'l><'col-sm-12 col-md-11'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        initComplete: function () {
            var Mon = '<select class="custom-select custom-select-sm fMonth custom-all-content" >';
            <?php
            $monArr = array("01"=>"January","02"=>"February","03"=>"March","04"=>"April",
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
            // $("#datatable-buttons1_filter").append(Mon);

            var cClass = '<span>Class&nbsp;&nbsp;</span><select class="custom-select custom-select-sm cClass custom-all-content">';
            cClass +='<option value="all">All</option>';
            <?php
            foreach ($classList as $key => $value) {
            ?>
            cClass +='<option value=<?php echo $value['class_id'] ?> <?php if($fclass==$value['class_id']) echo "selected"; ?> ><?php echo $value['title']; ?></option>';
            <?php    
            }
            ?>
            cClass +='</select>';
            $(cClass).insertAfter($("#reportrange"));

            var schld = '<span>Scheduled&nbsp;&nbsp;</span><select class="custom-select custom-select-sm sch custom-all-content">'
            schld +='<option value="all">all</option>';
            schld +='<option value="1" <?php if($fstatus=="1") echo "selected"; ?>>New</option>';
            schld +='<option value="2" <?php if($fstatus=="2") echo "selected"; ?>>Reschedule Call</option>';
            schld +='<option value="3" <?php if($fstatus=="3") echo "selected"; ?>>Pending</option>';
            schld +='<option value="4" <?php if($fstatus=="4") echo "selected"; ?>>Follow Up</option>';
            schld +='<option value="5" <?php if($fstatus=="5") echo "selected"; ?>>Overdue</option>';
            schld +='<option value="6" <?php if($fstatus=="6") echo "selected"; ?>>Completed</option>';
            schld +='</select>';
            $(schld).insertAfter(".cClass");

            var donwload = '<button type="button" class="btn btn-primary btn-sm exportBtn" data-toggle="tooltip" data-placement="top" title="Export"><i class="fas fa-download"></i></button>';

            $(donwload).insertAfter('input[type="search"]');
        },    
        stateSave : true,
        oLanguage: {
                sLengthMenu: "_MENU_",
            },
    });


    setTimeout(function(){
        $("#ranges").val('<?php echo $start." - ".$end; ?>');
    },1000)
    
</script>