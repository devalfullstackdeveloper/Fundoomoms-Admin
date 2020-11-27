var baseURL = $("#baseUrl").val();


function hideAll(){
    $(".hideAll").hide();
}

$("#createClass").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            hideAll();
            $(".btn1").hide();
            $(".btn2").show();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_class/addclass',
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
                      // $(".successBtn").show();
                      // $(".sucmsg").html(data['message']);
                      Swal.fire({
                            title : "Success!", 
                            text: 'Classes Created Successfully',
                            type: "success",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           window.location.href=baseURL+'Ct_class/index';
                        });
                      // setTimeout(function(){
                        // window.location.href=baseURL+'Ct_class/index';
                      // },2000);
                   }else{
                        // errHtml+=data['message'];
                        // $(".errormsg").html(errHtml);
                        // $(".errormsgBtn").show();
                        Swal.fire({
                            title : "Warning!", 
                            text: data['message'],
                            type: "warning",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           $(".border-danger").removeClass("border border-danger");
                            $("#"+data['data']).addClass('border border-danger');    
                            $("#"+data['data']).focus(); 
                            
                        });

                        setTimeout(function(){
                            $(".errormsg").html("");
                            $(".errormsgBtn").hide();
                        },6000);
                     //    $(".btn1").show();
                     //    $(".btn2").hide();
                   }
                },
                error:function(xhr){
                    if(xhr.status==500){
                        $(".warningmsg").html('Something Went Wrong! Please Try Again');
                        $(".warningBtn").show();
                        // $(".btn1").show();
                        // $(".btn2").hide();
                    }
                }
            });
        }
    });

$("#updateClass").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            hideAll();
            $(".btn1").hide();
            $(".btn2").show();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_class/updateClass',
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
                      // $(".successBtn").show();
                      // $(".sucmsg").html(data['message']);

                      Swal.fire({
                            title : "Success!", 
                            text: 'Classes Updated Successfully',
                            type: "success",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           window.location.href=baseURL+'Ct_class/index';
                        });
                      // setTimeout(function(){
                      //   window.location.href=baseURL+'Ct_class/index';
                      // },2000);
                   }else{
                        errHtml+=data['message'];
                        // $(".errormsg").html(errHtml);
                        // $(".errormsgBtn").show();
                         Swal.fire({
                            title : "Warning!", 
                            text: data['message'],
                            type: "warning",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           
                            // $("#"+data['data']).addClass('border border-danger');    
                            // $("#"+data['data']).focus(); 
                            // $(".successBtn").show();
                            $(".btn1").show();
                            $(".btn2").hide();
                        });
                        // setTimeout(function(){
                        //     $(".errormsg").html("");
                        //     $(".errormsgBtn").hide();
                        // },6000);
                     //    $(".btn1").show();
                     //    $(".btn2").hide();
                   }
                },
                error:function(xhr){
                    if(xhr.status==500){
                        $(".warningmsg").html('Something Went Wrong! Please Try Again');
                        $(".warningBtn").show();
                        // $(".btn1").show();
                        // $(".btn2").hide();
                    }
                }
            });
        }
    });


function deleteClass(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#951c70",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.value) {
            var baseURL = $("#baseUrl").val();
            var ajxUrl = baseURL + "Ct_class/removeClass";
            $.ajax({
                url:ajxUrl,
                method:"POST",
                data: {
                    id:id
                },
                dataType: "json",
                success:function(data)
                {
                   Swal.fire({
                        title : "Deleted!", 
                        text: "Class Removed Successfully",
                        type: "success",
                        confirmButtonColor: "#951c70",
                        confirmButtonText: "OK"
                    }).then((result) => {location.reload();});
                }
            });
        }
    })
}
