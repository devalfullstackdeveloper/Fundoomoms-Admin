<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banners extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

//        $this->userTbl = 'users';
        $this->userTbl = 'user_register';
        $this->statesTbl = 'states';
        $this->citiesTbl = 'cities';
        $this->bannersTbl = 'mobile_banners';
    }

    public function mobileBannerList() {
        $this->db->select('*');
        $this->db->from($this->bannersTbl);
        $this->db->where('mb_status',1);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function mobileBannerListPreview() {
        $this->db->select('*');
        $this->db->from($this->bannersTbl);
        $this->db->where('mb_status',1);
        $query = $this->db->order_by('mb_position','asc')->get();
        $result = $query->result_array();
        return $result;
    }

    public function insert($data){
        $insert = $this->db->insert($this->bannersTbl, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }


    public function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->bannersTbl);
        $this->db->where('mb_id', $params['mb_id']);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function update($data, $id) {
        //add modified date if not exists
        if (!array_key_exists('mb_modified_on', $data)) {
            $data['mb_modified_on'] = date("Y-m-d H:i:s");
        }

        //update user data in users table
        $update = $this->db->update($this->bannersTbl, $data, array('mb_id' => $id));
        //return the status
        return $update ? true : false;
    }

    public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('mobile_banners', array('mb_id' => $id));
        //return the status
        return $delete ? true : false;
    }
}