<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curriculum extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

		$this->curriculum = 'curriculum';
        //$this->lesson = 'lesson';
        $this->tb_photos = 'tb_photos';
    }
    
    /*
     * Get curriculum data
     */
     
     public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->curriculum);
        
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        
        return $result;
	 }

    /*
     * Insert curriculum data
     */

    public function insert($data) {
        $insert = $this->db->insert($this->curriculum, $data);

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
        $update = $this->db->update($this->curriculum, $data, array('curriculum_id' => $id));
        //return the status
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('curriculum', array('curriculum_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function getRows($class,$day,$lession = '',$id=''){
        $class = urldecode($class);
        $this->db->select('*');
        $this->db->from($this->curriculum);
        $this->db->where('curriculum_class',$class);
        $this->db->where('curriculum_day',$day);
        if(!empty($lession)){
            $this->db->where('curriculum_lesson',$lession);
        }
        if(!empty($id)){
            $this->db->where('curriculum_id',$id);   
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getRecords($id,$params = array()){
        if(count($params)>0){
            $cols = implode(",", $params);
            $this->db->select($cols);
        }else{
            $this->db->select('*');
        }
        $this->db->from($this->curriculum);
        $this->db->where('curriculum_id',$id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function countClassWise($class){
        $this->db->select('curriculum_day');
        $this->db->from($this->curriculum);
        $this->db->where('curriculum_class',$class);
        $this->db->group_by('curriculum_day');
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    public function insertPhoto($data){
        $insert = $this->db->insert($this->tb_photos, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    public function removePhoto($id){
        $delete = $this->db->delete('tb_photos', array('image_id' => $id));
        return $delete ? $id : false;
    }

    public function getPhotos(){
        $this->db->select('*');
        $this->db->from($this->tb_photos);
        $this->db->order_by('image_id','desc');
        $this->db->limit(5,0);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getCurriculumDays($class){
        $this->db->select('curriculum_day');
        $this->db->from($this->curriculum);
        $this->db->where('curriculum_class',$class);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function deleteCurriculumday($class,$day){
        $delete = $this->db->delete('curriculum',array('curriculum_class'=>$class,'curriculum_day'=>$day));
        return $delete ? true : false;
    }
}