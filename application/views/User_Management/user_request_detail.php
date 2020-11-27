 <?php

 if(count($requestData)>0){

 $help = getData("tb_help",array("title"),"help_id",$requestData[0]['request_for']);
 $lesson = getData('lesson',array('lesson_title'),'lesson_id',$requestData[0]['lesson']);
 ?>                         

<div class="row mb-4">
    <div class="col-lg-6">
        <h6>Query Type</h6>
        <b><?php echo (count($help)>0) ? $help[0]['title'] : ''; ?></b>
    </div>
    <?php
    if($requestData[0]['request_for']=='4'){
    ?>
	<div class="col-lg-6">
		<h6>Day of Curriculum</h6>
		<b><?php echo $requestData[0]['day_no']; ?></b>
	</div>
<?php } ?>
</div>
<?php 
if($requestData[0]['request_for']=='4'){ ?>
<div class="mb-4">
	<h6>Lesson Name</h6>
	<b><?php echo $requestData[0]['lesson']; //echo (count($lesson)>0) ? $lesson[0]['lesson_title'] : ''; ?></b>
</div>
<?php } ?>
<div class="mb-4">
	<h6>Message</h6>
	<b>
		<?php echo $requestData[0]['message']; ?>
	</b>
</div>

<?php } ?>