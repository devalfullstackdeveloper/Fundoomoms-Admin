<?php
$Totaldays = $dates['c_days'];
for($i = 1; $i <= $Totaldays; $i++){
	$cadd = getMultiWhere('curriculum',array(),array("curriculum_class"=>$dclass,"curriculum_day"=>$i),"1");
?>
	<button data-buttonid="<?php echo $i; ?>" class="curriculumDay"><b style="<?php echo ($cadd>0) ? 'opacity: 0.5;' :''; ?>"><?php echo $i; ?></b></button>
<?php
}
?>

<script type="text/javascript">
	$(".curriculumDay").click(function() {

            var curriculumDay = $(this).data("buttonid");
            $(".curriculumDay").removeClass('active');
            $(this).addClass('active');
            var child_class = $('#child_class').children("option:selected").val();
            $.post(baseURL + "Ct_curriculum/checkCurriculum",{curriculumDay: curriculumDay,child_class: child_class},function(data){
                // console.log($(this).html())
                $(".curriculum_day_details").html('');
                $(".curriculum_day_details").html(data);
                // $(".curriculumDay").addClass('active');
                // $(this).addClass('active');
            }); 
        });
</script>