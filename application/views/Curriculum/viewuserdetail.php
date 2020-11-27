<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('LoadPages/yorkHeader');
?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content customer-detail">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $page_name ?></h4>
                    <div class="page-title-right">
                        <?= $breadCrumb ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        
                        $userInfo = $this->user->getRows(array('id'=>$userData['created_by']));
                        $uservalidity = getValidity($userData['id']);
                        ?>
                        <input type="hidden" name="" id="customerId" value="<?= $userData['id']; ?>">
                        <input type="hidden" name="" id="baseUrl" value="<?= base_url() ?>">
                        <div class="row">
                            <div class="col-lg-1 pr-0"><img class="img-fluid" src="<?= base_url() ?>app-assets/images/profile.png" /></div>
                            <div class="col-lg-11">
                                <div class="row">
                                    <div class="col-lg-10">
                                    	<?php
                                        	$sql="select payment_details.user_id, payment_details.created_date from payment_details, user_register where user_register.id = payment_details.user_id AND user_register.id=".$userData['id'];
                                        	$query = $this->db->query($sql);
        									$paid = $query->result_array();
                                        ?>
                                    	<div class="row mb-3">
                                    		<div class="col-lg-2"><h6 class="parent-name">Parents Name</h6><span><b class="all-name-list"><?= $userData['name']; ?></b></span></div>
                                    		<div class="col-lg-2"><h6 class="id-user">ID</h6><span><b class="all-name-list"><?= $userData['ref_id']; ?></b></span></div>
                                    		<div class="col-lg-3"><h6 class="email-data">Email ID</h6><span><b class="all-name-list"><?= $userData['email']; ?></b></span></div>
                                    		<div class="col-lg-2"><h6 class="mobile-num">Mobile Number</h6><span><b class="all-name-list"><?= $userData['mobile']; ?></b></span></div>
                                    		<div class="col-lg-3"><h6 class="validity">Validity</h6><span><b class="all-name-list">
                                    			<?php if(count($paid) > 0) {
        											// echo "30/365";
                                                     echo $uservalidity['validity'];
        										} else {
        											echo "-";
        										}
                                                ?>
                                    		</b></span></div>
                                    	</div>
                                    	<div class="row">
                                    		<div class="col-lg-2"><h6 class="child-name">Child Name</h6><span><b  class="all-name-list"><?= $userData['child_name']; ?></b></span></div>
                                    		<div class="col-lg-2"><h6 class="child-age">Child Age</h6><span><b  class="all-name-list"><?= $userData['child_age']; ?></b></span></div>
                                    	   <div class="col-lg-3"><h6 class="classes">Class</h6 ><span><b  class="all-name-list">
                                                <?php
                                                if($userData['child_age'] == "3 to 4 Years") { 
                                                    echo "Early Childhood I";
                                                } elseif($userData['child_age'] == "4 to 5 Years") {
                                                    echo "Early Childhood II";
                                                } elseif($userData['child_age'] == "5 to 6 Years") {
                                                    echo "Early Childhood III";
                                                } 
                                                ?>
                                            </b></span></div>
                                    		<div class="col-lg-2"><h6>Access</h6><span><b>
                                    			<?php if(count($paid) > 0) {
        											echo "<span class='paid-user badge '>Full Course</span>";
        										} else {
        											echo "<span class='free-user badge badge-warning'>Free Demo</span>";
        										}
                                                ?>
                                    		</b></span></div>
                                    		<div class="col-lg-3"><h6 class="classes" >Completed Days</h6><span><b  class="all-name-list">
                                    			<?php if(count($paid) > 0) {
        											// echo "20/180";
                                                     echo $uservalidity['completed'];
        										} else {
        											echo "-";
        										}
                                                ?>
                                    		</b></span></div>
                                    	</div>
                                    </div>
                                    <div class="col-lg-2 p-0">
                                        <div class="user_dateblock">
            	                            <div class="row">
            		                            <div class="col-xl-6">
            		                            	<a href="<?= base_url() ?>Ct_dashboard/editUser/<?= $userData['id'] ?>" class="btn btn-light btn-sm  btntop"><i class="bx bxs-pencil"></i> Edit</a>
            		                            	<h6 class="classess">Created Date</h6> <b class="all-name-list"><?= date('M d', strtotime($userData['added_on'])) ?></b>
            		                            </div>
            		                            <div class="col-xl-6 p-0">
            		                            	<?php
            		                            	if($userData['status'] == '1') {
            		                            		$block_url = base_url()."Ct_dashboard/blockUser/".$userData['id'];
            										?>
            										<button type="button" class="btn btn-light btn-sm btntop" data-toggle="modal" data-target="#blockModal">Block</button>
            										<?php	
            										} else {
            											$block_url = "";
            										?>
            										<a href="<?= base_url() ?>Ct_dashboard/unblockUser/<?= $userData['id'] ?>" class="btn btn-light btn-sm ">Unblock</a>
            										<?php
            										}
            		                            	?>
													<div id="blockModal" class="modal fade" role="dialog">
													  <div class="modal-dialog">
													    <div class="modal-content">
													      <div class="modal-header">
													        <h4 class="modal-title">Block <?= $userData['name']; ?></h4>
													        <button type="button" class="close subscription_popupClose" data-dismiss="modal">&times;</button>
													      </div>
													      <div class="modal-body">
													        <p>Do you really want to block <?= $userData['name']; ?>?</p>
													      </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-primary" id="modal-btn-si">Block</button>
        													<button type="button" class="btn btn-primary" id="modal-btn-no">Cancel</button>
													      </div>
													    </div>
													  </div>
													</div>
            		                            	<h6 class="classess">Payment Login</h6><b class="all-name-list">
            		                            	<?php
            		                            	if(count($paid) > 0) {
            		                            		$payment_date = $paid[0]['created_date'];
            		                            		echo date('M d, Y', strtotime($payment_date));
            		                            	} else {
            		                            		echo "-";
            		                            	}
            		                            	?>
            		                            	</b>
            		                            </div>
            	                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

		 <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if(count($paid)>0){
                            $valid = explode("/", $uservalidity['completed']);

                            $percentage = ($valid[1]-($valid[0]));
                            $percentage = ($valid[1]-$percentage);
                            $validDay = $valid[0];
                            $totalDay = $valid[1];
                        }else{
                            $validDay = "";
                            $totalDay = "0";
                            $percentage = 0;

                        }

                    ?>    
                    <h6 class="day-complt"><?php echo $validDay; ?> Days Completed</h6>
                     <div class="progress myprogrs">
                        <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="180"></div>
                    </div>
                    <span class="number-progres"><?php echo "0"; ?></span>
                    <span class="float-right class="number-progres""><?= $totalDay ?> Days</span>
                    </div>
                </div>
            </div>
         </div>
         
         <div class="row" data-select2-id="12">
            <div class="col-12">
                <div class="card">
                    <div class="">
                    <div class="row m-0">
                    	<div class="col-lg-6 p-0 reqAppt">
                    	</div>
                    	
                        <div class="col-lg-6 reqData card-body mom-view-detail">
                            
                    	</div>

                    </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
    <!-- End Page-content -->
    
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    Copyright © <script>document.write(new Date().getFullYear())</script> FundooMoms. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end main content-->
<!-- Right bar overlay-->
<!--<div class="rightbar-overlay"></div>-->
<?php $this->load->view('LoadPages/yorkFooter'); ?>
<script type="text/javascript">
    $("#datatable-buttons1").dataTable({
        "searching": false,
        "bLengthChange": false,
        "bInfo": false,
    });
    
    var blockurl = "<?php echo $block_url ?>"; 
    console.log(blockurl);
    var modalConfirm = function(callback){
	        jQuery('.subscription_popupClose').click(function () {
	        	callback(false);
	        });

		 	jQuery("#modal-btn-si").on("click", function(){
			  	console.log("Yes");
			    callback(true);
			    jQuery(".subscription_popupClose").trigger("click");
			});
		  
			jQuery("#modal-btn-no").on("click", function(){
			  	console.log("No");
			    callback(false);
			    jQuery(".subscription_popupClose").trigger("click");
			});
		};
		modalConfirm(function(confirm){
		  if(confirm){
		   window.location.href = blockurl;
		  }
		});
</script>