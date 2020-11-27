<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Syllabus extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

		$this->curriculum = 'curriculum';
        //$this->lesson = 'lesson';
        $this->user = "user_register";
        $this->book = "book_call";
        $this->help = "tb_help";
        // $this->syllabus = "tb_help_sub";
        $this->syllabus = "tb_syllabus";
    }
    
    /*
     * Get curriculum data
     */
     
     public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->syllabus);
        $this->db->order_by('sl_id','desc');
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        return $result;
	 }

    /*
     * Insert curriculum data
     */

    public function insert($data) {
        $insert = $this->db->insert($this->syllabus, $data);

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
        $update = $this->db->update($this->syllabus, $data, array('sl_id' => $id));
        //return the status
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('tb_syllabus', array('sl_id' => $id));
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
        $this->db->from($this->syllabus);
        $this->db->where("sl_id",$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function SearchSyllabus($class=''){
        $this->db->select('*');
        $this->db->from($this->syllabus);
        if($class!="all"){
            $this->db->where('s_for',$class);    
        }
        $this->db->order_by('sl_id','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}