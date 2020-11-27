var baseURL = $("#baseUrl").val();

function LoadFirst(){
	$.post(baseURL+"Ct_service_request/SearchAjax",{status:'all',tech:'all',state:'all',city:''},function(data){
        // console.log(data);
        $(".LoadTable").html(data);
    });
}

LoadFirst();

$(document).on('change','.ss_status, .sr_tech',function(data){
  // alert();
    var status = $(".ss_status").val();
    var tech = $(".sr_tech").val();

    $.post(baseURL+"Ct_service_request/SearchAjax",{status:status,tech:tech},function(data){
        // console.log(data);
        $(".LoadTable").html(data);
    });
});

$(document).on('change','.ss_state, .sr_region',function(data){
  // alert();
    var state = $(".ss_state").val();
    var region = $(".sr_region").val();

    $.post(baseURL+"Ct_service_request/SearchAjax",{state:state,city:region},function(data){
        // console.log(data);
        if(region!=''){
        	LoadCity(state,region);
        }
        $(".LoadTable").html(data);
    });
});

$(document).on('click','.reloadSearch',function(){
	LoadFirst();
});

$(document).on('change','.ss_state',function(){
	LoadCity($(this).val());
})


function LoadCity(a,b=''){
	var state = a;
    //var baseURL = $("#baseUrl").val();

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
                if(b!='') {
                    if(b==v.ct_id){
                        html += '<option value="'+v.ct_id+'" selected>'+v.ct_name+'</option>';    
                    }else{
                        html += '<option value="'+v.ct_id+'">'+v.ct_name+'</option>';        
                    }
                }else{
                    html += '<option value="'+v.ct_id+'">'+v.ct_name+'</option>';    
                }
                
            });
            $(".sr_region").html(html);
        }
    });
}



