<table>
	<?php
	if(count($photos)>0){
		$j=1;
		foreach ($photos as $key => $value) {
		if($value['type']=="1"){
        $img = base_url()."".$value['path'];
       }else if($value['type']=="3"){
        $img = base_url()."app-assets/images/pdf-file-icon.png";
       }else if($value['type']=="4"){
         $img = base_url()."app-assets/images/docs-icon.png";
	   }else if($value['type']=="5"){
	     $img = base_url()."app-assets/images/ppt-file-icon.png";
	   }   
	?>
		<tr>
			<td><img src="<?= $img ?>" width='120' height='120' /></td>
			<!-- <td><div class="link-url"><?= base_url()."".$value['path'] ?></div></td> -->
			<td><p id="p1<?= $j ?>" style="display: none;"><?= base_url()."".$value['path'] ?></p><a onclick="copyToClipboard('#p1<?= $j ?>','btnid<?= $j ?>')" class="btn btn-sm btn-primary" id="btnid<?= $j ?>"><i class="fa fa-copy"></i></a>
				<a href="javascript:void(0);" class="removePhoto" remId="<?= $value['image_id'] ?>"><i class="fa fa-times"></i></a>
            
            </td>
		</tr>

		<tr>
			<td colspan="3" align="center">&nbsp;</td>
		</tr>
	<?php
			$j++;			
		}		
	}
	?>
</table>

<div id="tempdiv">

</div>

<script src="<?php echo base_url(); ?>app-assets/js/clipboardjs/dist/clipboard.min.js"></script>

<script type="text/javascript">
	function copyToClipboard(element,btnid) {
      var $temp = $("<input>");
      $("#tempdiv").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      $("#"+btnid).text('copied');
    }
</script>