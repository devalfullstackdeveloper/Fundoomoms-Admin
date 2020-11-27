<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lesson extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

		$this->lesson = 'lesson';
        //$this->lesson = 'lesson';
    }
    
    /*
     * Get lesson data
     */
     
     public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->lesson);
        
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        
        return $result;
	 }

     /*
     * Get lesson data by id
     */

     public function getRows($id) {
        $this->db->select('*');
        $this->db->from($this->lesson);
        $this->db->where('lesson_id', $id);
        
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        
        return $result;
     }

     /*
     * Get lesson data by id
     */

     public function getLessonByClass($curriculum_class) {
        $this->db->select('*');
        $this->db->from($this->lesson);
        $this->db->where('lesson_class', urldecode($curriculum_class));
        
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        
        return $result;
     }

     
    /*
     * Insert lesson data
     */

    public function insert($data) {
        $insert = $this->db->insert($this->lesson, $data);

        //return the status
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * Update lesson data
     */

    public function update($data, $id) {
        
        //update lesson data in lessons table
        $update = $this->db->update($this->lesson, $data, array('lesson_id' => $id));
        //return the status
        return $update ? true : false;
    }

    /*
     * Delete lesson data
     */

    public function delete($id) {

        $delete = $this->db->delete('lesson', array('lesson_id' => $id));
        //return the status
        return $delete ? true : false;
    }
}