<link href="<?= base_url() ?>app-assets/js/dcharts/dist/apexcharts.css" rel="stylesheet" type="text/css" />
<div class="col-sm-6 ">
    <div id="donut-chart1" class="apex-charts"></div>
</div>

<div class="col-sm-6">
<div>
    <div class="row">
        <div class="col-12">
            <div class="count-text">

        		<?php
            $classes = $this->tb_class->getAllRecords();
            $i=1;
            foreach ($classes as $key => $value) {
               // $getCount = getMultiWhere('user_register',array('id'),array('class'=>$value['class_id'],'MONTH(added_on)'=>$month),'1');
               if(array_key_exists($value['class_id'],$data)){
                  $getCount = $data[$value['class_id']];
               }else{
                  $getCount = 0;
               }  
               if($i%2==0){
                  $color = "#52d6ed;";
               }else{
                  $color = "#333395";
               }
            ?>
              <p class=""><h6><i class="mdi mdi-circle  mr-1" style="color: <?php echo $color ?>"></i><span class="counttetx"><?= $getCount ?></span>
                 <span class="titlevl"> <?= $value['title']; ?></span></h6>
              </p>
            <?php
              $i++;   
            }
            ?>        
             </div>
        </div>
            

        </div>
    </div>
</div>

<script src="<?= base_url() ?>app-assets/js/dcharts/dist/apexcharts.js"></script>
<?php
	
?>
<script type="text/javascript">

    var cnt =[]; var cls = [];
    var options = {
          // series: [15,50,200,10],
          // colors: ['#32a5fc', '#fecc6a', '#52ecb8', '#ff5f76'],   
          series: [<?php 
            $nums=""; $color="";
            $classes = $this->tb_class->getAllRecords();
            $i=1;
            foreach ($classes as $key => $value) {
          
              if(array_key_exists($value['class_id'],$data)){
                  $getCount = $data[$value['class_id']];
               }else{
                  $getCount = 0;
               } 
               if($getCount>0){
                  if($value['class_id']=="1"){
                    $color .="'#333395',";
                  }else if($value['class_id']=="2"){
                    $color .="'#52d6ed',";
                  }
                  $nums .=$getCount.",";    
               }
             }
             // echo $nums;
             if($nums!='' || $nums!='0,0'){ echo rtrim($nums,","); }?>],
          colors: [<?php if($nums!=''){ echo rtrim($color,","); } ?>],
          chart: {
          width: 200,
          height:200,
          type: 'donut',
        },
        labels: [<?php if($nums!=''){ ?>'Early childhood I','Early childhood II'<?php } ?>],
        
        dataLabels: {
          enabled: false,
        },
        legend:{
            show:false,
            horizontalAlign: "right",
            verticalAlign: "center"
        },

        stroke:{
          show: true,
          curve: 'smooth',
          lineCap : 'square',
          width: 4,
          dashArray : 0,  
        },

       noData: {
          text: 'No Records Found',
          align: 'center',
          verticalAlign: 'middle',
          offsetX: 0,
          offsetY: 0,
          style: {
            color: '#894739',
            fontSize: '14px',
            //fontFamily: undefined
          }
        },
        
        
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'center'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#donut-chart1"), options);
        chart.render();

</script>