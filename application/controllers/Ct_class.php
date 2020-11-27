<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_class extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('curriculum');
        $this->load->model('lesson');
        $this->load->model('tb_class');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form'));
    }
        
    public function index(){
         $data = array();
        $data['page_name'] = 'Classes List';
        $data['scriptname'] = 'classes.js';
        
        $data['classesList'] = $this->tb_class->getAllRecords();
        $activeMenu = $this->user->getActiveMenu('Curriculum', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;

        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Classes</li>
                                            
                                        </ol>';

        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Classes/classesList', $data);
        }
    }

    public function create(){
        $data = array();
        $data['page_name'] = 'Add Classes';
        $data['scriptname'] = "classes.js";
        $data['packageList'] = getMultiWhere('tb_package',array(),array(),'');
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
            $data = array("title"=>$_POST['classname'],"child_age"=>$_POST['child_age'],"c_days"=>$_POST['curriculum_days'],"price"=>$_POST['price'],"created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"),"validity"=>$_POST['validity'],"free_days"=>$_POST['free_days']);
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
        $data['packageList'] = getMultiWhere('tb_package',array(),array(),'');
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
            $arr1 = array();
            if(count($_POST['packages'])>0){
                foreach ($_POST['packages'] as $key => $value) {
                    array_push($arr1, $value);
                }
            }
            $package['package'] = $arr1;

            $data = array("title"=>$_POST['classname'],"child_age"=>$_POST['child_age'],"c_days"=>$_POST['curriculum_days'],"price"=>$_POST['price'],"updated_at"=>date("Y-m-d h:i:s"),"package"=>json_encode($package),"validity"=>$_POST['validity'],"free_days"=>$_POST['free_days']);
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
}   