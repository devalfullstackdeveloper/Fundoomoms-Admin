 
 $(".select2").select2({});
 var baseURL = $("#base_url").val();
 $(document).on('change',"#technician",function(){
 	// alert($(this).val());
      if($(this).val()==''){

      }else{
      	$.post(baseURL+"Ct_service_request/AssignToTech",{tech:$(this).val(),sid:$("#serId").val()},function(){
	    	location.reload();
	  	});	
      } 		
	  
});

 $(document).on('click','.changeR',function(){
 	$(".btn1").show();
 	$(".btn2").hide();
	$("#ChangeRegionModal").modal('show');
 });

 $("#CHANGEREGIONFORM").on('submit',function(e){
        if(e.isDefaultPrevented()){
        }else{
            // alert();
            $(".btn1").hide();
            $(".btn2").show();
            // $(".errormsg").hide();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_service_request/ChangeRegion',
                type : 'post',
                data : new FormData(this),
                contentType : false,
                cache : false,
                processData : false,
                success : function (data) {
                   var data = JSON.parse(data);
                   var errHtml='';
                   if(data['status']==true){
                   	 // alert(data['message']);
    					$(".successModal").show();
                      setTimeout(function(){
                       	location.reload();
                      },2000);
                   }else{
                   		alert(data['message']);
                        $(".btn1").show();
                        $(".btn2").hide();
                   }
                },
                error:function(xhr){
                    if(xhr.status==500){
                        alert("Something Went Wrong!Please Try Again");
                        $(".btn1").show();
                        $(".btn2").hide();
                    }
                }
            });
        }
    });


