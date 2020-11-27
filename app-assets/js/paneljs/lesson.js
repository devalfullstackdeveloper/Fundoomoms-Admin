
$(document).on('change','#files',function(){
    
    $("#fileErr").html('');
    $("#fileErr").hide();
    // $("#infoErr").hide();
    var file = $("#files").val();
    file = file.substr(file.lastIndexOf('.') + 1);
    var size = this.files[0].size;
    var maxsize = Math.round((size / 1024));

    var cnt=0;
    var imgExt = ['png','svg'];
    if ($.inArray(file, imgExt) == -1){
        $("#fileErr").html('Please Upload Valid Image File');
        $("#fileErr").show();

        $(".remove").click();
        $(".ml-2").attr('disabled','disabled');
        $(".infoErr").hide();
        return false;
    }else if(parseFloat(maxsize)>15){
        $(".remove").click();
        $("#fileErr").html('File size should maximum 3 KB');
        $("#fileErr").show();
        $(".ml-2").attr('disabled','disabled');
        $(".infoErr").hide();
        setTimeout(function(){
           
        },1000);
        
        //$("#blah").attr('src',baseURL+'app-assets/images/default-user.png');
        return false;    
    }else{
        $(".infoErr").hide();
        $(".ml-2").removeAttr('disabled');
        return true;
    }
});



function LessonSubmit(a){
    if(a=='add'){
        
        if($("#lesson_title").val()==''){
            $("#lesson_title").addClass('border border-danger');
            $("#lesson_title").focus();
            return false;
        }
        // else if(document.getElementById("files").files.length == 0){
        //     $("#uplBtn").addClass('border border-danger');
        //     $("#uplBtn").focus();
        //     $("#fileErr").show();
        //     setTimeout(function(){
        //         $("#fileErr").hide();
        //     },3000);
        //     return false;     
        // }
        else{
            $("#createLesson").submit();
        }
    }

    
    if(a=='edit'){
        if($("#lesson_title").val()==''){
            $("#lesson_title").addClass('border border-danger');
            $("#lesson_title").focus();
            return false;
        } else{
            $("#editLesson").submit();
        }   
    }
}