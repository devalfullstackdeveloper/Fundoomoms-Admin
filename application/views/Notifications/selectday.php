
<?php
    if(count($curriculum_day)>0){
    foreach ($curriculum_day as $key => $value) {
?>
    <option value="<?= $value ?>" <?php if(count($selected)>0) if(in_array($value, $selected)) echo "selected"; ?>><?= $value ?></option>
<?php        
    }
    }
?>