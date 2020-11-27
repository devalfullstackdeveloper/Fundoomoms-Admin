<?php
foreach ($lessonList as $key => $lesson_class) {
    // $icn = base_url().'app-assets/images/default_lession.png';
    // $icn = base_url().'app-assets/images/default_lession.svg';
    // if(isset($lesson_class['lesson_icon']) && $lesson_class['lesson_icon'] != ""){
    //     $icn = base_url().$lesson_class['lesson_icon'];
    // }
    if(!empty($lesson_class['lesson_icon'])){
        $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$lesson_class['lesson_icon'];
        if(file_exists($fullUrl)){
            $icon = base_url()."".$lesson_class['lesson_icon'];
        }else{
            $icon = base_url()."app-assets/images/default_lession-38x38.png";
        }
    }else{
        $icon = base_url()."app-assets/images/default_lession-38x38.png";
    }
?>
<div class="col-lg-4 col-md-6 ">
    <div class="leasson-data">
        <img src="<?php echo $icon; ?>"  />
        <span class="leson-title"><?php echo $lesson_class['lesson_title']; ?></span>

        <span class="edit-tras">
        <a href="<?= base_url() ?>Ct_curriculum/editLesson/<?= $lesson_class['lesson_id'] ?>" class="edit-remove"  data-toggle="tooltip" data-placement="top" title="Edit">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>
                       
        <button class="btn p-0 btn-sm edit-remove" onclick="deleteLesson(<?= $lesson_class['lesson_id'] ?>);"  data-toggle="tooltip" data-placement="top" title="Delete">&nbsp;<i class="fa fa-trash" style="color: #8f1268;"></i>&nbsp;</button>
</span>          
    </div>   
</div>                     
<?php
    }
?>
<script>
    $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
    </script>