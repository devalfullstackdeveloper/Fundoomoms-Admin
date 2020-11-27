<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tb_class extends CI_Model {    

	public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->tb_class = 'tb_class';
    }


    /**
    *
    **/

    public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->tb_class);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
	 }

	  public function insert($data) {
        $insert = $this->db->insert($this->tb_class, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * 
     */

    public function update($data, $id) {
        $update = $this->db->update($this->tb_class, $data, array('class_id' => $id));
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('tb_class', array('class_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function getRows($id){
    	$this->db->select('*');
    	$this->db->from($this->tb_class);
    	$this->db->where('class_id',$id);
    	$query = $this->db->get();
    	$result = $query->row_array();
    	return $result;
    }
}

