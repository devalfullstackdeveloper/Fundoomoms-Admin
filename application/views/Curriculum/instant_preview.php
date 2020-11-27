<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<style>
/* The device with borders */
.smartphone {
  position: relative;
  width: 360px;
  height: 640px;
  margin: auto;
  border: 16px black solid;
  border-top-width: 60px;
  border-bottom-width: 60px;
  border-radius: 36px;
}

/* The horizontal line on the top of the device */
.smartphone:before {
  content: '';
  display: block;
  width: 60px;
  height: 5px;
  position: absolute;
  top: -30px;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #333;
  border-radius: 10px;
}

/* The circle on the bottom of the device */
.smartphone:after {
  content: '';
  display: block;
  width: 35px;
  height: 35px;
  position: absolute;
  left: 50%;
  bottom: -65px;
  transform: translate(-50%, -50%);
  background: #333;
  border-radius: 50%;
}

/* The screen (or content) of the device */
.smartphone .contentsm {
  width: 328px;
  height: 519px;
  background: white;
}


.DayTitle{
    padding: 10px 14px;
    top: 5px;
    position: absolute;
  }

  .ContentDiv{
    width: 100%;
    position: absolute;
    top: 100px;
    padding: 13px;
    height: 81%;
    overflow-y: scroll;
  }

  .ImgId{
    position: absolute;
    width: 100%;
    top: 40px;
  }
</style>

</head>

<body>
  <div class="smartphone">
                                  
  <div class="contentsm">
       <h4><b class="DayTitle">Day&nbsp;<?= $day ?></b></h4> 

       <?php
       
       if($lesson[0]['lesson_icon']!=''){
          $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$lesson[0]['lesson_icon'];
          if(file_exists($fullUrl)){
            $img = base_url()."".$lesson[0]['lesson_icon'];
          }else{
            $img = base_url()."app-assets/images/default_lession-38x38.png";
          }
        }else{
            $img = base_url()."app-assets/images/default_lession-38x38.png";
        }
       ?>
       <div class="ImgId">
          <img src="<?php echo $img; ?>">
            <?= $lesson[0]['lesson_title']; ?>
        </div>
       <?php  ?>
       <div class="ContentDiv">
        <?php
           if(count($curriculumData)>0){
            echo $curriculumData[0]['curriculum_lesson_description'];
           }
       ?>  
       </div> 

  </div>
  </div>     
   
</body>
</html>

