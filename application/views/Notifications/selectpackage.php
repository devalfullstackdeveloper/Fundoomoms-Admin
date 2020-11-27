<!-- <option value="">--SELECT--</option> -->
<?php
    if(count($packageList)>0){
    foreach ($packageList as $key => $value) {
     $getData = getData('tb_package',array('package_id','ptitle'),'package_id',$value);   
?>
    <option value="<?= $getData[0]['package_id'] ?>"><?= $getData[0]['ptitle'] ?></option>
<?php        
    }
    }
?>