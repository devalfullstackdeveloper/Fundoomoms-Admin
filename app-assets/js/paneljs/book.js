var baseURL = $("#baseUrl").val();

const start = moment().startOf('month');
const end   = moment().endOf('month');

function loadData1(start,end,sclass,sch){
    $.post(baseURL+'Ct_bookrequest/requestLoad',{start:start,end:end,fclass:sclass,fstatus:sch},function(data){
        $(".LoadRequest").html(data);
        $("#menu_3").text('Call Request');
    });
}

loadData1(start.format('MMMM D, YYYY'),end.format('MMMM D, YYYY'),'all','all');

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $("#ranges").val(start.format('MMMM D, YYYY') + '-' + end.format('MMMM D, YYYY'));
    $("#ranges").trigger('change');
}

setTimeout(function(){
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker({
      startDate: start,
      endDate: end,
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
  }, cb);
},1000);
cb(start, end);

$(document).on('change','#ranges',function(){
    var explode = $("#ranges").val();
    explode = explode.split('-');
    var sclass = $(".cClass").val();
    var sch = $(".sch").val();
    loadData1(explode[0],explode[1],sclass,sch);
    setTimeout(function(){
        $('#reportrange span').html(explode[0] + ' - ' + explode[1]);
          $('#reportrange').daterangepicker({
          startDate: explode[0],
          endDate: explode[1],
          ranges: {
             'Today': [moment(), moment()],
             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb);
    },1000);
});


$(document).on('change','.changeStatus',function(){
    var bookId = $(this).children("option:selected").attr('reqId');
    $.post(baseURL+"Ct_bookrequest/setStatus",{id:bookId,status:$(this).val()},function(data){
        var data = JSON.parse(data);
        if(data['status']==true){
            $(".sucDiv").show();
            $(".sucDiv").html(data['message']);
            setTimeout(function(){
                location.reload();
            },1000);
        }else{
            $(".errDiv").show();
            $(".errDiv").html(data['message']);
            setTimeout(function(){
                $(".errDiv").html('');
                $(".errDiv").hide();
            },2500);
        }
    });
});




$(document).on('change','.fMonth, .cClass, .sch',function(){
     var explode = $("#ranges").val();
    explode = explode.split('-');
    var sclass = $(".cClass").val();
    var sch = $(".sch").val();
    loadData1(explode[0],explode[1],sclass,sch);
    setTimeout(function(){
        $('#reportrange span').html(explode[0] + ' - ' + explode[1]);
          $('#reportrange').daterangepicker({
          startDate: explode[0],
          endDate: explode[1],
          ranges: {
             'Today': [moment(), moment()],
             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb);
    },1000);
});





