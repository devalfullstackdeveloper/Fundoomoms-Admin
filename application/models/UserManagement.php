<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UserManagement extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

//        $this->userTbl = 'users';
        $this->userTbl = 'user_register';
        $this->statesTbl = 'states';
        $this->citiesTbl = 'cities';
    }

    public function getLastInsRoleUser($role) {
        $qry = "SELECT * FROM user_register WHERE role = ".$role."";
        $exe = $this->db->query($qry);
        $result = $exe->row_array();
    }

    public function insert($data) {
      
        $insert = $this->db->insert($this->userTbl, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    public function UsersList($role){
        $this->db->select('*');
        $this->db->from($this->userTbl);
        $this->db->where("role",$role);
        $this->db->order_by("id","desc");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getRow($id){
        $this->db->select("*");
        $this->db->from($this->userTbl);
        $this->db->where("id",$id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
}

?>