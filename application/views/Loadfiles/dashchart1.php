<link href="<?= base_url() ?>app-assets/js/dcharts/dist/apexcharts.css" rel="stylesheet" type="text/css" />
<div class="col-sm-3 p-0">
    <div id="donut-chart" class="apex-charts"></div>
</div>

<div class="col-sm-9">
    <div class="row">
        <div class="col-lg-4">
        		<?php
    //     		$active = getMultiWhere('payment_details',array('payment_id'),array('MONTH(created_date)'=>$month,'YEAR(created_date)'=>date('Y')),'1');
    //     		$totFree = getMultiWhere('payment_details',array('payment_id'),array('MONTH(created_date)'=>$month,'pay_status'=>'0','YEAR(created_date)'=>date('Y')),'1');
				// $totPay = getMultiWhere('payment_details',array('payment_id'),array('MONTH(created_date)'=>$month,'pay_status'=>'1','YEAR(created_date)'=>date('Y')),'1');

            $active = (int)$freedemo['free'] + (int)$fullcourse['full'];
            $totFree = $freedemo['free'];
            $totPay = $fullcourse['full'];
        		?>
        		<h6 class="total-num"><p class="number-active mb-0"><?= $active ?></p> </h6>	
            <span>Total Active Mom's</span>
          </div>
        			<div class="col-lg-4">
        				<h6 class="total-num"><i class="mdi mdi-circle  mr-2" style="color: #333395;"></i><?= $totFree ?></h6>
        					<span class="free-full" >Free Demo Access</span>
        						
        			</div>
        			<div class="col-lg-4">
        				<h6 class="total-num"><i class="mdi mdi-circle  mr-2" style="color: #52d6ed;"></i><?= $totPay ?></h6>
                <span class="free-full" >	Full Course </span>
        				
        			</div>
        		
        		
                
                <!-- <b class="cnt" color="<?= $value['chart_color'] ?>"><?= $stData ?></b> <?= $value['stext']; ?> <?= $text; ?></h6></p>  -->      	                       
                      
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
          series: [<?php $nums=''; 
            if($totFree>0 && $totPay>0){ 
              $nums = $totFree.",".$totPay; 
            }else if($totFree>0){
              $nums = $totFree;
            }else if($totPay>0){
              $nums = $totPay;
            }
            if($nums!=''){
              echo $nums;
            }?>],
          colors: [<?php if($nums!=''){ ?>'#333395','#52d6ed'<?php } ?>],
          chart: {
          width: 130,
          height: 130,
           
          type: 'donut',
        },

        labels: [<?php if($nums!=''){ ?>'Free Demo Access','Full Course'<?php } ?>],

        borderWidth: [50,50],
        
        dataLabels: {
          enabled: false,
        },
        legend:{
            show:false,
            horizontalAlign: "right",
            verticalAlign: "center"
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

        var chart = new ApexCharts(document.querySelector("#donut-chart"), options);
        chart.render();

</script>