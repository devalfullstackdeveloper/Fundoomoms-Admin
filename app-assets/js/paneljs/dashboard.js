var baseURL = $("#base_url").val(); 
// const start = moment().startOf('month');
const start = moment().month(0).date(1).year('2020').hours(0).minutes(0).seconds(0).milliseconds(0);
const end   = moment().endOf('month');

console.log(start)
function loadData1(start,end,sclass,sch){
  console.log(start);
  $.post(baseURL+'Ct_dashboard/load_dashboard_request',{start:start,end:end,fclass:sclass,fstatus:sch},function(data){
      $(".LoadList").html(data);
      // $("#menu_3").text('Call Request');
  });
}

loadData1(start.format('MMMM D, YYYY'),end.format('MMMM D, YYYY'),'all','all');

$(function() {
    // var start = moment().subtract(29, 'days');
    // var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        DashSelectMoms(start.format('Y-M-D'), end.format('Y-M-D'));
    }

    function cb1(start, end) {
        $('#reportrange1 span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        DashSelectMomsCharts(start.format('Y-M-D'), end.format('Y-M-D'));
    }

    function cb2(start, end) {
        $('#reportrange2 span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        DashSelectClassChart(start.format('Y-M-D'), end.format('Y-M-D'));
    }

   

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

    $('#reportrange1').daterangepicker({
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
    }, cb1);

    $('#reportrange2').daterangepicker({
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
    }, cb2);

    
   
    

    cb(start, end);
    cb1(start, end);
    cb2(start, end);
    
});

function cb3(start, end) {
        $('#reportrange3 span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#rangesbook").val(start.format('MMMM D, YYYY') + '-' + end.format('MMMM D, YYYY'));
        $("#rangesbook").trigger('change');
  }

setTimeout(function(){

  $('#reportrange3').daterangepicker({
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
    }, cb3);

     

},1000);


function DashSelectMoms(start,end){

    $.post(baseURL+'Ct_dashboard/LoadDashMoms',{start:start,end:end},function(data){
        $(".LoadMoms").html(data);
    });
}

function DashSelectMomsCharts(start, end){
    $.post(baseURL+'Ct_dashboard/LoadDashCharte1',{start:start,end:end},function(data){
        $(".LoadMomsChart").html(data);
    });
}


function DashSelectClassChart(start, end){
  $.post(baseURL+'Ct_dashboard/LoadDashClassChart',{start:start,end:end},function(data){
      $(".LoadClassChart").html(data);
  });
}


$(document).on('change','#rangesbook',function(){
    
    var explode = $("#rangesbook").val();
    explode = explode.split('-');
    var sclass = $(".cClass").val();
    var sch = $(".sch").val();
    loadData1(explode[0],explode[1],sclass,sch);
    setTimeout(function(){
        $('#reportrange3 span').html(explode[0] + ' - ' + explode[1]);
          $('#reportrange3').daterangepicker({
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
      }, cb3);
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
     var explode = $("#rangesbook").val();
    explode = explode.split('-');
    var sclass = $(".cClass").val();
    var sch = $(".sch").val();
    loadData1(explode[0],explode[1],sclass,sch);
    setTimeout(function(){
        $('#reportrange3 span').html(explode[0] + ' - ' + explode[1]);
          $('#reportrange3').daterangepicker({
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
      }, c3);
    },1000);
});


 $(document).on('click','.exportBtn',function(){
        var cls  = $(".cClass").val();
        // var month = $(".fMonth").val();
        var explode = $("#rangesbook").val();
        explode = explode.split('-');
        var start = new Date(explode[0]);
        var end = new Date(explode[1]);
        var smom = moment(start);
        var smomdate = smom.format('YYYY-MM-DD');

        var emom = moment(end);
        var emomdate = emom.format('YYYY-MM-DD');

        var status = $(".sch").val();
        var url = decodeURI(baseURL+'Ct_bookrequest/ExportRequest/'+smomdate+'/'+emomdate+'/'+cls+'/'+status);

        // alert(baseURL+'Ct_bookrequest/ExportRequest/'+start+'/'+end+'/'+cls+'/'+status);
        window.location.href=url;
    });