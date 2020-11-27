<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ServiceCenter extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

//        $this->userTbl = 'users';
        $this->userTbl = 'user_register';
        $this->statesTbl = 'states';
        $this->citiesTbl = 'cities';
        $this->serviceCenterTbl = 'service_center';
    }

    public function serviceCenter($id = "") {
        $this->db->select('*');
        $this->db->from($this->serviceCenterTbl);
        if($id != ""){
            $this->db->where('sc_id',$id);
        }
        $query = $this->db->order_by('sc_id',"DESC")->get();
//        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->serviceCenterTbl);
        $this->db->where('sc_id', $params['sc_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function GetLastIncr(){
        $this->db->select('inc_id');
        $this->db->from($this->serviceCenterTbl);
        $query = $this->db->order_by('sc_id',"desc")->get();
        $result = $query->row_array();
        return $result;   
    }

    public function insert($data){
        $insert = $this->db->insert($this->serviceCenterTbl, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    public function update($data, $id){
          //add modified date if not exists
        if (!array_key_exists('modified_date', $data)) {
            $data['modified_date'] = date("Y-m-d H:i:s");
        }

        //update user data in users table
        $update = $this->db->update($this->serviceCenterTbl, $data, array('sc_id' => $id));
        //return the status
        return $update ? true : false;
    }

    public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('service_center', array('sc_id' => $id));
        //return the status
        return $delete ? true : false;
    }

}