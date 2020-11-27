var baseURL = $("#baseUrl").val();

$(document).ready(function() {
         

        $("#child_class").change(function(){
            var child_class = $(this).children("option:selected").val();
            $("#childAge").html($(this).children("option:selected").attr('childAge'));
            $("#classDays").html($(this).children("option:selected").attr('cDays'));
            $(".curriculum_day_details").html('');
            $.post(baseURL+'Ct_curriculum/loadProgressBar',{class:child_class},function(data){
                $(".viewprogressbar").html(data);

                // 
            });

            $("#totalDay1").text($(this).children("option:selected").attr('totalDay'));
            loadDates(child_class);
        });

        $("#child_class").trigger('change');
	});


function loadDates(cid){
    $.post(baseURL+"Ct_curriculum/loadCurdates",{class:cid},function(data){
        $(".scrollbar").html(data);
    });
}

if(typeof($("#descr")) != "undefined" && $("#descr") !== null) {
    CKEDITOR.replace( 'descr' );
}


$("#createcurriculum").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            // alert();
            // $(".btn1").hide();
            // $(".btn2").show();
            // $(".errormsg").hide();
            $("#curriculum_description").val(CKEDITOR.instances.descr.getData());
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_curriculum/saveCurriculum',
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
                      // $(".alert-success").show();
                      // $(".alert-success").html('Curriculum Created Successfully');
                      Swal.fire({
                            title : "Success!", 
                            text: data['message'],
                            type: "success",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           window.location.href=baseURL+'Ct_curriculum/aftercuriculum/'+data['data']+'/'+data['class']+'/'+data['cDay'];
                        });
                          // setTimeout(function(){
                            
                          // },2000);
                   }else{
                        // $("input[name="+data['data']+"]").addClass('dangerborder');
                        // $("input[name="+data['data']+"]").trigger();      
                        
                        // errHtml+=data['message'];
                        // $(".errormsg").html(errHtml);
                        // $(".errormsg").show();

                        Swal.fire({
                            title : "Warning!", 
                            text: data['message'],
                            type: "warning",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if(data['data']=='curriculum_description'){
                                $(".cke_inner").addClass('border border-danger');
                                $(".cke_inner").focus();
                            }else{
                                $("#"+data['data']).addClass('border border-danger');    
                                $("#"+data['data']).focus();
                            }
                            
                            
                        });

                        setTimeout(function(){
                            $(".errormsg").html("");
                            $(".errormsg").hide();
                        },6000);
                     //    $(".btn1").show();
                     //    $(".btn2").hide();
                   }
                },
                error:function(xhr){
                    if(xhr.status==500){
                        // $(".errormsg").html();
                        // $(".errormsg").show();

                        Swal.fire({
                            title : "Error!", 
                            text: 'Something Went Wrong! Please Try Again',
                            type: "error",
                            confirmButtonColor: "#c41e3b",
                            confirmButtonText: "OK"
                        }).then((result) => {
                           
                        });
                        // $(".btn1").show();
                        // $(".btn2").hide();
                    }
                }
            });
        }
    });



$(document).on('click','.viewpreview',function(){

    var cClass = $(this).attr('cClass');
    var cDay = $(this).attr('cDay');
    var less = $("#currentLesson").val();
    
    if(less==''){
        location.reload();
    }else{
        window.location.href=baseURL+'Ct_curriculum/getPreview/'+cClass+'/'+cDay+'/'+less;
    }

});


$(document).on('click','.uploadImageBtn',function(){

    $(".successModal1").hide();
    $(".processingModel").hide();
    $(".errorModel").hide();
     $("#UPLOADIMAGEFORM")[0].reset();
     
     $("#UploadImageModel").modal('show');
     LoadPhotos();
});

$(document).on('click','.removePhoto',function(){
    $.post(baseURL+'Ct_curriculum/removeImage',{id:$(this).attr('remId')},function(data){
        var data = JSON.parse(data);
        if(data['status']==true){
            LoadPhotos();
        }else{
            // $(".errorModel").html(errHtml);
            // $(".errorModel").show();

            Swal.fire({
                title : "Warning!", 
                text: data['message'],
                type: "warning",
                confirmButtonColor: "#c41e3b",
                confirmButtonText: "OK"
            }).then((result) => {
            
            });

            setTimeout(function(){
                $(".errorModel").html('');
                $(".errorModel").show();
            },1000);
        }
    });
});

function LoadPhotos(){
    $.post(baseURL+'Ct_curriculum/loadPhotos',{},function(data){
        $(".PhotoLinks").html(data);
    });
}

$(document).on('click','.btnchooseimage',function(){
    $("#PhotoFile").click();
});

$(document).on('change','#PhotoFile',function(){
    $("#UPLOADIMAGEFORM").submit();
});

$("#UPLOADIMAGEFORM").on('submit',function(e){
    // alert();
        if(e.isDefaultPrevented()){
        }else{
            $(".processingModel").show();
            e.preventDefault();
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
                        LoadPhotos();
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
        }
    });


function deleteCurriculum(id){
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
        var ajxUrl = baseURL + "Ct_curriculum/removeCurriculum";
        $.ajax({
            url:ajxUrl,
            method:"POST",
            data: {
                id:id
            },
            dataType: "json",
            success:function(data)
            {

                // var data = JSON.parse(data);
                if(data.status==true){
                    Swal.fire({
                        title : "Deleted!", 
                        text: "Curriculum Removed Successfully",
                        type: "success",
                        confirmButtonColor: "#951c70",
                        confirmButtonText: "OK"
                    }).then((result) => { $("#child_class").val(data.data); $("#child_class").trigger('change'); });
                }else{
                    Swal.fire({
                    title : "Error!", 
                    text: "Something went wrong! please try again",
                    type: "error",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => { $("#child_class").val(data.data); $("#child_class").trigger('change'); });
                }
                
            }
        });
    }
    })
}


function deleteCurriculumonViewafter(id){
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
        var ajxUrl = baseURL + "Ct_curriculum/removeCurriculum";
        $.ajax({
            url:ajxUrl,
            method:"POST",
            data: {
                id:id
            },
            dataType: "json",
            success:function(data)
            {

                // var data = JSON.parse(data);
                if(data.status==true){
                    Swal.fire({
                        title : "Deleted!", 
                        text: "Curriculum Removed Successfully",
                        type: "success",
                        confirmButtonColor: "#951c70",
                        confirmButtonText: "OK"
                    }).then((result) => { location.reload(); });
                }else{
                    Swal.fire({
                    title : "Error!", 
                    text: "Something went wrong! please try again",
                    type: "error",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => { location.reload(); });
                }
                
            }
        });
    }
    })
}


function deleteCurriculumDay(cClass,day){
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
        var ajxUrl = baseURL + "Ct_curriculum/removeCurriculumDay";
        $.ajax({
            url:ajxUrl,
            method:"POST",
            data: {
                class:cClass,
                day:day
            },
            dataType: "json",
            success:function(data)
            {
                if(data.status==true){
                    Swal.fire({
                        title : "Deleted!", 
                        text: "Curriculum Removed Successfully",
                        type: "success",
                        confirmButtonColor: "#951c70",
                        confirmButtonText: "OK"
                    }).then((result) => { $("#child_class").val(data.data); $("#child_class").trigger('change'); });
                }else{
                    Swal.fire({
                    title : "Error!", 
                    text: "Something went wrong! please try again",
                    type: "error",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => { $("#child_class").val(data.data); $("#child_class").trigger('change'); });
                }
            }
        });
    }
    })
}

function InstantPreview(text,lesson){
    var cDay = $("#curriculum_day").val();
    var link = baseURL+'Ct_curriculum/InstantPreview/'+text+'/'+cDay+'/'+lesson;
    // $("#iframe1").attr('src',link);
    $.post(baseURL+'Ct_curriculum/loadInstantPreview',{day:cDay,lesson:lesson,descr:text},function(data){

        $(".MobileDiv").html(data);   
    });
}

$(document).on('change',"#lesson",function(){
     $("#overlay").fadeIn(300);
    var des = CKEDITOR.instances['descr'].getData();
    InstantPreview(des,$(this).val());        
    $("#overlay").fadeOut(300);
});

if(typeof CKEDITOR.instances.descr !== 'undefined'){
    CKEDITOR.instances.descr.on('change', function() { 
       var lesson = $("#lesson").val(); 
       InstantPreview(CKEDITOR.instances['descr'].getData(),lesson);       
    });
}    

setTimeout(function(){
        // if($("#lesson").val()!=''){
            if(typeof CKEDITOR.instances.descr !== 'undefined'){
                InstantPreview(CKEDITOR.instances['descr'].getData(),$("#lesson").val());
            }
        // }
},1000);