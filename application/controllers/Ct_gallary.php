<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_gallary extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('curriculum');
        $this->load->model('lesson');
        $this->load->model('tb_class');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form'));
        $this->load->model('Gallary');
    }
        
    public function index(){
         $data = array();
        $data['page_name'] = 'Gallery List';
        $data['scriptname'] = 'gallary.js';
        
        $data['gallaryList'] = $this->Gallary->getAllRecords();
        $activeMenu = $this->user->getActiveMenu('Curriculum', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;

        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Gallary/gallarylist', $data);
        }
    }

    public function create(){
        $data = array();
        $data['page_name'] = 'Add Classes';
        $data['scriptname'] = "classes.js";
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_class/index">Classes</a></li>
                                            <li class="breadcrumb-item active">Create Classes</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Classes/create', $data);
        }
    }

    public function addclass(){
        $for=array(); $cnt=0;
        foreach ($_POST as $key => $value) {
            if(empty($value)){
                $arr = array("for"=>$value,"message"=>"Please Enter ".$key);
                array_push($for,$arr);
                $cnt++;
            }
        }

        if($cnt==0){
            $data = array("title"=>$_POST['classname'],"child_age"=>$_POST['child_age'],"c_days"=>$_POST['curriculum_days'],"created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"));
            $insert = $this->tb_class->insert($data);
            if($insert>0){
                $arr = array("status"=>true,"data"=>"","message"=>"Class Created Successfully");
            }else{
                $arr = array("status"=>true,"data"=>"","message"=>"Failed To Create Class");
            }
        }else{
            $arr = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }
        echo json_encode($arr);
    }

    public function edit($id){
        $data = array();
        $data['page_name'] = 'Edit Class';
        $data['scriptname'] = 'classes.js';
        $data['classData'] = $this->tb_class->getRows($id);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_class/index">Classes List</a></li>
                                            <li class="breadcrumb-item active">Edit Classes</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Classes/edit', $data);
        }
    }

    public function updateClass(){
        $for=array(); $cnt=0;
        $id = $this->input->post('classid');
        foreach ($_POST as $key => $value) {
            if(empty($value)){
                $arr = array("for"=>$value,"message"=>"Please Enter ".$key);
                array_push($for,$arr);
                $cnt++;
            }
        }

        if($cnt==0){

            $data = array("title"=>$_POST['classname'],"child_age"=>$_POST['child_age'],"c_days"=>$_POST['curriculum_days'],"created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"));
            $insert = $this->tb_class->update($data,$id);
            if($insert>0){
                $arr = array("status"=>true,"data"=>"","message"=>"Class Updated Successfully");
            }else{
                $arr = array("status"=>true,"data"=>"","message"=>"Failed To Create Class");
            }
        }else{
            $arr = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }
        echo json_encode($arr);
    }

    public function removeClass(){
        $id = $this->input->post('id');
        $delete = $this->tb_class->delete($id);
        if($delete){
            $arr = array("status"=>true,"data"=>"","message"=>"Successfully Removed");
        }else{
            $arr = array("status"=>true,"data"=>"","message"=>"Failed To Removed");
        }
        echo json_encode($arr);
    }

    public function RemoveAllImage(){
        $ids = $_POST['imageids'];
        $cnt=0;
        foreach ($ids as $key => $value) {
            $delete = $this->curriculum->removePhoto($value);
            if($delete){
                $cnt++;
            }
        }
        echo json_encode(array("count"=>$cnt));
    }
}   