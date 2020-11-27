<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_notification_cron extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('user');
		$this->load->model('tb_class');
		$this->load->model('package');
		$this->load->model('notifications');
		$this->load->model('Curriculum');
		$this->load->helper('get_data_helper');
		$this->load->helper(array('url','html','form'));

	}

	public function notifications(){
		$title = '';
		$allNotification = $this->notifications->getAllRecords();


		foreach ($allNotification as $i => $notiData) {
			/* For All User */

			if($notiData['type'] == 'allusers'){

				$getallUser = $this->notifications->getAllUsers('all',$notiData['class_id']);
				
				foreach ($getallUser as $k => $userData) {
					$classDay = json_decode($notiData['class_day']);
					if(in_array($userData['current_day'], $classDay)){
						
						$cNot = $this->notifications->checkUserStoreNotification($userData['id'],$notiData['notifi_id']);
						if(count($cNot)>0){
						}else{
							$this->SendNotification($userData['user_id'],$userData['token'],$title,strip_tags($notiData['message']));
							$data = array("user_id"=>$userData['id'],"notifi_id"=>$notiData['notifi_id'],"created_at"=>date("Y-m-d h:i:s"));

							$store = $this->notifications->insertuserNotification($data);
						}
					}
				}
			}
			/* For Free Demo User */
			if($notiData['type'] == 'freeusers'){
				
				
				$getFreeUser = $this->notifications->getAllUsers('free',$notiData['class_id']);
				foreach ($getFreeUser as $k => $userData) {
					$classDay = json_decode($notiData['class_day']);
					if(in_array($userData['current_day'], $classDay)){
						
						
						$cNot = $this->notifications->checkUserStoreNotification($userData['id'],$notiData['notifi_id']);
						if(count($cNot)>0){
						}else{
							$this->SendNotification($userData['user_id'],$userData['token'],$title,strip_tags($notiData['message']));
							$data = array("user_id"=>$userData['id'],"notifi_id"=>$notiData['notifi_id'],"created_at"=>date("Y-m-d h:i:s"));
							
							$store = $this->notifications->insertuserNotification($data);
						}
					}
				}
			}
			/* For Premium User */
			if($notiData['type'] == 'premiumusers'){
				
				$getPremUser = $this->notifications->getAllUsers('premium',$notiData['class_id']);
				foreach ($getPremUser as $k => $userData) {
					$classDay = json_decode($notiData['class_day']);
					if(in_array($userData['current_day'], $classDay)){
						
						
						$cNot = $this->notifications->checkUserStoreNotification($userData['id'],$notiData['notifi_id']);
						if(count($cNot)>0){
						}else{
							$this->SendNotification($userData['user_id'],$userData['token'],$title,strip_tags($notiData['message']));
							$data = array("user_id"=>$userData['id'],"notifi_id"=>$notiData['notifi_id'],"created_at"=>date("Y-m-d h:i:s"));
							
							$store = $this->notifications->insertuserNotification($data);
						}
					}
				}
			}
			/* For Specific User */
			if($notiData['type'] == 'exusers'){
				
				$getSpecUser = $this->notifications->getAllUsers($notiData['userid'],$notiData['class_id']);
				foreach ($getSpecUser as $k => $userData) {
					$classDay = json_decode($notiData['class_day']);
					if(in_array($userData['current_day'], $classDay)){
						
						
						$cNot = $this->notifications->checkUserStoreNotification($userData['id'],$notiData['notifi_id']);
						if(count($cNot)>0){
						}else{
							$this->SendNotification($userData['user_id'],$userData['token'],$title,strip_tags($notiData['message']));
							$data = array("user_id"=>$userData['id'],"notifi_id"=>$notiData['notifi_id'],"created_at"=>date("Y-m-d h:i:s"));

							
							$store = $this->notifications->insertuserNotification($data);
						}
					}
				}
			}
		}

		

	}

	public function SendNotification($userid,$token,$title,$body){

		$body = $body;



        // define('API_ACCESS_KEY1','AAAAj1iX-qc:APA91bEA-mraNGerlIco_-sFMkac3BsnR1gGP4FMZXivPZF97ehDe4aMTAe8sr6XkwayQIB5oo9lOvqjksHKE9IoLJ5IP84A0_O3PtYV5KGSW6DMlrH2KtCMRJJ7CJQ9A65S7I9eFTw5');

		$url = "https://fcm.googleapis.com/fcm/send";
		$token = $token;
		$serverKey = 'AAAAj1iX-qc:APA91bEA-mraNGerlIco_-sFMkac3BsnR1gGP4FMZXivPZF97ehDe4aMTAe8sr6XkwayQIB5oo9lOvqjksHKE9IoLJ5IP84A0_O3PtYV5KGSW6DMlrH2KtCMRJJ7CJQ9A65S7I9eFTw5';

		// if($type=="1"){
		// 	$title = "Fundoomoms Payment Reminder";
		// 	$body = "Please Complete Your Payment To Access Your Account";
		// }else if($type=="2"){
		// 	$title = "Fundoomoms Days Stops";
		// 	$body = "Please Move Ahed to your Curriculum";
		// }    



		$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default',
			 'icon'=>'fundoomoms_notification_logo' ,
			 'color'=>'#83035c',
			 'badge' => '1',
			 'click_action' => 'NotificationActivity');
		$arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key='. $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        //Send the request
		$response = curl_exec($ch);
        //Close request
		if ($response === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
	}

}
?>