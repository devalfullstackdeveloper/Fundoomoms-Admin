 <table id="datatable-buttons1" class="table table-borderless white-space-wrap wp-100">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Parents Name</th>
                                    <th>Child Name</th>
                                    <th>Class</th>
                                    <th>Mobile Number</th>
                                    <th>Access</th>
                                    <th>Type</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                             if(count($users)>0){
                                foreach ($users as $key => $value) {

                                    if(array_key_exists('noused',$value)){
                                        $type = "Not Used";
                                        $userData = getMultiWhere('user_register',array('id','name','child_name','class','mobile','added_on'),array('id'=>$value['noused']));
                                    }else if(array_key_exists('noahed', $value)){
                                        $type = "Not Used From Fifteen Days";
                                        $userData = getMultiWhere('user_register',array('id','name','child_name','class','mobile','added_on'),array('id'=>$value['noahed']));
                                    }

                                    
                                if(count($userData)>0){    
                                    $payment = getData('payment_details',array('user_id','pay_status'),'user_id',$userData[0]['id']);
                                    $class = getData('tb_class',array('title'),'class_id',$userData[0]['class']);
                             ?>
                                <tr>
                                    <td><?= $userData[0]['id']; ?></td>
                                    <td><?= $userData[0]['name']; ?></td>
                                    <td><?= $userData[0]['child_name']; ?></td>
                                    <td><?php echo (count($class)>0) ? $class[0]['title'] : ''; ?></td>
                                    <td class="op1"><?= $userData[0]['mobile']; ?></td>
                                    <td class="op1"><?php if($payment[0]['pay_status']=="1"){
                                            echo "<label class='paid-user badge badge-md badge-success'>Full Course</label>";
                                            // echo "full";
                                        }else{
                                            echo "<label class='free-user badge badge-md badge-warning'>Free Demo</label>";
                                            // echo "free";
                                        } ?></td>
                                    <td><?= $type; ?></td>
                                    <td><?php echo (!empty($userData[0]['added_on'])) ? date("d-m-Y",strtotime($userData[0]['added_on'])) : ''; ?></td>
                                </tr>
                             <?php       
                                    }
                                }
                             }
                             ?>       
                            </tbody>
                            
                        </table>

<script type="text/javascript">
    $("#datatable-buttons1").dataTable({
        "scrollX": true,
        "autoWidth": false,
        "columnDefs": [ {
                        "targets": 0,
                        "orderable": false
                        },
                        { "width": "50px", "targets": 0 },
                        { "width": "100px", "targets": 1 },
                        { "width": "100px", "targets": 2 },
                        { "width": "100px", "targets": 3 },
                        { "width": "100px", "targets": 4 },
                        { "width": "70px", "targets": 5 },
                        { "width": "100px", "targets": 6 },
                        { "width": "100px", "targets": 7 }
        ],
        "dom" : "<'row'<'col-sm-12 col-md-1 pl-4'l><'col-sm-12 col-md-11'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

         initComplete: function () {
            var cClass = '<span style="float:left; width: auto;">Class&nbsp;&nbsp;</span><select class="custom-select custom-select-sm cClass custom-all-content" style="float:left; width: auto;" >';
            cClass +='<option value="all">--All--</option>';
            <?php
            foreach ($classList as $key => $value) {
            ?>
            cClass +='<option value=<?php echo $value['class_id'] ?> <?php if($fclass==$value['class_id']) echo "selected"; ?> ><?php echo $value['title']; ?></option>';
            <?php    
            }
            ?>
            cClass +='</select>';
            $("#datatable-buttons1_filter").append(cClass);

            var acc = '<span style="float:left; width: auto;">Access</span><select class="custom-select custom-select-sm access" style="float:left; width: auto;">';
                acc +='<option value="all" >--All--</option>';
                acc +='<option value="0" >Free Demo</option>';
                acc +='<option value="1" >Full Course</option>';
                acc +='<select>';

                $(acc).insertAfter($(".cClass"));

            var ntype = '<span style="float:left; width: auto;">Type</span><select class="custom-select custom-select-sm ntype" style="float:left; width: auto;">';
                ntype +='<option value="all" >--All--</option>';
                ntype +='<option value="0" >No Used</option>';
                ntype +='<option value="1" >No ahed</option>';
                ntype +='<select>';

                $(ntype).insertAfter($(".access"));    
            // $(cClass).insertAfter($(".fMonth"));
         }, 

        "bAutoWidth": false,
            "scrollX": true,      
            //"order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50 ,100]],
            oLanguage: {
                sLengthMenu: "_MENU_",
            },
    });
</script>