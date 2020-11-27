<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class package extends CI_Model {    

	public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->tb_class = 'tb_class';
        $this->tb_package = 'tb_package';
    }


    /**
    *
    **/

    public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->tb_package);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
	 }

	  public function insert($data) {
        $insert = $this->db->insert($this->tb_package, $data);
        return $insert ? $this->db->insert_id() : false;
    }

    /*
     * 
     */

    public function update($data, $id) {
        $update = $this->db->update($this->tb_package, $data, array('package_id' => $id));
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('tb_package', array('package_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function getRows($id){
    	$this->db->select('*');
    	$this->db->from($this->tb_package);
    	$this->db->where('package_id',$id);
    	$query = $this->db->get();
    	$result = $query->row_array();
    	return $result;
    }

    public function CheckExist($id="",$params = array()){
        // die(print_r($params));
        $this->db->select('package_id');
        $this->db->from($this->tb_package);
        $this->db->where('ptitle',$params['ptitle']);
        $this->db->where('type',$params['type']);
        $this->db->where('days',$params['days']);
        if($id!=''){
            $where1 = "package_id != ".$id;
            $this->db->where($where1);
        }
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }
}

