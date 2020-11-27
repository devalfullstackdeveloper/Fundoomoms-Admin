<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();
        $this->customerTbl = 'customer';
    }

    public function customerList() {
        $this->db->select('*');
        $this->db->from($this->customerTbl);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    

    public function insert($data){
        $insert = $this->db->insert($this->customerTbl, $data);
        return $insert ? $this->db->insert_id() : false;
    }


    public function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->customerTbl);
        $this->db->where('cust_id', $params['cust_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function update($data, $id) {
        //add modified date if not exists
        if (!array_key_exists('modified_on', $data)) {
            $data['modified_on'] = date("Y-m-d H:i:s");
        }

        //update user data in users table
        $update = $this->db->update($this->customerTbl, $data, array('cust_id' => $id));
        //return the status
        return $update ? true : false;
    }

    public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('customer', array('cust_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function checkEmail($email,$id=""){
        if(!empty($id)){
            $qry = "SELECT `cust_id` FROM `customer` WHERE ( `email` = '".$email."' ) and `cust_id` !='".$id."'";
        }else{
            $qry = "SELECT `cust_id` FROM `customer` WHERE ( `email` = '".$email."')";
        }
        $exe = $this->db->query($qry);
        $result = $exe->result_array();
        return $result;  
    }

    public function CheckMobile($mobile,$id=""){
        if(!empty($id)){
            $qry = "SELECT `cust_id` FROM `customer` WHERE ( `contact` = '".$mobile."' OR `alt_contact` = '".$mobile."' ) and ( `contact` is not null OR `alt_contact` is not null ) and `cust_id` !='".$id."'";
        }else{
            $qry = "SELECT `cust_id` FROM `customer` WHERE ( `contact` = '".$mobile."' OR `alt_contact` = '".$mobile."' )";
        }
        $exe = $this->db->query($qry);
        $result = $exe->result_array();
        return $result;     
    }
}