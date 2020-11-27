<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gallary extends CI_Model {    

	public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->Gallary = 'tb_photos';
    }


    /**
    *
    **/

    public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->Gallary);
        $this->db->order_by('image_id','desc');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
	 }

	  public function insert($data) {
        $insert = $this->db->insert($this->Gallary, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * 
     */

    public function update($data, $id) {
        $update = $this->db->update($this->Gallary, $data, array('image_id' => $id));
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('Gallary', array('image_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function getRows($id){
    	$this->db->select('*');
    	$this->db->from($this->Gallary);
    	$this->db->where('image_id',$id);
    	$query = $this->db->get();
    	$result = $query->row_array();
    	return $result;
    }
}

