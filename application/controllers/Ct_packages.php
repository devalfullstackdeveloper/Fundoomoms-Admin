<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_packages extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('tb_class');
        $this->load->model('package');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form'));
    }
        
    public function index(){
         $data = array();
        $data['page_name'] = 'Package List';
        $data['scriptname'] = 'package.js';
        
        $data['packageList'] = $this->package->getAllRecords();
        $activeMenu = $this->user->getActiveMenu('Curriculum', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;

        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Package List</li>
                                            
                                        </ol>';

        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Package/packageList', $data);
        }
    }

    public function create(){
        $data = array();
        $data['page_name'] = 'Add Package';
        $data['scriptname'] = "package.js";
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_package/index">Package</a></li>
                                            <li class="breadcrumb-item active">Create Package</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Package/create', $data);
        }
    }

    public function addpackage(){
        $for=array(); $cnt=0;

        foreach ($_POST as $key => $value) {
            if(empty($value)){
                if($key=="pdays"){}else{
                    $arr = array("for"=>$value,"message"=>"Please Enter ".$key);
                    array_push($for,$arr);
                    $cnt++;    
                }
            }
        }

         if(empty($_POST['pdays'])){
                if($_POST['ptype']=="free"){
                    $arr = array("for"=>"pdays","message"=>"Please Enter package Days");
                    array_push($for,$arr);
                    $cnt++;  
                }
            }

        // die(print_r($for));

        if($cnt==0){

            $data = array("ptitle"=>$_POST['ptitle'],"type"=>$_POST['ptype'],"days"=>$_POST['pdays'],"created_at"=>date("Y-m-d h:i:s"),"updated_at"=>date("Y-m-d h:i:s"));

            $checkExist = $this->package->CheckExist("",$data);
            if($checkExist>0){
                $arr = array("status"=>true,"data"=>"","message"=>"Package Already Created For Inputed data");
            }else{
                $insert = $this->package->insert($data);
                if($insert>0){
                    $arr = array("status"=>true,"data"=>"","message"=>"Package Created Successfully");
                }else{
                    $arr = array("status"=>true,"data"=>"","message"=>"Failed To Create Package");
                }    
            }
            
        }else{
            $arr = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }
        echo json_encode($arr);
    }

    public function edit($id){
        $data = array();
        $data['page_name'] = 'Edit Package';
        $data['scriptname'] = 'package.js';
        $data['packageData'] = $this->package->getRows($id);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_package/index">Package</a></li>
                                            <li class="breadcrumb-item active">Edit Package</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Package/edit', $data);
        }
    }

    public function updatepackage(){
        $for=array(); $cnt=0;
        $id = $this->input->post('packageid');
        foreach ($_POST as $key => $value) {
            if(empty($value)){
                if($key=="pdays"){}else{
                    $arr = array("for"=>$value,"message"=>"Please Enter ".$key);
                    array_push($for,$arr);
                    $cnt++;    
                }
            }
        }

         if(empty($_POST['pdays'])){
                if($_POST['ptype']=="free"){
                    $arr = array("for"=>"pdays","message"=>"Please Enter package Days");
                    array_push($for,$arr);
                    $cnt++;  
                }
         }

        if($cnt==0){
            
            $data = array("ptitle"=>$_POST['ptitle'],"type"=>$_POST['ptype'],"days"=>$_POST['pdays'],"updated_at"=>date("Y-m-d h:i:s"));
            $checkExist = $this->package->CheckExist($id,$data);
            if($checkExist>0){
                $arr = array("status"=>true,"data"=>"","message"=>"Package Already Created For Inputed data");    
            }else{
                $insert = $this->package->update($data,$id);
                if($insert>0){
                    $arr = array("status"=>true,"data"=>"","message"=>"Package Updated Successfully");
                }else{
                    $arr = array("status"=>true,"data"=>"","message"=>"Failed To Create Package");
                }
            }
        }else{
            $arr = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }
        echo json_encode($arr);
    }

    public function removePackage(){
        $id = $this->input->post('id');
        $delete = $this->package->delete($id);
        if($delete){
            $arr = array("status"=>true,"data"=>"","message"=>"Successfully Removed");
        }else{
            $arr = array("status"=>true,"data"=>"","message"=>"Failed To Removed");
        }
        echo json_encode($arr);
    }
}   