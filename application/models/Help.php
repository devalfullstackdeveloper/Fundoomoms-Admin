<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Help extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

		$this->curriculum = 'curriculum';
        //$this->lesson = 'lesson';
        $this->user = "user_register";
        $this->book = "book_call";
        $this->help = "tb_help";
        $this->helpSub = "tb_help_sub";
    }
    
    /*
     * Get curriculum data
     */
     
     public	function getAllRecords($help_id='',$type='') {
	 	$this->db->select('*');
        $this->db->from($this->helpSub);
        if(!empty($type)){
            $this->db->where('htype',$type);
        }
        if(!empty($help_id)){
            $this->db->where('helpid',$help_id);    
        }
        $this->db->order_by('hsub_id','desc');
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        return $result;
	 }

    /*
     * Insert curriculum data
     */

    public function insert($data) {
        $insert = $this->db->insert($this->helpSub, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * Update curriculum data
     */

    public function update($data, $id) {
        //add modified date if not exists
        /*
        if (!array_key_exists('modified_on', $data)) {
            $data['modified_on'] = date("Y-m-d H:i:s");
        }
		*/
        //update curriculum data in curriculums table
        $update = $this->db->update($this->helpSub, $data, array('hsub_id' => $id));
        //return the status
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('tb_help_sub', array('hsub_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function getRows($id,$params=array()){
        if(count($params)>0){
            $arr = implode(",", $params);
            $this->db->select($arr);
        }else{
            $this->db->select('*');    
        }
        $this->db->from($this->helpSub);
        $this->db->where("hsub_id",$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function gethelpMain($id='',$params=array()){
        if(count($params)>0){
            $implode = implode(",", $params);
            $this->db->select($implode);
        }else{
            $this->db->select('*');    
        }
        $this->db->from($this->help);
        if(!empty($id)){
            $this->db->where('help_id',$id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}