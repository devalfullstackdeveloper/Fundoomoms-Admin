<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class notifications extends CI_Model {    

	public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->notifications = 'tb_admin_notify';
        $this->notificationlog = 'tb_notification_log';
        $this->storeNotifi = 'tb_storeusernotification';
    }

    /**
    *
    **/

    public	function getAllRecords($id='') {
	 	$this->db->select('*');
        $this->db->from($this->notifications);
        if($id != ""){
            $this->db->where('notifi_id',$id);
        }
        $this->db->order_by('notifi_id','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
	 }

	  public function insert($data) {
        $insert = $this->db->insert($this->notifications, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * 
     */

    public function update($data, $id) {
        $update = $this->db->update($this->notifications, $data, array('notifi_id' => $id));
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('tb_admin_notify', array('notifi_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function getRows($id){
    	$this->db->select('*');
    	$this->db->from($this->notifications);
    	$this->db->where('notifi_id',$id);
    	$query = $this->db->get();
    	$result = $query->row_array();
    	return $result;
    }

    public function getAllUsers($type,$class){
        $cond = "";
        if($type == 'free'){
            $cond = ' WHERE p.pay_status = 0 and class="'.$class.'"';
        }elseif ($type == 'premium') {
            $cond = ' WHERE p.pay_status = 1  and class="'.$class.'"';
        }elseif ($type == 'all') {
            $cond = 'WHERE class="'.$class.'"';
        }else{
            $uids = json_decode($type);
            $cond = ' WHERE p.user_id IN('.implode(",", $uids).') and class="'.$class.'"';
        }
        
        $qry = "SELECT * FROM payment_details AS p INNER JOIN user_register AS u ON (p.user_id = u.id)".$cond;
        $exe = $this->db->query($qry);
        $res = $exe->result_array();
        foreach ($res as $key => $value) {
            if(empty($value['current_day'])){
                $res[$key]['current_day'] = "1";
            }else{
                $res[$key]['current_day'] = $value['current_day'];
            }
        }

        return $res;
    }

    public function GetUserNot($class="",$access=""){
        $this->db->select('payment_details.payment_id,payment_details.user_id,
                payment_details.created_date,payment_details.pay_status,
                payment_details.current_day,user_register.id,user_register.token,user_register.class,user_register.package');
        $this->db->from('payment_details');
        $this->db->join('user_register','payment_details.user_id=user_register.id');
        if($class=="all"){
        }else{
            $this->db->where('user_register.class',$class);
        }
        if($access=="all"){
            $where1 = "(payment_details.pay_status='0' or payment_details.pay_status='1')";
            $this->db->where($where1);
        }else{
            $this->db->where('payment_details.pay_status',$access);
        }        
        $this->db->order_by('payment_details.user_id','desc');
        $query = $this->db->get();
        $result = $query->result_array();
         $today = date("Y-m-d");
                $users = array();
        foreach ($result as $key => $value) {
           
         

             // if(count($user)>0){


                 // die($user[0]['class']);
                 $classDay = getData('tb_class',array('c_days'),'class_id',$value['class']);
                 $created_date = $value['created_date'];
                 $end_date = date("Y-m-d",strtotime("+".$classDay[0]['c_days']." days",strtotime($created_date)));
                 if($today<=$end_date){
                     // $Interval = $this->getDateInterVal($created_date,$end_date,"3");
                     // if(count($Interval)>0){
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($created_date)));
                        $curDay = (!empty($value['current_day'])) ? date("Y-m-d",strtotime("+".$value['current_day']." days",strtotime($value['created_date']))) : '';
                        // echo $curDay."<br>";
                        $fifteen2 = (!empty($curDay)) ? date("Y-m-d",strtotime("+15 days",strtotime($curDay))) : '';
                        // echo $fifteen2."<br>";
                        if($today>$fifteen){
                            if(empty($value['current_day'])){
                                $users[$key]['noused'] = $value['user_id'];
                            }else if((int)$value['current_day']<15){
                                $users[$key]['noahed'] = $value['user_id'];
                            }
                        }else if(!empty($fifteen2)){
                            if($today>$fifteen2){
                                $users[$key]['noahed'] = $value['user_id']; 
                            }
                        }

                  
                 }
        }
        return $users;
    }


    public function userNotificationList($month="",$year="",$class){
        $this->db->select('notifi_id,type,userid');
        $this->db->from($this->notifications);
        if(!empty($month)){
            $this->db->where("MONTH(created_at)",$month);    
        }
        if(!empty($year)){
            $this->db->where("YEAR(created_at)",$year);
        }
        $this->db->where('class_id',$class);
        $this->db->order_by('notifi_id','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function insertNotificationLog($data){
        $insert = $this->db->insert($this->notificationlog, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    public function UpdateNotificationLog($notId,$data){
        $update = $this->db->update($this->notificationlog, $data, array('notifi_id' => $notId));
        return $update ? $id : false;
    }

    public function checkUserStoreNotification($userid,$notid){
        $this->db->select('id');
        $this->db->from($this->storeNotifi);
        $this->db->where('user_id',$userid);
        $this->db->where('notifi_id',$notid);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function insertuserNotification($data){
        $insert = $this->db->insert($this->storeNotifi, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    public function getUserStoredNotification($userid){
        
        $this->db->select('*');
        $this->db->from($this->storeNotifi);
        $this->db->where('user_id',$userid);
        $this->db->order_by('notifi_id','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
}

