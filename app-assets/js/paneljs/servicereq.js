
// alert($("#vehicleLoc").val());

var options = {
        // types: ['(cities)'],
        componentRestrictions: {country: 'in'}//Turkey only
};
if(typeof($("#vehicleLoc")) != undefined && $("#vehicleLoc") != null) {
  $("#vehicleLoc").focus();
  // alert();
  var src1 = document.getElementById('vehicleLoc');
  var autocomplete1 = new google.maps.places.Autocomplete(src1,options);

  var src2 = document.getElementById('custaddr');
  var autocomplete2 = new google.maps.places.Autocomplete(src2,options);
}
var regExp = /[a-z]/i;

$("#vehicleregno").mask('AA | 00 | AA | 0000');

var baseURL = $("#baseUrl").val();

function loadService(){
	alert();
}

$(document).on('click','.btndefectPhoto',function(){
	$("#defectphoto").click();
});

$(".select2").select();
$(document).on('click','.serialPhotobtn',function(){
	$("#serialPhoto").click();
});

$(".contact").keydown(function(e) {
var oldvalue=$(this).val();
var field=this;
setTimeout(function () {
    if(field.value.indexOf('+91|') !== 0) {
        $(field).val(oldvalue);
    } 
}, 1);
});

$(document).on('click','.selcust',function(){
	if($(this).val()=="existcust"){
		$(".custdiv").hide();
		$(".custSelect").show();
		AddOrRemoveTabIndex('remove');
	}else if($(this).val()=="newcust"){
		$("#customername").focus();
		$(".custdiv").show();
		$(".custSelect").hide();
		AddOrRemoveTabIndex('add');
	}	
});

function AddOrRemoveTabIndex(a){
	if(a=="remove"){
		$(".tabindex").removeAttr('tabindex');
		$("#customer").attr('tabindex','11');
	}else{
		$("#customer").removeAttr('tabindex');
		$("#customername").attr('tabindex','11');
		$("#gendermale").attr('tabindex','12');
		$("#genderfemale").attr('tabindex','13');
		$("#customeremail").attr('tabindex','14');
		$("#customercontact").attr('tabindex','15');
		$("#altcustomercontact").attr('tabindex','16');
		$("#custaddr").attr('tabindex','17');
		$("#custstate").attr('tabindex','18');
		$("#custcity").attr('tabindex','19');
		$("#custzip").attr('tabindex','20');
		$("#custcountry").attr('tabindex','21');
	}
}

// $("input[name=vehicleLoc]").addClass('border border-danger');
// $("input[name=vehicleLoc]").removeClass('border border-danger');

function getcity(){
    var state = $("#custstate").val();
    var baseURL = $("#baseUrl").val();
    var ajxUrl = baseURL + "Ct_dashboard/cityFromState";
    $.ajax({
        url:ajxUrl,
        method:"POST",
        data: {
            state:state
        },
        dataType: "json",
        success:function(data)
        {
            var html = '<option value="">Select City</option>';
            $(data).each(function(i, v){
                html += '<option value="'+v.ct_id+'">'+v.ct_name+'</option>';
            });
            $("#custcity").html(html);
        }
    });
}



$(".contact").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

    var x = e.which || e.keycode;
     if ((x >= 48 && x <= 57)){
         return true;
     }else if(x >= 96 && x <= 105){
         return true;
     }else if(x==8){
		return true;   
     }else{
     	e.preventDefault();
     	return false;
     }
  });

$("#kmrun").on('keydown keyup', function(e) {
    // var value = String.fromCharCode(e.which) || e.key;

    var x = e.which || e.keycode;
     if ((x >= 48 && x <= 57)){
         return true;
     }else if(x >= 96 && x <= 105){
         return true;
     }else if(x==8 || x==75 || x==77 || x== 32){
      return true;   
     }else{
      e.preventDefault();
      return false;
     }
  });

$("#customername").on('keydown keyup', function(e) {
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


$("#createServiceRequest").on('submit',function(e){
        if(e.isDefaultPrevented()){
        }else{
            // alert();
            $(".btn1").hide();
            $(".btn2").show();
            $(".errormsg").hide();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_service_request/inserServiceRequest',
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
                      $(".alert-success").html('Request Created SuccessFully');
                      setTimeout(function(){
                        window.location.href=baseURL +'Ct_service_request/index';
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
                        $(".btn1").show();
                        $(".btn2").hide();
                   }
                },
                error:function(xhr){
                    if(xhr.status==500){
                        $(".errormsg").html('Something Went Wrong! Please Try Again');
                        $(".errormsg").show();
                        $(".btn1").show();
                        $(".btn2").hide();
                    }
                }
            });
        }
    });

$("#editServiceRequest").on('submit',function(e){
        if(e.isDefaultPrevented()){
        }else{
            // alert();
            $(".btn1").hide();
            $(".btn2").show();
            $(".errormsg").hide();
            e.preventDefault();
            $.ajax({
                url : baseURL +'Ct_service_request/edit',
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
                      $(".alert-success").html('Request Updated SuccessFully');
                      setTimeout(function(){
                        window.location.href=baseURL +'Ct_service_request/index';
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
                        $(".btn1").show();
                        $(".btn2").hide();
                   }
                },
                error:function(xhr){
                    if(xhr.status==500){
                        $(".errormsg").html('Something Went Wrong! Please Try Again');
                        $(".errormsg").show();
                        $(".btn1").show();
                        $(".btn2").hide();
                    }
                }
            });
        }
    });


function deleteService(id){
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
      var ajxUrl = baseURL + "Ct_service_request/deleteService";
      $.ajax({
        url:ajxUrl,
        method:"POST",
        data: {
          id:id
        },
        dataType: "json",
        success:function(data)
        {
          t.value && Swal.fire({
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


    function getLatLang(){
       // var link = "https://maps.googleapis.com/maps/api/geocode/json?address="+$('#custaddr').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s";

        // console.log(link); 
        $.get("https://maps.googleapis.com/maps/api/geocode/json?address="+$('#custaddr').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s",{},function(data){
            // var obj = Json.parse(data);
            var lat = data.results[0]['geometry']['location']['lat'];
            var lng = data.results[0]['geometry']['location']['lng'];    
            $("#latitude").val(lat);
            $("#langitude").val(lng);

            $.post("http://103.101.59.95/vehicleserviceapp/api/authentication/location/",{lat:lat,long:lng},function(data){
                // console.log(data.data['city']);
                $("#custstate").val(data.data['state']);
                $("#custstate").trigger('change');

                setTimeout(function(){
                    $("#custcity").val(data.data['city']);
                    $("#custcity").trigger('change');
                },1000);
                
            });

        });
        
    }

     function GetRegion(){
    
        $.get("https://maps.googleapis.com/maps/api/geocode/json?address="+$('#vehicleLoc').val()+"&key=AIzaSyA8rJ9jrXHQHgbGqcTq00XemqeIhXVDC0s",{},function(data){
            // var obj = Json.parse(data);
            var lat = data.results[0]['geometry']['location']['lat'];
            var lng = data.results[0]['geometry']['location']['lng'];    
            

            $.post("http://103.101.59.95/vehicleserviceapp/api/authentication/location/",{lat:lat,long:lng},function(data){
                // console.log(data.data['city']);
                $("#region").val(data.data['city']); 
            });

        });
        
    }

$(document).on('change','#serialPhoto',function(){
    $("#axlelabel").text('File Is Selected');
});

$(document).on('change','#defectphoto',function(){
    $("#defectlabel").text('File Is Selected');
});    



