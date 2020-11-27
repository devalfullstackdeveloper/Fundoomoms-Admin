<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class bookcall extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

		$this->curriculum = 'curriculum';
        //$this->lesson = 'lesson';
        $this->user = "user_register";
        $this->book = "book_call";
    }
    
    /*
     * Get curriculum data
     */
     
     public	function getAllRecords() {
	 	$this->db->select('*');
        $this->db->from($this->book);
        $this->db->where('ref_id','-1');
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        return $result;
	 }

    /*
     * Insert curriculum data
     */

    public function insert($data) {
        $insert = $this->db->insert($this->book, $data);

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
        $update = $this->db->update($this->book, $data, array('book_id' => $id));
        //return the status
        return $update ? $id : false;
    }

    /*
     * Delete curriculum data
     */

    public function delete($id) {
        
        $delete = $this->db->delete('book', array('book_id' => $id));
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
        $this->db->from($this->book);
        $this->db->where("book_id",$id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getLastIncr(){
        $this->db->select('max(incr)');
        $this->db->from($this->book);
        $this->db->order_by("book_id","desc");
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getLastStatus($bookId){
        $this->db->select('current_status');
        $this->db->from($this->book);
        $this->db->where('book_id',$bookId);
        $this->db->order_by("book_id","desc");
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getSearchRecords($start,$end,$class,$status){
        $start = date("Y-m-d",strtotime($start));
        $end = date("Y-m-d",strtotime($end));    
        $query = "SELECT b.* from book_call as b join user_register as u on b.user_id=u.id";

        $query .=" WHERE b.created_at BETWEEN '".$start."' and '".$end."'";
        if($class=="all"){
        }else{
            $query .=" and u.class='".$class."'";
        }
        if($status=="all"){
        }else{
            $query .=" and b.current_status='".$status."'";
        }

        $query .=" order by book_id desc";
        $exe = $this->db->query($query);
        $result = $exe->result_array();
        return $result;

        // $this->db->select('*');
        // $this->db->from($this->book);
        // $this->db->where("MONTH(created_at)",$month);
        // if($class=="all"){
        // }else{
        //    $this->db->where("user_id",$class);
        // }
        // if($status=="all"){
        // }else{
        //     $this->db->where_in('book_id',$status);
        // }
        // // $this->db->where('ref_id','-1');
        // // $this->db->order_by('current_status','asc');
        // $query = $this->db->get();
        // $result = $query->result_array();
        // // die($this->db->last_query());
        // // echo $this->db->last_query();
        // return $result;
    }

    public function getUserClass($class){
        $this->db->select('id');
        $this->db->from('user_register');
        $this->db->where('class',$class);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function getbookstatuswise($status){
        $this->db->select("book_id");
        $this->db->from($this->book);
        $this->db->where("current_status",$status);
        $query = $this->db->get();
        $result1 = $query->result_array();
        $ids = "";
        foreach ($result1 as $key => $value) {
            $ids .=$value['book_id'].",";    
        }
        $ids = explode(",", rtrim($ids,","));
        // die();
        return $ids;
    }

     public function getrequestUser($user_id){
        $this->db->select("*");
        $this->db->from($this->book);
        $this->db->where("user_id",$user_id);
        $this->db->order_by('book_id','desc');
        $query = $this->db->get();
        $result1 = $query->result_array();
        return $result1;
    }

    public function viewRequest(){
        $update = $this->db->update($this->book, array('is_view'=>1), array('is_view' => 0));
        return $update ? $id : false;                
    }

}