<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dealer extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

//        $this->userTbl = 'users';
        $this->userTbl = 'user_register';
        $this->statesTbl = 'states';
        $this->citiesTbl = 'cities';
        $this->dealer = 'dealer';
    }

    public function serviceCenter($id = "") {
        $this->db->select('*');
        $this->db->from($this->dealer);
        if($id != ""){
            $this->db->where('dl_id',$id);
        }
        $query = $this->db->order_by('dl_id',"DESC")->get();
        $result = $query->result_array();
        return $result;
    }

    public function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->dealer);
        $this->db->where('dl_id', $params['dl_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function GetLastIncr(){
        $this->db->select('inc_id');
        $this->db->from($this->dealer);
        $query = $this->db->order_by('dl_id',"desc")->get();
        $result = $query->row_array();
        return $result;   
    }

    public function insert($data){
        $insert = $this->db->insert($this->dealer, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    public function update($data, $id){
          //add modified date if not exists
        if (!array_key_exists('dl_modified_date', $data)) {
            $data['dl_modified_date'] = date("Y-m-d H:i:s");
        }

        //update user data in users table
        $update = $this->db->update($this->dealer, $data, array('dl_id' => $id));
        //return the status
        return $update ? true : false;
    }

    public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('dealer', array('dl_id' => $id));
        //return the status
        return $delete ? true : false;
    }

}