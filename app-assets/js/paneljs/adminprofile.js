var baseURL = $("#baseUrl").val();






$(document).on('keydown keyup','#username', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

    var x = e.which || e.keycode;
     if ((x >= 65 && x <= 90)){
         return true;
     }else if(x==8 || x==17 || x==116 || x==9 || x==32){
        return true;    
     }else if(x>=37 && x<=40){
        return true;
     }else{
        e.preventDefault();
        return false;
     }
  });





$(document).on('change','#userImg',function(){
	
	var file = $("#userImg").val();
    file = file.substr(file.lastIndexOf('.') + 1);
    var size = this.files[0].size;
    var maxsize = Math.round((size / 1024));
    var cnt=0;
    var imgExt = ['gif','jpg','png','jpeg'];
    if ($.inArray(file, imgExt) == -1){
        // $(".errmsg").html('Please Upload Valid Image File');
        // $(".errorModel").show();
    
        Swal.fire({
            title : "Warning!", 
            text: "Please Upload Valid Image File",
            type: "warning",
            confirmButtonColor: "#c41e3b",
            confirmButtonText: "OK"
        }).then((result) => {
            $("#blah").attr('src',baseURL+'app-assets/images/default-user.png');        
        });

        return false;
    }else if(maxsize>1024){
    	//$(".errmsg").html('File size should minimum 1 MB');
       // $(".errorModel").show();
       // $("#blah").attr('src',baseURL+'app-assets/images/default-user.png');

       Swal.fire({
            title : "Warning!", 
            text: "File size should minimum 1 MB",
            type: "warning",
            confirmButtonColor: "#c41e3b",
            confirmButtonText: "OK"
        }).then((result) => {
            $("#blah").attr('src',baseURL+'app-assets/images/default-user.png');        
        });

        return false;    
    }else{
        return true;
    }
});


$("#createUser").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            $(".processingModel").show();
            $(".btns").attr('disabled','disabled');
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_dashboard/SaveAdminProfile',
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
                        $("#createUser")[0].reset();
                        $(".processingModel").hide();
                      // $(".successModal1").show();
                      // $(".sucmsg").html(data['message']);
                      Swal.fire({
                            title : "Success!", 
                            text: data['message'],
                            type: "success",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            // location.reload();
                            var loginId = $("#userId").val();
                            window.location.href = baseURL;
                        });
                      setTimeout(function(){
                        $(".successModal1").hide();
                        $(".sucmsg").html('');
                        // location.reload();
                      },2000);
                   }else{
                        errHtml+=data['message'];
                        
                        // $(".errmsg").html(errHtml);
                        // $(".errorModel").show();
                        $(".border-danger").removeClass("border border-danger");
                        $("#"+data['data']).addClass('border border-danger');
                        $(".processingModel").hide();
                        Swal.fire({
                            title : "Warning!", 
                            text: data['message'],
                            type: "warning",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            $("#"+data['data']).addClass('border border-danger');
                        });

                        
                        setTimeout(function(){
                            $(".errmsg").html("");
                            $(".errorModel").hide();
                            
                        },6000);
                        $(".btns").removeAttr('disabled');
                    //$("#createUser")[0].reset();
                   }
                },
                error:function(xhr){

                    if(xhr.status==500){
                        //$("#UPLOADIMAGEFORM")[0].reset();
                        // $(".errmsg").html('Something Went Wrong! Please Try Again');
                        // $(".errorModel").show();
                        $(".processingModel").hide();
                        $(".btns").removeAttr('disabled');
                        Swal.fire({
                            title : "Error!", 
                            text: 'Something Went Wrong! Please Try Again',
                            type: "error",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            
                        });
                    }
                }
            });
        }
    });


$("#editUser").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            $(".processingModel").show();
            $(".btns").attr('disabled','disabled');
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_dashboard/UpdateUser',
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
                        $("#editUser")[0].reset();
                        $(".processingModel").hide();
                      // $(".successModal1").show();
                      // $(".sucmsg").html(data['message']);
                       Swal.fire({
                            title : "Success!", 
                            text: data['message'],
                            type: "success",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            location.reload();
                        });
                      setTimeout(function(){
                        $(".successModal1").hide();
                        $(".sucmsg").html('');
                        location.reload();
                      },2000);
                   }else{
                        errHtml+=data['message'];
                        $("#"+data['data']).addClass('border border-danger');
                        //$(".errmsg").html(errHtml);
                        //$(".errorModel").show();
                        $(".processingModel").hide();

                        Swal.fire({
                            title : "Warning!", 
                            text: data['message'],
                            type: "warning",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            $("#"+data['data']).addClass('border border-danger');
                        });

                        setTimeout(function(){
                            $(".errmsg").html("");
                            $(".errorModel").hide();
                            
                        },6000);
                        $(".btns").removeAttr('disabled');
                    //$("#createUser")[0].reset();
                   }
                },
                error:function(xhr){

                    if(xhr.status==500){
                        //$("#UPLOADIMAGEFORM")[0].reset();
                        //$(".errmsg").html('Something Went Wrong! Please Try Again');
                        //$(".errorModel").show();
                        $(".processingModel").hide();
                        $(".btns").removeAttr('disabled');

                        Swal.fire({
                            title : "Error!", 
                            text: data['message'],
                            type: "error",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            // $("#"+data['data']).addClass('border border-danger');
                        });
                    }
                }
            });
        }
    });

