var baseURL = $("#baseUrl").val();

CKEDITOR.replace( 'descr' );

function HideAll(){
    $(".hideAll").hide();
}

$("#createBanner").on('submit',function(e){
        if(e.isDefaultPrevented()){ 
        }else{
            $("#description").val(CKEDITOR.instances.descr.getData());
            e.preventDefault();
            
            $.ajax({
                url : baseURL +'Ct_syllabus/addSyllabus',
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
                        $("#createBanner")[0].reset();
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
                        // location.reload();
                      },2000);
                      // $(".successModal1").show();
                      // $(".successModal1").html(data['message']);
                      // setTimeout(function(){
                      //   $(".successModal1").hide();
                      //   $(".successModal1").html('');
                      //   location.reload();
                      // },2000);
                   }else{
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
                    //     errHtml+=data['message'];
                    //     $(".errorModel").html(errHtml);
                    //     $(".errorModel").show();
                    //     $(".processingModel").hide();
                    //     setTimeout(function(){
                    //         $(".errorModel").html("");
                    //         $(".errorModel").hide();
                            
                    //     },6000);
                    $("#createBanner")[0].reset();
                   }
                },
                error:function(xhr){

                    if(xhr.status==500){
                        $("#createBanner")[0].reset();
                        $(".errorModel").html('Something Went Wrong! Please Try Again');
                        $(".errorModel").show();
                        $(".processingModel").hide();
                    }
                }
            });
           
        }
    });

$("#editBanner").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            
            $("#description").val(CKEDITOR.instances.descr.getData());
            e.preventDefault();
            
            $.ajax({
                url : baseURL +'Ct_syllabus/updateSyllabus',
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
                        $("#editBanner")[0].reset();
                        
                      $(".successModal1").show();
                      $(".successModal1").html(data['message']);
                      setTimeout(function(){
                        $(".successModal1").hide();
                        $(".successModal1").html('');
                        location.reload();
                      },2000);
                   }else{
                        errHtml+=data['message'];
                        $(".errorModel").html(errHtml);
                        $(".errorModel").show();
                        $(".processingModel").hide();
                        setTimeout(function(){
                            $(".errorModel").html("");
                            $(".errorModel").hide();
                            
                        },6000);
                    $("#createBanner")[0].reset();
                   }
                },
                error:function(xhr){

                    if(xhr.status==500){
                        $("#editBanner")[0].reset();
                        $(".errorModel").html('Something Went Wrong! Please Try Again');
                        $(".errorModel").show();
                        $(".processingModel").hide();
                    }
                }
            });
           
        }
    });


function deleteSyllabus(id){
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
        var ajxUrl = baseURL + "Ct_syllabus/removeSyllabus";
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
                    text: "Syllabus Removed Successfully",
                    type: "success",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    }
    })
}

    

