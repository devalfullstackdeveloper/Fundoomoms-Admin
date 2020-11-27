<table id="datatable-buttons1" class="table table-borderless  nowrap data1">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    
                                    <th>ID</th>
                                    <th>Vehicle Location</th>
                                    <th>Trailer Type</th>
                                    <th>Service Request Type</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Assign To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $i=1;
                                foreach ($serviceReqlist as $j => $serviceData) {
                                 $trailer = $this->Service_request->GetTrailerData($serviceData['trailer_type'])->tt_name; 
                                 $defect =  $this->Service_request->GetDefectData($serviceData['defect_detail'])->dd_name; 
                                 $status =  $this->Service_request->GetServicestatusData($serviceData['s_status'])->stext;
                                 $state = $this->Service_request->GetCityData($serviceData['region'])->ct_name;
                                  
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><u><a  href="<?= base_url() ?>Ct_service_request/AssignService/<?= $serviceData['ser_id']; ?>"><?= $serviceData['ref_id']; ?></a></u></td>
                                    <td><?= $serviceData['vehicle_location']; ?></td>
                                    <td><?= $trailer; ?></td>
                                    <td><?= $defect; ?></td>
                                    <td><?= $state; ?></td>
                                    <td><label style="cursor: pointer;" onclick="window.location.href='<?= base_url() ?>Ct_service_request/AssignService/<?= $serviceData['ser_id']; ?>'" class="badge badge-info"><?= $status; ?></label></td>
                                    <td><?php echo date("d/m/Y",strtotime($serviceData['created_date'])); ?></td>
                                    <td><?php 
                                    if(!empty($serviceData['technician'])){
                                        $techData = $this->user->getRows(array("id"=>$serviceData['technician']));
                                     if(count($techData)>0){ 
                                        echo $techData['name']; 
                                     }else{ 
                                        echo "-";
                                     }
                                    }else{
                                        
                                        echo "-";
                                    }
                                     ?>
                                         
                                     </td>
                                    <td>
                                        <?php if($_SESSION['LoginUserData']['is_admin']=="1"){ ?>
                                        <a href="<?= base_url() ?>Ct_service_request/edit/<?= $serviceData['ser_id'] ?>" class="btn btn-inline p-0 text-dark">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                                            <button class="btn btn-inline btn-sm  ml-2 p-0 text-dark" onclick="deleteService('<?= $serviceData['ser_id']; ?>');">&nbsp;<i class="fa fa-trash"></i>&nbsp;</button>
                                        <?php } ?>    
                                    </td>
                                </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                
                            </tfoot>
                        </table>

                        <input type="hidden" name="" id="cityId" value="<?php if(isset($s_state)) echo $s_state; ?>">

                        <script type="text/javascript">

    $("#datatable-buttons1").dataTable({

        initComplete: function () {

            <?php
            if($_SESSION['LoginUserData']['is_admin']=="1"){
            ?>

            var sel = '<b style="float:left;">States&nbsp;&nbsp;</b><select class="ss_state custom-select custom-select-sm" style="float:left; width: auto;" >';
            sel +='<option value="all">All</option>';
            <?php
            foreach ($stateList as $state) {
                if(isset($s_state)){
                if($state['st_id']==$s_state){
            ?>
             var select = "selected";
            <?php        
                }else{
            ?>
            var select = "";
            <?php        
                }
            }else{
            ?>
                var select = "";
            <?php    
            }
            ?>
            sel +="<option value=<?= $state['st_id'] ?> "+select+"><?= $state['st_name']; ?></option>";
            <?php
            }
            ?>
            sel +='</select>'
            $("#datatable-buttons1_filter").append(sel);

            var region = '<b style="float:left">Region&nbsp;&nbsp;</b><select class="sr_region custom-select custom-select-sm" style="float:left; width: 20%;" >'
            region +='</select>';
            $(region).insertAfter($(".ss_state"));
            <?php    
            }else{
            ?>
                var sel = '<b style="float:left;">Status&nbsp;&nbsp;</b><select class="ss_status custom-select custom-select-sm" style="float:left; width: auto;">';
            sel +='<option value="all" <?php if($statusType=="all") echo "selected"; ?>>All</option>';
            sel +='<option value="1" <?php if($statusType=="1") echo "selected"; ?>>New</option>';
            sel +='<option value="2" <?php if($statusType=="2") echo "selected"; ?>>In Process</option>';
            sel +='<option value="3" <?php if($statusType=="3") echo "selected"; ?>>Completed</option>';
            sel +='<option value="4" <?php if($statusType=="4") echo "selected"; ?>>Cancelled</option>';
            sel +='</select>';
            $("#datatable-buttons1_filter").append(sel);

            var tech = '<b style="float:left">Technician&nbsp;&nbsp;</b><select class="sr_tech custom-select custom-select-sm" style="float:left; width: 23%;">';
            tech +='<option value="all" <?php if($techdata=="all") echo "selected"; ?>>All</option>';
            <?php
            foreach ($technician as $techData) {
            ?>
            tech +="<option value=<?= $techData['id'] ?> <?php if($techData['id']==$techdata) echo "selected"; ?>><?= $techData['name']; ?></option>";
            <?php
            }
            ?>
            tech +='</select>';
            $(tech).insertAfter($(".ss_status"));

            var last = '<b><i class="mdi mdi-reload reloadSearch" style="cursor:pointer;"></i></b>';
            $(last).insertAfter("input[type=search]");
            <?php    
            }
            ?>
            
            
        }
    });


</script>