var baseURL = $("#baseUrl").val();

// $(document).on('change','.searchSel',function(){
// 	var st = $("#sStatus").val();
// 	var tech = $("#technician").val();

// 	$.post(baseURL+"Ct_dashboard/CustomerServiceSearch",{status:st,tech:tech},function(data){
// 		$(".loadSer").html(data);
// 	});
// });


// var options = {
//         // types: ['(cities)'],
//         componentRestrictions: {country: 'in'}//Turkey only
// };

// var src1 = document.getElementById('address');
// var autocomplete1 = new google.maps.places.Autocomplete(src1,options);


//     function getLatLang(){
//        // var link = "https://maps.googleapis.com/maps/api/geocode/json?address="+$('#custaddr').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s";

//         // console.log(link); 
//         $.get("https://maps.googleapis.com/maps/api/geocode/json?address="+$('#address').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s",{},function(data){
//             // var obj = Json.parse(data);
//             var lat = data.results[0]['geometry']['location']['lat'];
//             var lng = data.results[0]['geometry']['location']['lng'];    
//             $("#latitude").val(lat);
//             $("#langitude").val(lng);

//             $.post("http://103.101.59.95/vehicleserviceapp/api/authentication/location/",{lat:lat,long:lng},function(data){
//                 // console.log(data.data['city']);
//                 $("#state").val(data.data['state']);
//                 $("#state").trigger('change');

//                 setTimeout(function(){
//                     $("#city").val(data.data['city']);
//                     $("#city").trigger('change');
//                 },1000);
                
//             });

//         });
        
//     }

$("#mobile").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

    var x = e.which || e.keycode;
     if ((x >= 48 && x <= 57)){
         return true;
     }else if(x >= 96 && x <= 105){
         return true;
     }else if(x==8 || x==9){
		return true;   
     }else{
     	e.preventDefault();
     	return false;
     }
  });

$("#alt_mobile").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

    var x = e.which || e.keycode;
     if ((x >= 48 && x <= 57)){
         return true;
     }else if(x >= 96 && x <= 105){
         return true;
     }else if(x==8 || x==9){
		return true;   
     }else{
     	e.preventDefault();
     	return false;
     }
  });


$("#name").on('keydown keyup', function(e) {
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

$("#createRoleUser").on('submit',function(e){
        if(e.isDefaultPrevented()){
        }else{
            // alert();
            // $(".btn1").hide();
            // $(".btn2").show();
            // $(".errormsg").hide();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_userManagement/addRoleUser',
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
                      $(".alert-success").show();
                      $(".alert-success").html('User Created SuccessFully');
                      setTimeout(function(){
                        location.reload();
                      },2000);
                   }else{
                   		// $("input[name="+data['data']+"]").addClass('border border-danger');
                   		$("input[name="+data['data']+"]").focus();
                   		errHtml+=data['message'];
                   		$(".errormsg").html(errHtml);
                   		$(".errormsg").show();
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
                        $(".errormsg").html('Something Went Wrong! Please Try Again');
                        $(".errormsg").show();
                        // $(".btn1").show();
                        // $(".btn2").hide();
                    }
                }
            });
        }
    });

$("#editRoleUser").on('submit',function(e){
        if(e.isDefaultPrevented()){
        }else{
            // alert();
            // $(".btn1").hide();
            // $(".btn2").show();
            // $(".errormsg").hide();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_userManagement/UpdateUserRole',
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
                      $(".alert-success").show();
                      $(".alert-success").html('User Updated SuccessFully');
                      setTimeout(function(){
                        location.reload();
                      },2000);
                   }else{
                      // $("input[name="+data['data']+"]").addClass('border border-danger');
                      $("input[name="+data['data']+"]").focus();
                      errHtml+=data['message'];
                      $(".errormsg").html(errHtml);
                      $(".errormsg").show();
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
                        $(".errormsg").html('Something Went Wrong! Please Try Again');
                        $(".errormsg").show();
                        // $(".btn1").show();
                        // $(".btn2").hide();
                    }
                }
            });
        }
    });


if(typeof($("#cityId")) != "undefined" && $("#cityId") !== null) {
  // alert();
  getCity();
}


function deleteRoleUser(id){
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
        var ajxUrl = baseURL + "Ct_userManagement/DeleteRoleUser";
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
                    text: "SuccessFully Removed.",
                    type: "success",
                    confirmButtonColor: "#951c70",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
      }
    })
}


function loadMomRequest(){
  var momId = $("#customerId").val();
  $.post(baseURL+"Ct_dashboard/loadMomRequest",{momsid:momId},function(data){
    $(".reqAppt").html(data);
  });
}

loadMomRequest();

function ShowRequestDetail(id){
   $.post(baseURL+"Ct_dashboard/LoadRequestDetail",{bookid:id},function(data){
      $(".reqData").html(data);
   });
}
