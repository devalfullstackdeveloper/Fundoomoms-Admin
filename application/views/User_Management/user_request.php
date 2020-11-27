<h5>Requests for an Appointment</h5>
	<table id="reqappt" class="table table-borderless nowrap">
		<tbody>
			<?php
               if(count($requestList)>0){
                    foreach ($requestList as $key => $value) {

                    $stClass = '';
                    if($value['current_status']=='1'){
                        $stClass = 'schedule-new';
                    }elseif($value['current_status']=='4'){
                        $stClass = 'schedule-followup';
                    }elseif($value['current_status']=='3'){
                        $stClass = 'schedule-pending';
                    }elseif($value['current_status']=='6'){
                        $stClass = 'schedule-completed';
                    }elseif($value['current_status']=='2'){
                        $stClass = 'schedule-reshedule';
                    }elseif($value['current_status']=='5'){
                        $stClass = 'schedule-overdue';
                    }   
               ?>
                    <tr class="mom-list-row" onclick="ShowRequestDetail('<?= $value['book_id']; ?>');" style="cursor: pointer;">
                         <td class="op1" width="150px">
                              <h6>Preferred Time <?php  ?></h6>
                              <span><b><?= strtoupper($value['prefer_time']); ?></b></span>
                         </td>
                         <td class="op1">
                              <h6>Scheduled</h6>
                              <span><label class="badge badge-md badge-primary <?= $stClass ?>"><?php echo statusText($value['current_status']); ?></label></span>
                         </td>
                         <td class="op1">
                              <h6>Created Date</h6>
                              <span><b><?php echo date("M d",strtotime($value['created_at'])); ?></b></span>
                         </td>
                         <td class="op1"><span class="toggle-icon"><i class="bx bx-chevron-right"></i></span></td>
                    </tr>
               <?php     

                    }
               }else{
               ?>
               <tr>
                    <td colspan="4" align="center"><b class="no-data">No Records Found</b></td>
               </tr>
               <?php     
               }
               ?>
		</tbody>
	</table>
<script type="text/javascript">
     // $("#reqappt").dataTable({
     //      "bLengthChange": false,
     //      "bInfo": false,
     //      "searching": false,
     // });
     ShowRequestDetail('<?= $requestList[0]['book_id'] ?>');
</script>
