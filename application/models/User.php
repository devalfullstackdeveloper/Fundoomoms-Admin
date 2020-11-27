<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

//        $this->userTbl = 'users';
        $this->userTbl = 'user_register';
        $this->statesTbl = 'states';
        $this->citiesTbl = 'cities';
        $this->roleTbl = 'role';
        $this->pass_token = 'tb_password_token';
        $this->payment = 'payment_details';
        $this->adminnotyfi = 'tb_storeadminnotification';
         
         
//        $this->rolePermissionTbl = 'role_permission';
    }

    /*
     * Get rows from the users table
     */

    function getRows($params = array()) {
        $this->db->select('*');
        $this->db->from($this->userTbl);

        //fetch data by conditions
        if (array_key_exists("role", $params)) {
            $this->db->where('role', $params['role']);
            $this->db->order_by("id", "desc");
        }

        if (array_key_exists("id", $params)) {
            $this->db->where('id', $params['id']);
            $this->db->order_by("id", "desc");
            $query = $this->db->get();
            $result = $query->row_array();
        } else {
            //set start and limit
            if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }

            if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
                $result = $this->db->count_all_results();
            } elseif (array_key_exists("returnType", $params) && $params['returnType'] == 'single') {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->row_array() : false;
            } else {
                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : false;
            }
        }

        //return fetched data
        return $result;
    }

    /*
     * Insert user data
     */

    public function insert($data) {
        //add created and modified date if not exists
//        if (!array_key_exists("created", $data)) {
//            $data['created'] = date("Y-m-d H:i:s");
//        }
//        if (!array_key_exists("modified", $data)) {
//            $data['modified'] = date("Y-m-d H:i:s");
//        }
        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * Update user data
     */

    public function update($data, $id) {
        //add modified date if not exists
        if (!array_key_exists('modified_on', $data)) {
            $data['modified_on'] = date("Y-m-d H:i:s");
        }

        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('id' => $id));
        //return the status
        return $update ? $id : false;
    }

    /*
     * Delete user data
     */

    public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('user_register', array('id' => $id));
        //return the status
        return $delete ? true : false;
    }

    /* Get States */

    public function states($stateId = "") {
        $this->db->select('st_id, st_name');
        $this->db->from($this->statesTbl);
        $this->db->where('status', '1');
        if ($stateId != "") {
            $this->db->where('st_id', $stateId);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /* Get Cities From States */

    public function cities($state, $cityId = "") {
        $this->db->select('ct_id, ct_name, st_id');
        $this->db->from($this->citiesTbl);
        $this->db->where('status', '1');
        if ($state != "0") {
            $this->db->where('st_id', $state);
        }
        if ($cityId != "") {
            $this->db->where('ct_id', $cityId);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function citiesData($cityId) {
        $this->db->select('ct_id, ct_name, st_id');
        $this->db->from($this->citiesTbl);
        $this->db->where('status', '1');
        $this->db->where('ct_id', $cityId);

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /* Check Email is Exist Or Not */

    public function checkEmail($email, $id = "") {
        // $this->db->select('*');
        // $this->db->from($this->userTbl);
        // $this->db->where('email', $email);
        // if ($id != "") {
        //     $this->db->where('id !=', $id);
        // }
        // $this->db->where('status',"1");
        $this->db->select('u.*');
        $this->db->from('user_register as u');
        $this->db->join('payment_details as p','p.user_id = u.id');
        $this->db->where('u.email',$email);
        if($id!=""){
            $this->db->where('u.id !=',$id);
        }
        $result = $this->db->count_all_results();
        return $result;
    }

    /* Check Mobile is Exist Or Not */

    public function checkMobile($mobile, $id = "") {
        // $this->db->select('*');
        // $this->db->from($this->userTbl);
        // $this->db->where('mobile',$mobile);
        // if ($id != "") {
        //     $this->db->where('id !=', $id);
        // }
        // $this->db->where('status',"1");
        $this->db->select('u.*');
        $this->db->from('user_register as u');
        $this->db->join('payment_details as p','p.user_id = u.id');
        $this->db->where('u.mobile',$mobile);
        if($id!=""){
            $this->db->where('u.id !=',$id);
        }
        $result = $this->db->count_all_results();
        return $result;
    }

    public function getMobileNo($mobile) {
        $this->db->select('id');
        $this->db->from($this->userTbl);
        $this->db->where('mobile', $mobile);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /* Check Mobile is Exist Or Not */

    public function checkLogin($email, $password, $isAdmin = 0, $isRow=false) {
        // $this->db->select('id, name, email, mobile, token, gender, address, state, city, zipcode, role, role.role_name');
        // $this->db->from($this->userTbl);
        // $this->db->join('role', 'user_register.role = role.role_id');
        // $this->db->where('password', $password);        
        // $this->db->where('status', '1');        
        // $this->db->where('is_admin', $isAdmin);        
        // $this->db->where('email', $email);        
        // $this->db->or_where('mobile', $email);        
        // $query = $this->db->get();
        // print_r($this->db->last_query()); 
        // die();
        // $qry = "SELECT `id`, `name`, `email`, `mobile`, `token`, `gender`, `address`, `state`, `city`, `zipcode`, `role`, `is_admin` ,
        //         `role`.`role_name`
        //         FROM `user_register`
        //         JOIN `role` ON `user_register`.`role` = `role`.`role_id`
        //         WHERE `password` = '".$password."'
        //         AND `status` = '1'
        //         AND `is_admin` = ".$isAdmin." AND ( `email` = '".$email."' OR `mobile` = '".$email."')";

        if($isAdmin==1){
            $qry = "SELECT `id`, `name`, `email`, `mobile`, `token`, `role`, `is_admin`, `user_img`,
                `role`.`role_name`, `child_name` , `class`
                FROM `user_register`
                JOIN `role` ON `user_register`.`role` = `role`.`role_id`
                WHERE `password` = '" . $password . "'
                AND `status` = '1' AND ( `email` = '" . $email . "' OR `mobile` = '" . $email . "') and is_admin='1'";
        }else{
            $qry = "SELECT `id`, `name`, `email`, `mobile`, `token`, `role`, `is_admin`, `user_img`, `status`,
                `role`.`role_name`, `child_name` , `class`
                FROM `user_register`
                JOIN `role` ON `user_register`.`role` = `role`.`role_id`
                WHERE `password` = '" . $password . "' AND ( `email` = '" . $email . "' OR `mobile` = '" . $email . "') ORDER BY `user_register`.`id` DESC LIMIT 1" ;
        }

        
        // echo $qry;
        // die();        
        $exe = $this->db->query($qry);
        // $tot = $exe->result();
        // echo count($exe);

        if($isRow==true){
            $result = $exe->result_array();
        }else{
            $result = $exe->row_array();    
        }
        
        // if (!$result) {
        //     $result = array();
        // }
        return $result;
    }

    public function addState($state) {
        $this->db->select('*');
        $this->db->from($this->statesTbl);
        $this->db->where('st_name', trim($state));
        $query = $this->db->get();
        $result = $query->row_array();

        if ($result != "") {
            return $result['st_id'];
        } else {
            $data = array('st_name' => trim($state), 'status' => 1, 'added_by' => 1);
            $insert = $this->db->insert($this->statesTbl, $data);
            //return the status
            return $insert ? $this->db->insert_id() : false;
        }
    }

    public function addCity($city, $stateId) {
        $this->db->select('*');
        $this->db->from($this->citiesTbl);
        $this->db->where('st_id', $stateId);
        $this->db->where('ct_name', trim($city));
        $query = $this->db->get();
        $result = $query->row_array();

        if ($result != "") {
            return $result['ct_id'];
        } else {
            $data = array('st_id' => $stateId, 'ct_name' => $city, 'status' => 1, 'added_by' => 1);
            $insert = $this->db->insert($this->citiesTbl, $data);
            //return the status
            return $insert ? $this->db->insert_id() : false;
        }
    }

    public function nearestServiceCenter($lat, $long, $distance, $city) {
        // $Qry = "SELECT DISTINCT sc_id, sc_ref, 
        //         ( 3959 * acos ( cos ( radians(".$lat.") ) * cos( radians( sc_lat ) ) * cos( radians( sc_long ) - radians(".$long.") ) + sin ( radians(".$lat.") ) * sin( radians( sc_lat ) ) ) ) AS distance,
        //             sc_name, sc_open_time, sc_close_time, sc_location, sc_state, sc_city, sc_lat, sc_long, sc_contact, sc_sort_desc, sc_created_by, created_date, modified_date
        //             FROM service_center HAVING distance < ".$distance." ORDER BY distance";

        if ($lat == "" && $long == "" && $city == "") {
            return array();
        } else {

            $distanceQ = ' ,"" AS distance';
            $distanceCond = '';

            if ($lat != "" && $long != "") {
                $distanceQ = ', ( 3959 * acos ( cos ( radians("' . $lat . '") ) * cos( radians( sc_lat ) ) * cos( radians( sc_long ) - radians("' . $long . '") ) + sin ( radians("' . $lat . '") ) * sin( radians( sc_lat ) ) ) ) AS distance';
                if ($city == "") {
                    $distanceCond = ' HAVING distance < "' . $distance . '" ORDER BY distance';
                }
            }
            $cityQ = "";
            if ($city != "") {
                $cityQ = ' WHERE sc_city = "' . $city . '"';
            }

            $Qry = "SELECT DISTINCT sc_id, sc_ref " . $distanceQ . ",
                        sc_name, sc_open_time, sc_close_time, sc_location, sc_state, sc_city, sc_lat, sc_long, sc_contact, sc_sort_desc, sc_created_by, created_date, modified_date
                        FROM service_center " . $cityQ . $distanceCond;

            $exe = $this->db->query($Qry);
            $res = $exe->result_array();
            return $res;
        }
    }

    public function nearestDealer($lat, $long, $distance, $city) {
        // $Qry = "SELECT DISTINCT dl_id, dl_reference, 
        //         ( 3959 * acos ( cos ( radians(".$lat.") ) * cos( radians( dl_lat ) ) * cos( radians( dl_long ) - radians(".$long.") ) + sin ( radians(".$lat.") ) * sin( radians( dl_lat ) ) ) ) AS distance,
        //             dl_name, dl_contact, dl_email, dl_location, dl_state, dl_city, dl_lat, dl_long, dl_sort_desc, dl_created_by, dl_created_date, dl_modified_date
        //             FROM dealer HAVING distance < ".$distance." ORDER BY distance";

        $distanceQ = ' ,"" AS distance';
        $distanceCond = '';

        if ($lat != "" && $long != "") {
            $distanceQ = ', ( 3959 * acos ( cos ( radians("' . $lat . '") ) * cos( radians( dl_lat ) ) * cos( radians( dl_long ) - radians("' . $long . '") ) + sin ( radians("' . $lat . '") ) * sin( radians( dl_lat ) ) ) ) AS distance';
            $distanceCond = ' HAVING distance < "' . $distance . '" ORDER BY distance';
        }
        $cityQ = "";
        if ($city != "") {
            $cityQ = ' WHERE dl_city = "' . $city . '"';
        }
        $Qry = "SELECT DISTINCT dl_id, dl_reference" . $distanceQ . ",
                    dl_name, dl_contact, dl_email, dl_location, dl_state, dl_city, dl_lat, dl_long, dl_sort_desc, dl_created_by, dl_created_date, dl_modified_date
                    FROM dealer " . $cityQ . $distanceCond;
        $exe = $this->db->query($Qry);
        $res = $exe->result_array();
        return $res;
    }

    public function mobileBanners() {
        $Qry = "SELECT * FROM `mobile_banners` WHERE mb_status = 1 ORDER BY mb_position";
        $exe = $this->db->query($Qry);
        $res = $exe->result_array();
        return $res;
    }

    public function mainMenu() {
        $Qry = "SELECT * FROM `main_menu` WHERE mm_status = 1";
        $exe = $this->db->query($Qry);
        $res = $exe->result_array();
        return $res;
    }

    public function subMenu($mmid) {
        $Qry = "SELECT * FROM `sub_menu` WHERE sm_status = 1 AND mm_id = " . $mmid;
        $exe = $this->db->query($Qry);
        $res = $exe->result_array();
        return $res;
    }

    public function subSubMenu($mmid, $smid) {
        $Qry = "SELECT * FROM `sub_sub_menu` WHERE status = 1 AND mm_id = " . $mmid . ' AND sm_id = ' . $smid;
        $exe = $this->db->query($Qry);
        $res = $exe->result_array();
        return $res;
    }

    public function verifyOtp($id, $otp) {
        $this->db->select('id');
        $this->db->from($this->userTbl);
        $this->db->where("id", $id);
        $this->db->where("otp", $otp);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function UserRef($role) {
        $this->db->select_max('inc_id');
        $this->db->from($this->userTbl);
        $this->db->where('role', $role);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function rolePrefix($role) {
        $this->db->select('prefix');
        $this->db->from($this->roleTbl);
        $this->db->where('role_id', $role);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function rolePermission($role) {
        $this->db->select('*');
        $this->db->from('role_permission');
        $this->db->where('role_id', $role);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function SetUserRef() {
        $this->db->select('*');
        $this->db->from($this->userTbl);
        // $this->db->where('role',$role);
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            $incr = $this->user->UserRef($value['role']);
            if ($incr->inc_id > 0) {
                if ($incr->inc_id <= 10) {
                    if ($incr->inc_id < 9) {
                        $ref_id = "YC0000" . ($incr->inc_id + 1);
                    } else {
                        $ref_id = "YC000" . ($incr->inc_id + 1);
                    }
                } else if ($incr->inc_id <= 100) {
                    if ($incr->inc_id < 99) {
                        $ref_id = "YC000" . ($incr->inc_id + 1);
                    } else {
                        $ref_id = "YC00" . ($incr->inc_id + 1);
                    }
                } else if ($incr->inc_id <= 1000) {
                    if ($incr->inc_id < 999) {
                        $ref_id = "YC00" . ($incr->inc_id + 1);
                    } else {
                        $ref_id = "YC0" . ($incr->inc_id + 1);
                    }
                } else if ($incr->inc_id <= 10000) {
                    if ($incr->inc_id < 1999) {
                        $ref_id = "YC0" . ($incr->inc_id + 1);
                    } else {
                        $ref_id = "YC0" . ($incr->inc_id + 1);
                    }
                } else {
                    $ref_id = "YC" . ($incr->inc_id + 1);
                }
                $inCr = ($incr->inc_id + 1);
            } else {
                $ref_id = "YC00001";
                $inCr = 1;
            }

            $query2 = "UPDATE `user_register` SET `inc_id`='$inCr', `ref_id`='$ref_id' WHERE `id`='" . $value['id'] . "'";
            $exe = $this->db->query($query2);
        }
    }

    public function SearchService($param = array()) {
        
    }

    public function getActiveMenu($menu, $table) {
        $this->db->select('*');
        $this->db->from($table);
        if ($table == 'main_menu') {
            $this->db->where('mm_name', $menu);
        } elseif ($table == 'sub_menu') {
            $this->db->where('sm_name', $menu);
        } elseif ($table == 'sub_sub_menu') {
            $this->db->where('ss_name', $menu);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        if ($table == 'main_menu') {
            return "MM_".$result['mm_id'];
        } elseif ($table == 'sub_menu') {
            return "SM_".$result['sm_id'];
        } elseif ($table == 'sub_sub_menu') {
            return "SS_".$result['ss_id'];
        }
        
    }
    
    public function getRolePermission($role){
        $this->db->select('*');
        $this->db->from('role_permission');
        $this->db->where('role_id', $role);
        $query = $this->db->get();
        $result = $query->row_array();
        $permission = array();
        if(isset($result) && count($result) > 0){
            $permission = json_decode($result['permission']);
        }
        return $permission;
    }

    
	public function GetUserInfoByParams($params=array()){
        if($params>0){
            $this->db->select('*');
            $this->db->from($this->userTbl);
            $this->db->where('status','1');
            foreach ($params as $key => $value) {
                $this->db->where($key,$value);
            }
            $query = $this->db->get();
            $result = $query->result_array();
        }else{
            $result = array();
        }
        return $result;
    }     

    public function SetForgorPassToken($data){
        $insert = $this->db->insert($this->pass_token,$data);
        return $insert;
    }

    public function RemoveForgotPassToken($id){
        $remove = $this->db->delete($this->pass_token,array('token_id'=>$id));
        return $remove;
    }
    
    public function userInfoFromToken($token){
        $this->db->select('*');
        $this->db->from($this->userTbl);
        $this->db->where('status','1');
        $this->db->where('token',$token);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getPaymentDetail($id){
        $this->db->select('*');
        $this->db->from($this->payment);
        $this->db->where('user_id',$id);
        $this->db->order_by('payment_id','desc')->limit(1);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function addPayment($data){
       $insert = $this->db->insert($this->payment,$data);
       return $insert ? $this->db->insert_id() : false;
    }

    public function UpdatePayment($data,$id){
       $insert = $this->db->update($this->payment,$data,array("payment_id"=>$id));
       return $insert ? true : false;
    }

    public function SearchUser($start="",$end="",$class="",$course="",$status=""){

         $query = "SELECT u.* FROM user_register as u join payment_details as p on p.user_id=u.id";
         $query .=" WHERE (u.status='0' or u.status='1') and u.name!='Admin'";

         if($month!='all'){
            $start = date("Y-m-d",strtotime($start));
            $end = date("Y-m-d",strtotime($end));
            $query .=" and u.added_on BETWEEN '".$start."' and '".$end."'";
         }

         if($class!='all'){
            $query .=" and u.class='".$class."'";
         }

         if($course!='all'){
            if($course=='freedemo'){
                $query.=" and p.pay_status='0'";
            }
            if($course=='fullcourse'){
                $query.=" and p.pay_status='1'";
            }
         }

         // if($status!='all'){
            
         //    if($status=='active'){
         //    }else if($status=='inactive'){
         //        $inactive = $this->getInactiveUser($course);
         //        if(!empty($inactive)){
         //            $query .=" and id in(".$inactive.")";
         //        }
         //    }

         // }

         $query .=" order by id desc";

         // die($query);

         $exe = $this->db->query($query);
        $result = $exe->result_array();
        return $result;

        // $this->db->select('*');
        // $this->db->from($this->userTbl);
        // if($month != 'all'){
        //     $this->db->where("MONTH(added_on)",$month);
        // }
        // if($class!='all'){
        //     $this->db->where('class',$class);
        // }
        // if($course!="all"){
        //     if($course=="freedemo"){
        //         $this->db->where('access','1');
        //     }
        //     if($course=="fullcourse"){
        //         $this->db->where('access','2');
        //     }
        // }
        // if($status != "" && $status != "all"){

        //     if($status=="active"){
        //         $this->db->where('status','1');
        //     }
        //     if($status=="inactive"){
        //         $this->db->where('status','2');
        //     }
        // }
        // $this->db->order_by('id','desc');
        // $query = $this->db->get();
        // $result = $query->result_array();
        // return $result;
    }

    public function getInactiveUser(){
        $this->db->select("created_date,current_day,user_id");
        $this->db->from('payment_details');

        $query1 = $this->db->get();
        $result = $query1->result_array();
        $ids = array();
        if(count($result)>0){
            $today = date("Y-m-d");
            foreach ($result as $key => $value) {
                if(empty($value['current_day'])){
                    $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($value['created_date'])));
                    if($today>$fifteen){
                        array_push($ids,$value['user_id']);
                    }
                }else{
                    if($value['current_day']>=15){
                        $current_day = date("Y-m-d",strtotime("+".$value['current_day']." days",strtotime($value['created_date'])));
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($current_day)));
                        $chkF = $value['current_day']+15;
                        if($today>$fifteen){
                            if($value['current_day']<$chkF){
                                array_push($ids,$value['user_id']);
                            }
                        }
                    }else{
                        $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($value['created_date'])));
                        if($today>$fifteen){
                            if($value['current_day']<15){
                                array_push($ids,$value['user_id']);
                            }
                        }
                    }
                }
            }
        }
        $ids = array_unique($ids);
        $implode = implode(",", $ids);
        return $implode;
    }


    // public function getActiveUser($course){
    //     $this->db->select("created_date,current_day,user_id");
    //     $this->db->from('payment_details');

    //     $query1 = $this->db->get();
    //     $result = $query1->result_array();
    //     $ids = array();
    //     if(count($result)>0){
    //         $today = date("Y-m-d");
    //         foreach ($result as $key => $value) {
    //             if(empty($value['current_day'])){
    //                 $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($value['created_date'])));
    //                 if($today>$fifteen){
    //                 }else{
    //                     array_push($ids,$value['user_id']);
    //                 }
    //             }else{
    //                 if($value['current_day']>=15){
    //                     $current_day = date("Y-m-d",strtotime("+".$value['current_day']." days",strtotime($value['created_date'])));
    //                     $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($current_day)));
    //                     $chkF = $value['current_day']+15;
    //                     if($today>$fifteen){
    //                         if($value['current_day']<$chkF){
    //                         }else{
    //                              array_push($ids,$value['user_id']);
    //                         }
    //                     }
    //                 }else{
    //                     $fifteen = date("Y-m-d",strtotime("+15 days",strtotime($value['created_date'])));
    //                     if($today>$fifteen){
    //                         if($value['current_day']<15){
    //                         }else{
    //                             array_push($ids,$value['user_id']);
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     $ids = array_unique($ids);
    //     $implode = implode(",", $ids);
    //     return $implode;
    // }


    public function getuserPayment($class="",$access=""){
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
        return $result;
    }

    public function getNotviewedRequest(){
        $this->db->select("*");
        $this->db->from('book_call');
        $this->db->where("is_view",0);
        $query = $this->db->get();
        $result1 = $query->result_array();
        return count($result1);   
    }


    public function countDashBoradMoms($startdate, $enddate,$type){
        $moms = array();
        if((!empty($startdate)) || (!empty($enddate))){
            if($type=="grand"){
                $this->db->select('u.id');
                $this->db->from('user_register as u');
                $this->db->join('payment_details as p','p.user_id=u.id');
                $whereBetween = ("u.added_on BETWEEN '".$startdate."' and '".$enddate."'");
                $this->db->where($whereBetween);
                $this->db->where('role','5');
                $query1 = $this->db->count_all_results();
                $moms['grandmoms'] = $query1;    
                // print_r($this->db->last_query());  
                // die();
            }

            if($type=="active"){
                $userList = $this->user->SearchUser($startdate,$enddate,'all','all','active');
                $inactive = getInactiveUser();
                if(count($userList)>0){
                    foreach ($userList as $key => $value) {
                        if(in_array($value['id'], $inactive)){
                            unset($userList[$key]);
                        }
                    }
                }
                // $this->db->select('u.id');
                // $this->db->from('user_register as u');
                // $this->db->join('payment_details as p','p.user_id=u.id');
                // $whereBetween = ("u.added_on BETWEEN '".$startdate."' and '".$enddate."'");
                // $this->db->where('u.status','1');
                // $this->db->where($whereBetween);
                // $this->db->where('role','5');
                // $query2 = $this->db->count_all_results();
                // $moms['activemom'] = $query2;
                $moms['activemom'] = count($userList);
            }
        }
        return $moms;
    }

    public function dashBoradMomsChart($startdate, $enddate, $type){
        $moms = array();
        if((!empty($startdate)) || (!empty($enddate))){
            if($type=="freedemo"){
                $this->db->select('p.payment_id');
                $this->db->from('user_register as u');
                $this->db->join('payment_details as p','p.user_id=u.id');
                $whereBetween = ("u.added_on BETWEEN '".$startdate."' and '".$enddate."'");
                $this->db->where($whereBetween);
                $this->db->where('p.pay_status','0');
                $this->db->where('role','5');
                $query1 = $this->db->count_all_results();
                $moms['free'] = $query1;    
            }

            if($type=="fullcourse"){
                $this->db->select('p.payment_id');
                $this->db->from('user_register as u');
                $this->db->join('payment_details as p','p.user_id=u.id');
                $whereBetween = ("u.added_on BETWEEN '".$startdate."' and '".$enddate."'");
                $this->db->where($whereBetween);
                $this->db->where('p.pay_status','1');
                $this->db->where('role','5');
                $query1 = $this->db->count_all_results();
                $moms['full'] = $query1;
            }
        }
        return $moms;
    }

    public function DashClassChart($startdate, $enddate, $class){
        $moms = 0;
        if((!empty($startdate)) || (!empty($enddate))){
            $this->db->select('u.id');
            $this->db->from('user_register as u');
            $this->db->join('payment_details as p','p.user_id=u.id');
            $whereBetween = ("u.added_on BETWEEN '".$startdate."' and '".$enddate."'");
            $this->db->where($whereBetween);
            $this->db->where('u.class',$class);
            $this->db->where('role','5');
            $query1 = $this->db->count_all_results();
            $moms += $query1;
        }
        return $moms;
    }


    public function storeadminNotify($data){
       $insert = $this->db->insert($this->adminnotyfi,$data);
       return $insert ? $this->db->insert_id() : false;
    }

    public function checkadminNotify($user_id,$type){
        $this->db->select('*');
        $this->db->from($this->adminnotyfi);
        $this->db->where('user_id',$user_id);
        $this->db->where('type',$type);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function updateUserIsView(){
        $update = $this->db->update($this->userTbl,array('is_view'=>'1'),array('is_view'=>'0'));
        return $update ? $user_id : false ;
    }

    public function countNewUser(){
        $this->db->select('id');
        $this->db->from($this->userTbl);
        $this->db->where('is_view','0');
        $query = $this->db->count_all_results();
        return $query;
    } 

    public function totActiveMoms(){
        $query = "SELECT COUNT(*) AS totMoms FROM user_register as u join payment_details as p on p.user_id=u.id WHERE (u.status='0' or u.status='1') and u.name!='Admin'";
        $exe = $this->db->query($query);
        $result = $exe->row_array();
        return $result;
    }

    public function totEarlyChild1(){
        $query = "SELECT COUNT(*) AS totMoms FROM user_register as u join payment_details as p on p.user_id=u.id WHERE (u.status='0' or u.status='1') and u.name!='Admin' and u.class = '1'";
        $exe = $this->db->query($query);
        $result = $exe->row_array();
        return $result;
    }

    public function totEarlyChild2(){
        $query = "SELECT COUNT(*) AS totMoms FROM user_register as u join payment_details as p on p.user_id=u.id WHERE (u.status='0' or u.status='1') and u.name!='Admin' and u.class = '2'";
        $exe = $this->db->query($query);
        $result = $exe->row_array();
        return $result;
    }
}