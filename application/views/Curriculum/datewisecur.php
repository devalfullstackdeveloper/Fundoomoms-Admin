  
<style type="text/css">
	* {box-sizing: border-box}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
  height: 300px;
  overflow: scroll;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  border: 1px solid #ccc;
  width: 70%;
  border-left: none;
  height: 300px;
}
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-4">
        <div class="inner-text-title">
				<?php
					 if($curriculumDay=="1"){
					 	echo "<h4>1<sup>st</sup> Day</h4>";
					 }else if($curriculumDay=="2"){
					 	echo "<h4>2<sup>nd</sup> Day</h4>";
					 }else if($curriculumDay=="3"){
					 	echo "<h4>3<sup>rd</sup> Day</h4>";
					 }else{
             echo "<h4 >".$curriculumDay."<sup>th</sup> Day</h4>";        
					 }
        ?>
        </div>
			</div>
			<div class="col-lg-8 text-right">
				 <a href="<?php echo base_url()."Ct_curriculum/aftercuriculum/".$lession[0]['curriculum_id']."/".$curriculum_class."/".$curriculumDay; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="bx bxs-pencil"></i><span class="edtcul">Edit Curriculum</span></a>

                 <a href="javascript:void(0);" class="btn btn-sm btn-primary viewpreview" cClass="<?= $curriculum_class?>" cDay="<?= $curriculumDay ?>" data-toggle="tooltip" data-placement="top" title="Preview"><i class="bx bx-play-circle"></i><span class="edtcul">Preview</span></a>
          <input type="hidden" name="" id="currentLesson" value="<?php echo $lession[0]['curriculum_lesson']; ?>">

          <a href="javascript:void(0);" onclick="deleteCurriculumDay('<?php echo $curriculum_class; ?>','<?php echo $curriculumDay; ?>')" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i><span class="edtcul">Delete Curriculum</span></a>
			</div>
		</div>
	</div>
</div>

<div class="tab">
  <?php
  $i=1;
  foreach ($lession as $key => $value) {
  	$icon = getData('lesson',array(),'lesson_id',$value['curriculum_lesson']);
    if(!empty($icon[0]['lesson_icon'])){
        $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$icon[0]['lesson_icon'];
        if(file_exists($fullUrl)){
            $icon1 = base_url()."".$icon[0]['lesson_icon'];
        }else{
            $icon1 = base_url()."app-assets/images/default_lession-38x38.png";
        }
    }else{
        $icon1 = base_url()."app-assets/images/default_lession-38x38.png";
    }
  ?>
   <button class="tablinks lasttablink <?php if($i==1){ echo 'active'; } ?>" onclick="openCity(event, '<?= $value['curriculum_id'] ?>','<?= $value['curriculum_lesson'] ?>')">
    <img src="<?php echo $icon1; ?>">
        <?= $icon[0]['lesson_title']; ?>
        <!-- <img class="img-fluid lasttablink" src="http://103.101.59.95/fundoomoms/app-assets/images/Group 1128.png" alt="">
         -->
  </button>
  <?php	
  	$i++;
  }
  ?>	
  
  <!-- <button class="tablinks" onclick="openCity(event, 'Paris')">Paris</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button> -->
</div>
<?php
$i=1;
foreach ($lession as $key => $value) {
	$icon = getData('lesson',array(),'lesson_id',$value['curriculum_lesson'])
?>
<div id="<?= $value['curriculum_id'] ?>" class="tabcontent" <?php if($i==1){ }else{ ?> style="display: none;" <?php } ?>>
	<div class="form-group row">
		<div class="col-lg-12">
    <div class="tabdata">
			<div class="row">
      
				<div class="col-lg-10 scroll-d">
          
					<?php 
            // $explode = explode(" ", $value['curriculum_lesson_description']);
            // foreach ($explode as $exkey => $exvalue) {
            //     if($exkey==20){
            //       break;
            //     }else{
            //       echo $exvalue." ";
            //     }
            // }
           echo $value['curriculum_lesson_description'];
          ?>    			
        </div>
        <div class="col-lg-2 text-right">
            <a href="<?php echo base_url()."Ct_curriculum/editCurriculumn/".$value['curriculum_id']."/".$value['curriculum_class']."/".$value['curriculum_day']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="bx bxs-pencil"></i></a>
            <a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick="deleteCurriculum('<?= $value['curriculum_id'] ?>')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>

          </div>
				<!-- <div class="col-lg-4 text-right">
					<a href="<?php echo base_url()."Ct_curriculum/editCurriculumn/".$value['curriculum_id']."/".$value['curriculum_class']."/".$value['curriculum_day']; ?>" class="btn btn-sm btn-primary"><i class="bx bxs-pencil"></i></a>
				</div> -->
      </div>
    </div>
			
		</div>
	</div>
</div>
<?php
	$i++;	
}
?>


<!-- <div id="Paris" class="tabcontent" style="display: none;">
  <h3>Paris</h3>
  <p>Paris is the capital of France.</p>
</div>

<div id="Tokyo" class="tabcontent" style="display: none;">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div> -->

<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });

	function openCity(evt, cityName,lesson) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";

  $("#currentLesson").val(lesson);
}
</script>