<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_syllabus extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('curriculum');
        $this->load->model('lesson');
        $this->load->model('tb_class');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form','html','file'));
        $this->load->model('bookcall');
        $this->load->model('Help');
        $this->load->model('Syllabus');
    }
    
    public function index() {
         $data = array();
        //$hType = getData("tb_help",array('title','help_id'),"help_id",$helpId);
        $data['page_name'] = 'Syllabus';
        $data['scriptname'] = 'syllabus.js';
        $data['classList'] = $this->tb_class->getAllRecords(); 
        // $data['helpid'] = $helpId;
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Syllabus List</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Syllabus/syllabuslist', $data);
        }
    }

    public function loadList(){
        $data['syllabuslist'] = $this->Syllabus->SearchSyllabus($_POST['class']);
        $data['classList'] = $this->tb_class->getAllRecords(); 
        $data['fclass'] = $_POST['class'];
        $this->load->view('Syllabus/loadlist',$data);
    }


    public function create(){
         $data = array();
        //$hType = getData("tb_help",array('title','help_id'),"help_id",$helpId);
        $data['page_name'] = 'Create Syllabus';
        // $data['helpId'] = $helpId;
        $data['classList'] = $this->tb_class->getAllRecords(); 
        $data['scriptname'] = 'syllabus.js';
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_syllabus/index">Syllabus List</a></li>
                                            <li class="breadcrumb-item active">Create Syllabus</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Syllabus/create', $data);
        }
    }

    public function addSyllabus(){
        unset($_POST['descr']);
       
        $check = getData('tb_syllabus',array('s_for'),'s_for',$_POST['s_for']);     

        if(count($check)>0){
            $arr = array("status"=>false,"data"=>"","message"=>"Syllabus Already Added For This curriculum");
        }else{
            $_POST['created_at'] = date("Y-m-d h:i:s");
            $_POST['updated_at'] = date("Y-m-d h:i:s");
            $insert = $this->Syllabus->insert($_POST); 
            if($insert>0){
                $arr = array("status"=>true,"data"=>"","message"=>"Successfully Saved");
            }else{
                $arr = array("status"=>false,"data"=>"","message"=>"Failed To Save");
            }    
        }

        
       
        echo json_encode($arr);
    }

    public function edit($id){
        $data = array();
        $data['page_name'] = 'Edit Syllabus';
        $data['scriptname'] = 'syllabus.js';
        $data['classList'] = $this->tb_class->getAllRecords(); 
        $data['syllabusData'] = $this->Syllabus->getRows($id);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                             <li class="breadcrumb-item"><a href="'.base_url().'Ct_syllabus/index">Syllabus List</a></li>
                                            <li class="breadcrumb-item active">Edit Syllabus</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Syllabus/edit', $data);
        }
    }

    public function updateSyllabus(){
        unset($_POST['descr']);
        
        $array = array("s_for"=>$_POST['s_for'],"description"=>$_POST['description'],"updated_at"=>date("Y-m-d h:i:s"));
        $insert = $this->Syllabus->update($array,$_POST['s_id']); 
        if($insert>0){
            $arr = array("status"=>true,"data"=>"","message"=>"Successfully Update");
        }else{
            $arr = array("status"=>false,"data"=>"","message"=>"Failed To Update");
        }
        
        echo json_encode($arr);
    }

    public function removeSyllabus(){
        $delete = $this->Syllabus->delete($_POST['id']);
        if($delete>0){
            echo "1";
        }else{
            echo "2";
        }
    
    }
       
}