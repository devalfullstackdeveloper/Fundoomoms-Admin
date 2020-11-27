/* Validate Email */
function validateEmail1($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}
/*Validate Mobile */
function phonenumber1(inputtxt) {
    var phoneno = /^\d{10}$/;
    if (inputtxt.match(phoneno)) {
        return true;
    } else {
        return false;
    }
}
/* Get City From State */
function getCity(){
    var state = $("#state").val();
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
                if(typeof($("#cityId")) != "undefined" && $("#cityId") !== null) {
                    if($("#cityId").val()==v.ct_id){
                        html += '<option value="'+v.ct_id+'" selected>'+v.ct_name+'</option>';    
                    }else{
                        html += '<option value="'+v.ct_id+'">'+v.ct_name+'</option>';        
                    }
                }else{
                    html += '<option value="'+v.ct_id+'">'+v.ct_name+'</option>';    
                }
                
            });
            $("#city").html(html);
        }
    });
}

function getState(a){
    var state = $('option:selected', $("#city")).attr('stateid');
    $("#state").val(state);
}
/* Create User Validation */
function CreateUserSubmit(flg){
    var userName = $("#userName").val()
    if(userName == ""){
        $("#userName").addClass('border border-danger');
        $("#userName").focus();
        return false;
    }else{
        $("#userName").removeClass('border border-danger');
    }
    var mobile = $("#mobile").val()
    if(mobile == ""){
        $("#mobile").addClass('border border-danger');
        $("#mobile").focus();
        return false;
    }else{
        var inputtxt = $("#mobile").val();
        if(phonenumber1(inputtxt) == true){
            $(".alert-msg span").text("");
            $(".alert-msg").addClass("d-none");
            $("#mobile").removeClass("border-danger");
        }else{
            $(".alert-msg span").text("Please Enter Valid Mobile Number.");
            $(".alert-msg").removeClass("d-none");
            $("#mobile").addClass("border-danger");
            $("#mobile").focus();
            return false;
        }
        $("#mobile").removeClass('border border-danger');
    }
    var email = $("#email").val()
    if(email == ""){
        $("#email").addClass('border border-danger');
        $("#email").focus();
        return false;
    }else{
        var valid = 0;
        if(validateEmail1($("#email").val())){
            valid = 1;
            $(".alert-msg span").text("");
            $(".alert-msg").addClass("d-none");
            $("#email").removeClass("border-danger");
        }else{
            valid = 0;
            $(".alert-msg span").text("Please Enter Valid Email Address.");
            $(".alert-msg").removeClass("d-none");
            $("#email").addClass("border-danger");
            $("#email").focus();
            return false;
        }
    }
    var password = $("#password").val()
    var conf_password = $("#conf_password").val()
    if(flg != 'edit'){
        if(password == ""){
            $("#password").addClass('border border-danger');
            $("#password").focus();
            return false;
        }else{
            $("#password").removeClass('border border-danger');
        }
        
        if(conf_password == ""){
            $("#conf_password").addClass('border border-danger');
            $("#conf_password").focus();
            return false;
        }else{
            $("#conf_password").removeClass('border border-danger');
        }
        if(password != conf_password){
            $("#password").addClass('border border-danger');
            $("#conf_password").addClass('border border-danger');
            $(".alert-msg span").text("Password Does Not Match.");
            $(".alert-msg").removeClass("d-none");
            $("#conf_password").focus();
            return false;
        }else{
            $("#password").removeClass('border border-danger');
            $("#conf_password").removeClass('border border-danger');
            $(".alert-msg").addClass("d-none");
        }
    }else{
        // if(password != ""){
        //     if(conf_password == ""){
        //         $("#conf_password").addClass('border border-danger');
        //         $("#conf_password").focus();
        //         return false;
        //     }
        // }
        // if(conf_password != ""){
        //     if(password == ""){
        //         $("#password").addClass('border border-danger');
        //         $("#password").focus();
        //         return false;
        //     }
        // }
        // if(password != "" && conf_password != ""){
        //     if(password != conf_password){
        //         $("#password").addClass('border border-danger');
        //         $("#conf_password").addClass('border border-danger');
        //         $(".alert-msg span").text("Password Does Not Match.");
        //         $(".alert-msg").removeClass("d-none");
        //         $("#conf_password").focus();
        //         return false;
        //     }else{
        //         $("#password").removeClass('border border-danger');
        //         $("#conf_password").removeClass('border border-danger');
        //         $(".alert-msg").addClass("d-none");
        //     }
        // }
    }
    var state = $("#state").val()
    if(state == ""){
        $("#state").addClass('border border-danger');
        $("#state").focus();
        return false;
    }else{
        $("#state").removeClass('border border-danger');
    }
    var city = $("#city").val()
    if(city == ""){
        $("#city").addClass('border border-danger');
        $("#city").focus();
        return false;
    }else{
        $("#city").removeClass('border border-danger');
    }
    var zipcode = $("#zipcode").val()
    if(zipcode == ""){
        $("#zipcode").addClass('border border-danger');
        $("#zipcode").focus();
        return false;
    }else{
        $("#zipcode").removeClass('border border-danger');
    }
    var address = $("#address").val()
    if(address == ""){
        $("#address").addClass('border border-danger');
        $("#address").focus();
        return false;
    }else{
        $("#address").removeClass('border border-danger');
    }
    if(flg == 'add'){
        $("#createUser").submit();
    }
    if(flg == 'edit'){
        $("#editUser").submit();
    }
}
/* Create Service Request Validation */



function CreateServiceRequestSubmit(flg){
    var regex = /^[a-zA-Z s]+$/;
    var mobregex = /^\d{10}$/;
    if($("#sc_name").val() == ""){
        $("#sc_name").addClass('border border-danger');
        $("#sc_name").focus();
        return false;
    }else if($("#sc_contact").val()==""){
        $("#sc_contact").addClass('border border-danger');
        $("#sc_contact").focus();
        return false;
    }else if($("#sc_open_time").val()==""){
        $("#sc_open_time").addClass('border border-danger');
        $("#sc_open_time").focus();
        return false;
    }else if($("#sc_close_time").val()==""){
        $("#sc_close_time").addClass('border border-danger');
        $("#sc_close_time").focus();
        return false;    
    }else if($("#sc_location").val()==""){
        $("#sc_location").addClass('border border-danger');
        $("#sc_location").focus();
        return false;        
    }else if($("#state").val()==""){
        $("#state").addClass('border border-danger');
        $("#state").focus();
        return false;
    }else if($("#city").val()==""){
        $("#city").addClass('border border-danger');
        $("#city").focus();
        return false;
    }else if(!$("#sc_name").val().match(regex)){
        alert('Please Enter Valid Service Center Name');
        $("#sc_name").addClass('border border-danger');
        $("#sc_name").focus();
        return false;
    }else if(!$("#sc_contact").val().match(mobregex)){
        alert('Please Enter Valid Contact Number.');
        $("#sc_contact").addClass('border border-danger');
        $("#sc_contact").focus();
        return false;                   
    }else{

        var jdt1=Date.parse('20 Aug 2000 '+$("#sc_open_time").val());
        var jdt2=Date.parse('20 Aug 2000 '+$("#sc_close_time").val());
        
        if(isNaN(jdt1))
        {
            alert('invalid start time');
            return false;
        }
        if(isNaN(jdt2))
        {
            alert('invalid end time');
            return false;
        }
        if (jdt1>jdt2)
        {
            alert('Close Time Can No Be greter than Open time');
            return false;
        }
        else
        {
            // alert('start is less equal');

        }
        
        $("#sc_name").removeClass('border border-danger');
        $("#sc_contact").removeClass('border border-danger');
        $("#sc_open_time").removeClass('border border-danger');
        $("#sc_close_time").removeClass('border border-danger');
        $("#sc_location").removeClass('border border-danger');
        $("#state").removeClass('border border-danger');
        $("#city").removeClass('border border-danger');

        $("#createServiceCenter").submit();
    }
}

function deleteUser(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_dashboard/deleteUser";
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
                    text: "Customer Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}

function BannerSubmit(a){
    if($("#bannerTitle").val()==''){
        $("#bannerTitle").addClass('border border-danger');
        $("#bannerTitle").focus();
        return false;
    }else if($("#desc").val()==''){
        $("#desc").addClass('border border-danger');
        $("#desc").focus();
        return false;
    }else if($("#sortorder").val()==''){
        $("#sortorder").addClass('border border-danger');
        $("#sortorder").focus();
        return false;
    }else if(document.getElementById("files").files.length == 0){
        $("#uplBtn").addClass('border border-danger');
        $("#uplBtn").focus();
        $("#fileErr").show();
        setTimeout(function(){
            $("#fileErr").hide();
        },3000);
        return false;     
    }else{
        $("#createBanner").submit();
    }

    if(a=='edit'){
        if($("#bannerTitle").val()==''){
            $("#bannerTitle").addClass('border border-danger');
            $("#bannerTitle").focus();
            return false;
        }else if($("#desc").val()==''){
            $("#desc").addClass('border border-danger');
            $("#desc").focus();
            return false;
        }else if($("#sortorder").val()==''){
            $("#sortorder").addClass('border border-danger');
            $("#sortorder").focus();
            return false;   
        }else{
            $("#createBanner").submit();
        }   
    }

}



function roleSubmit(){
    if($("#role_name").val()==''){
        $("#role_name").addClass('border border-danger');
        $("#role_name").focus();
        return false;
    }else if($("#reporting_to").val()==''){
        $("#reporting_to").addClass('border border-danger');
        $("#reporting_to").focus();
        return false;
    }else{
        $("#editRole").submit();
    } 
}


function CreateDealerSubmit(flg){

    if($("#sc_name").val() == ""){
        $("#sc_name").addClass('border border-danger');
        $("#sc_name").focus();
        return false;
    }else if($("#sc_contact").val()==""){
        $("#sc_contact").addClass('border border-danger');
        $("#sc_contact").focus();
        return false;  
    }else if($("#sc_location").val()==""){
        $("#sc_location").addClass('border border-danger');
        $("#sc_location").focus();
        return false;        
    }else if($("#state").val()==""){
        $("#state").addClass('border border-danger');
        $("#state").focus();
        return false;
    }else if($("#city").val()==""){
        $("#city").addClass('border border-danger');
        $("#city").focus();
        return false;                 
    }else{

        $("#sc_name").removeClass('border border-danger');
        $("#sc_contact").removeClass('border border-danger');
        
        $("#sc_location").removeClass('border border-danger');
        $("#state").removeClass('border border-danger');
        $("#city").removeClass('border border-danger');

        $("#createServiceCenter").submit();
    }
}

function deleteBanner(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_banner/deleteBanner";
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
                    text: "Banner Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}

function deleteBanner(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_banner/deleteBanner";
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
                    text: "Banner Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}

function deleteLesson(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_curriculum/deleteLesson";
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
                    text: "Lesson Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}



function deleteService(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_service_center/deleteService";
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
                    text: "Service Center Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}


function deleteDealer(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_dealer/deleteService";
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
                    text: "Dealer Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}

function deleteRole(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_role/deleteRole";
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
                    text: "Role Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}

function deleteCustomer(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#c41e3b",
        cancelButtonColor: "#fff",
        confirmButtonText: "Yes, delete it!"
    }).then(function(t) {
        var baseURL = $("#baseUrl").val();
        var ajxUrl = baseURL + "Ct_customer/deleteCustomer";
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
                    text: "Customer Removed SuccessFully.",
                    type: "success",
                    confirmButtonColor: "#c41e3b",
                    confirmButtonText: "OK"
                }).then((result) => {location.reload();});
            }
        });
    })
}



function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function checkUserStatus(th){
    if($(th).prop("checked") == true){
        $("#userStatusLabel").text("Active");
    }
    else if($(th).prop("checked") == false){
        $("#userStatusLabel").text("Inactive");
    }
}

$( document ).ready(function() {
    
    // $(".table-responsive").responsiveTable({addDisplayAllBtn:"btn btn-secondary"})
    var roleGet = getUrlParameter("rid")
    var role = roleGet;
    if (typeof roleGet === "undefined") {
        role = 3;
    }
    var baseURL = $("#baseUrl").val();
    var ajxUrl = baseURL + "Ct_role/getPermissionTree?id="+role;
    $("#roleId").val(role);
    var tree = $('#tree').tree({
        primaryKey: 'id',
        uiLibrary: 'bootstrap4',
        dataSource: ajxUrl,
        checkboxes: true
    });
    // rolePermission('2');
    $('#btnSave').on('click', function () {
        var checkedIds = tree.getCheckedNodes();
        // console.log(checkedIds);  
        var roleid = $("#roleId").val(); 
        if(checkedIds==''){
            alert('Please Select Atleast One Chekbox');
            return false;
        }else{
            $.ajax({ 
                url: baseURL + 'Ct_role/AddPermision',
                data: { perm: checkedIds, rolid:roleid },
                method: 'POST'
            }).fail(function () {
                alert('Failed to save.');
            }).done(function(){
                location.reload();
            });     
        }
       
    });
});

function CreateCustomerSubmit(a){
    if($("#cname").val() == ""){
        $("#cname").addClass('border border-danger');
        $("#cname").focus();
        return false;
    }else if($("#contact").val() == ""){
        $("#contact").addClass('border border-danger');
        $("#contact").focus();
        return false;
    }else if($("#address").val() == ""){
        $("#address").addClass('border border-danger');
        $("#address").focus();
        return false;
    }else if($("#city").val()==""){
        $("#city").addClass('border border-danger');
        $("#city").focus();
        return false;    
    }else if($("#state").val() == ""){
        $("#state").addClass('border border-danger');
        $("#state").focus();
        return false;
    }else if($("#zipcode").val() == ""){
        $("#zipcode").addClass('border border-danger');
        $("#zipcode").focus();
        return false;
    }else if($("#country").val() == ""){
        $("#country").addClass('border border-danger');
        $("#country").focus();
        return false;
    }else{
        if($("#alt_contact").val() == $("#contact").val()){
            alert('Both Contact Numbers Are Same');
            return false;
        }else{
            var flag = true;
            var contact1 = $("#contact").val();
            var contact2 = $("#alt_contact").val();
            var email = $("#email").val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var phoneno = /^\d{10}$/;
            if (!contact1.match(phoneno)) {
                alert('Please Enter Valid Contact Number');
                $("#contact").addClass('border border-danger');
                $("#contact").focus();
                flag=false;
                return false;
            }
            if($("#alt_contact").val()!=""){
                if(!contact2.match(phoneno)){
                    alert('Please Enter Valid Alternate Contact Number');
                    $("#alt_contact").addClass('border border-danger');
                    $("#alt_contact").focus();
                    flag=false;
                    return false;
                }     
            }
            if($("#email").val()!=""){
                if(!email.match(emailReg)){
                    alert('Please Enter Valid Email Address');
                    $("#email").addClass('border border-danger');
                    $("#email").focus();
                    flag=false;
                    return false;
                }
            }

            if(flag==true){
                $("#createCustomer").submit();    
            }else{

            }

            
        }
        
    } 
}

function CreateRoleUserSubmit(a){ 
    if($("#userImg").val() == ""){
        $("#userImg").addClass('border border-danger');
        $("#userImg").focus();
        return false;
    }else if($("#name").val() == ""){
        $("#name").addClass('border border-danger');
        $("#name").focus();
        return false;
    }else if($("#role").val() == ""){
        $("#role").addClass('border border-danger');
        $("#role").focus();
        return false;
    }else if($("#address").val() == ""){
        $("#address").addClass('border border-danger');
        $("#address").focus();
        return false;
    }else if($("#email").val() == ""){
        $("#email").addClass('border border-danger');
        $("#email").focus();
        return false;
    }else if($("#mobile").val() == ""){
        $("#mobile").addClass('border border-danger');
        $("#mobile").focus();
        return false;
    }else if($("#alt_mobile").val() == ""){
        $("#alt_mobile").addClass('border border-danger');
        $("#alt_mobile").focus();
        return false;
    }else if($("#address").val() == ""){
        $("#address").addClass('border border-danger');
        $("#address").focus();
        return false;
    }else if($("#state").val() == ""){
        $("#state").addClass('border border-danger');
        $("#state").focus();
        return false;
    }else if($("#city").val() == ""){
        $("#city").addClass('border border-danger');
        $("#city").focus();
        return false;
    }else if($("#zipcode").val() == ""){
        $("#zipcode").addClass('border border-danger');
        $("#zipcode").focus();
        return false;
    }else if($("#country").val() == ""){
        $("#country").addClass('border border-danger');
        $("#country").focus();
        return false;
    }
    
    if(a=="add"){
        $("#createRoleUser").submit();
    }
    if(a=="edit"){
        
    }
}



// $(document).on('click','#btnSave',function(){
//      var baseURL = $("#baseUrl").val();
//      var checkedIds = tree.getCheckedNodes();
//      var roleid = $("#roleId").val();
//      $.post(baseURL+"Ct_role/AddPermision",{rolid:roleid,perm:checkedIds},function(data){

//      });
// });


//function rolePermission(a){
//    
//    $(".table-responsive").responsiveTable({addDisplayAllBtn:"btn btn-secondary"})
//    
//    var baseURL = $("#baseUrl").val();
//    $("#roleId").val(a);
//
//    var ajxUrl = baseURL + "Ct_role/getPermissionTree?id="+a;
// $("#roleId").val(a);
// var tree = $('#tree').tree({
//     primaryKey: 'id',
//     uiLibrary: 'bootstrap4',
//     dataSource: ajxUrl,
//     checkboxes: true
// });
// tree.reload();

// $.get(baseURL + "Ct_role/getPermissionTree?id="+a,{},function(data){
            
//            var tree = $('#tree').tree({
//                primaryKey: 'id',
//                uiLibrary: 'bootstrap4',
//                dataSource:  ajxUrl,
//                checkboxes: false,
//                // autoLoad: true
//            });            
//            tree.reload();
// });
    
//}

// function rolePermission(a){
//     //alert(a);
//     var baseURL = $("#baseUrl").val();
//     var ajxUrl = baseURL + "Ct_role/getPermissionTree?id="+a;
//     $("#roleId").val(a);
//     // alert(ajxUrl);
//     var tree = $('#tree').tree({
//         primaryKey: 'id',
//         uiLibrary: 'bootstrap4',
//         dataSource: ajxUrl,
//         checkboxes: true
//     });
//     // console.log(tree);
    
// }