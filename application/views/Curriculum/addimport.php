<center><img class="img-fluid" src="<?php echo base_url().'app-assets/images/Group 1122.png'; ?>" /></center>
<div class="curriculum_buttons text-center">
	<a href="<?php echo base_url().'Ct_curriculum/createCurriculum/'.$curriculum_class.'/'.$curriculumDay.'/' ?>" class="btn btn-light btn-sm">Add Curriculum</a>
  	<!--<a href="javascript:void(0);" class="btn btn-light btn-sm importBtn" cClass="<?php echo str_replace(" ", "", $curriculum_class); ?>" 
  	cDay="<?php echo $curriculumDay; ?>">Import Curriculum</a>
 	<input type="file" id="importCur<?php echo str_replace(" ", "", $curriculum_class)."".$curriculumDay; ?>" style="display:none;">-->
 </div>


 <script type="text/javascript">
 	
 	$(document).on('click','.importBtn',function(){
	    var cClass = $(this).attr('cClass');
	    var cDay = $(this).attr('cDay');
	    $("#importCur"+cClass+''+cDay).click();
	});

	$('input[type="file"]').change(function(e){
		var fd = new FormData();
        var files = e.target.files[0];
        fd.append('importFile',files);
        $("#overlay").fadeIn(300);
        $.ajax({
	        url: baseURL+'Ct_curriculum/importCurriculum',
	        type: 'post',
	        data: fd,
	        contentType: false,
	        processData: false,
	        success: function(response){
	        	// location.reload();
// location.reload();
	        	var data = JSON.parse(response);

	        	// // console.log(data['exist']);
	        	if(data['status']==true){

	        		$("#overlay").fadeOut(300);
	        		var emsg = "";
	        		if(data['exist']!=''){
	        			var ex = JSON.parse(data['exist']);
	        			var ex1 = '';
	        			$.each(ex,function(i, e){
	        				ex1 +=i+' '+e+'  |'
	        				
	        			});
	        			if(ex1!=''){
	        				emsg +=' And '+ex1+' skipped beacuses its already saved ';		
	        			}
	        			// alert(emsg);
	        		}
		        	Swal.fire({
	                    title : "Import!", 
	                    text: "File Imported Suceessfully "+emsg,
	                    type: "success",
	                    confirmButtonColor: "#c41e3b",
	                    confirmButtonText: "OK"
	                }).then((result) => {location.reload();});
	            }else{
	            	$("#overlay").fadeOut(300);
	            	Swal.fire({
	                    title : "Import!", 
	                    text: "The file you are trying to imprort in not properly imported! Please try again",
	                    type: "warning",
	                    confirmButtonColor: "#c41e3b",
	                    confirmButtonText: "OK"
	                }).then((result) => {location.reload();});
	            }

	        	// GetProjectImages($("#projects_id_for_estimate").val());

	        	// GetProjectImages($("#projects_id_for_estimate").val());
	        },
    	});
    });
 </script>