var baseURL = $("#baseUrl").val();


$(document).on('click','.uploadImageBtn',function(){
    $(".successModal1").hide();
    $(".processingModel").hide();
    $(".errorModel").hide();
     $("#UPLOADIMAGEFORM")[0].reset();
     
     $("#UploadImageModel").modal('show');
});

// $(document).on('click','.removePhoto',function(){
    // $.post(baseURL+'Ct_curriculum/removeImage',{id:$(this).attr('remId')},function(data){
    //     var data = JSON.parse(data);
    //     if(data['status']==true){
    //         setTimeout(function(){
    //             location.reload();
    //         },1000);
    //     }else{
    //         $(".errorModel").html(errHtml);
    //         $(".errorModel").show();
    //         setTimeout(function(){
    //             $(".errorModel").html('');
    //             $(".errorModel").show();
    //         },1000);
    //     }
    // });
    // deleteImage($(this).attr('remId'));
// });



$(document).on('click','.btnchooseimage',function(){
    $("#PhotoFile").click();
});

$(document).on('change','#PhotoFile',function(){
    $("#UPLOADIMAGEFORM").submit();
});

function checkType(){
    var type = $("#uploadType").val();
    if(type==''){
        $(".errorModel").html('Please Select Type');
        $(".errorModel").show();
        return false;
    }else{
        var file = $("#PhotoFile").val();
        file = file.substr(file.lastIndexOf('.') + 1)
        var cnt=0;
        var imgExt = ['gif','jpg','png','jpeg'];
        var vidExt = ['mp4'];
         var doc = ['doc','docx'];
        var pdf = ['pdf'];
        var ppt = ['ppt'];
        if(type=="1"){
            if ($.inArray(file, imgExt) == -1){
                $(".errorModel").html('Please Upload Valid Image File');
                $(".errorModel").show();
                return false;
            }else{
                return true;
            }
        }else if(type=='4'){
            if ($.inArray(file, doc) == -1){
                $(".errorModel").html('Please Upload Valid Document File');
                $(".errorModel").show();
                return false;
            }else{
                return true;
            }
        }else if(type=='3'){
            if ($.inArray(file, pdf) == -1){
                $(".errorModel").html('Please Upload Valid Pdf File');
                $(".errorModel").show();
                return false;
            }else{
                return true;
            }
        }else if(type=='5'){    
            if ($.inArray(file, pdf) == -1){
                $(".errorModel").html('Please Upload Valid PPT File');
                $(".errorModel").show();
                return false;
            }else{
                return true;
            }

        }else{
            if ($.inArray(file, vidExt) == -1){
                $(".errorModel").html('Please Upload Valid Video File');
                $(".errorModel").show();
                return false;    
            }else{
                return true;
            }
        }
    }
}

function HideAll(){
    $(".successModal1").hide();
    $(".errorModel").hide();
}

$("#UPLOADIMAGEFORM").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            
            HideAll();
            e.preventDefault();
            var check = checkType();
            // alert(check);
            if(check==true){
                $(".processingModel").show();
            $.ajax({
                url : baseURL +'Ct_curriculum/uploadImage',
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
                        $("#UPLOADIMAGEFORM")[0].reset();
                        $(".processingModel").hide();
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
                    $("#UPLOADIMAGEFORM")[0].reset();
                   }
                },
                error:function(xhr){

                    if(xhr.status==500){
                        $("#UPLOADIMAGEFORM")[0].reset();
                        $(".errorModel").html('Something Went Wrong! Please Try Again');
                        $(".errorModel").show();
                        $(".processingModel").hide();
                    }
                }
            });
            }else{

            }
        }
    });

function deleteImageGalary(id){
    Swal.fire({
        title: "Are you sure?...",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#951c70",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(result => {
        if (result.value) {
          var baseURL = $("#baseUrl").val(); 
          var ajxUrl = baseURL + "Ct_curriculum/removeImage";
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
                    text: "File Removed Successfully",
                    type: "success",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
      }
  });
}

