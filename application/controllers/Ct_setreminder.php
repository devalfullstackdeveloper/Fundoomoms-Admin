<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_setreminder extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form'));
        $this->load->model('curriculum');
    }
        
    
    public function getThreeDaysReminder(){ 
            
        $payment = getMultiWhere("payment_details",array('payment_id','user_id','created_date','pay_status','current_day'),array("pay_status"=>"0"),'','user_id','desc');
        $today = date("Y-m-d");
        $userIds = array();
        foreach ($payment as $key => $value) {
            $user = getData('user_register',array('id','token','class','package'),'id',$value['user_id']);
            // $user = getData('user_register',array('id','token','class','package'),'id','211');
            $created_date = $value['created_date'];
            $end_date = date("Y-m-d",strtotime("+30 days",strtotime($created_date)));
            // die($user[0]['token']);
            if($today<=$end_date){
                $Interval = $this->getDateInterVal($created_date,$end_date,"3");
                if(count($Interval)>0){
                    $this->SendNotification($value['user_id'],"1",$user[0]['token']);
                }
            }
        }
        
    }

    public function getFifteenDaysReminder(){
        
        $payment = getMultiWhere("payment_details",array('payment_id','user_id','created_date','pay_status','current_day'),array(),'','user_id','desc',"1");
        $today = date("Y-m-d");

         foreach ($payment as $key => $value) {
             $user = getData('user_register',array('id','token','class','package'),'id',$value['user_id']);
             if(count($user)>0){
                 $classDay = getData('tb_class',array('c_days'),'class_id',$user[0]['class']);
                 $created_date = $value['created_date'];
                 $end_date = date("Y-m-d",strtotime("+".$classDay[0]['c_days']." days",strtotime($created_date)));
                 if($today<=$end_date){
                     $Interval = $this->getDateInterVal($created_date,$end_date,"3");
                     if(count($Interval)>0){
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($created_date)));
                        if($today>$fifteen){
                            if(empty($value['current_day'])){
                                
                                 $this->SendNotification($value['user_id'],"2",$user[0]['token']);
                            }else if((int)$value['current_day']<15){
                                
                                 $this->SendNotification($value['user_id'],"2",$user[0]['token']);
                               
                            }
                        }
                     }
                 }
             }
         }
    }

    public function getCompleteAtReminder(){
        $payment = getMultiWhere("payment_details",array('payment_id','user_id','created_date','pay_status','current_day'),array("pay_status"=>"1"),'','user_id','desc');
        $today = date("Y-m-d");
        foreach ($payment as $key => $value) {
             $classDay = getData('tb_class',array('c_days'),'class_id',$user[0]['class']);
             $created_date = $value['created_date'];
             $end_date = date("Y-m-d",strtotime("+".$classDay[0]['c_days']." days",strtotime($created_date)));
            if($today<=$end_date){
                         
            }       
        }
    }


    public function SendNotification($userid,$type,$token){
        
        // define('API_ACCESS_KEY1','AAAAj1iX-qc:APA91bEA-mraNGerlIco_-sFMkac3BsnR1gGP4FMZXivPZF97ehDe4aMTAe8sr6XkwayQIB5oo9lOvqjksHKE9IoLJ5IP84A0_O3PtYV5KGSW6DMlrH2KtCMRJJ7CJQ9A65S7I9eFTw5');

        $url = "https://fcm.googleapis.com/fcm/send";
        $token = $token;
        $serverKey = 'AAAAj1iX-qc:APA91bEA-mraNGerlIco_-sFMkac3BsnR1gGP4FMZXivPZF97ehDe4aMTAe8sr6XkwayQIB5oo9lOvqjksHKE9IoLJ5IP84A0_O3PtYV5KGSW6DMlrH2KtCMRJJ7CJQ9A65S7I9eFTw5';
            
        if($type=="1"){
            $title = "Fundoomoms Payment Reminder";
            $body = "Please Complete Your Payment To Access Your Account";
        }else if($type=="2"){
            $title = "Fundoomoms Days Stops";
            $body = "Please Move Ahed to your Curriculum";
        }    
        
        
        
        $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
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


    public function getDateInterVal($start_date,$end_date,$interval){
        $today = date("Y-m-d");
        $begin = new DateTime($start_date);
        $end = new DateTime($end_date);

        $interval = DateInterval::createFromDateString($interval.' day');
        $period = new DatePeriod($begin, $interval, $end);

        $dateArr = array();
        foreach ($period as $dt) {
            if($today==$dt->format("Y-m-d")){
                array_push($dateArr, $dt->format("Y-m-d"));
            }
        }
        return $dateArr;
    }
    
    

}   