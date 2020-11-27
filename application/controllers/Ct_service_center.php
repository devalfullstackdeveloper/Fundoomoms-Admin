<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_service_center extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('user');
        $this->load->model('ServiceCenter');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $data = array();
            $data['page_name'] = 'Service Centers';
            $data['serviceCenter'] = $this->ServiceCenter->serviceCenter();
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">Dashboard</li>
                                            <li class="breadcrumb-item active">Service Centers</li>
                                        </ol>';
            
            $activeMenu = $this->user->getActiveMenu('Service Center', 'main_menu');
            $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
            $data['active_menu'] = $activeMenu;
            $data['role_id'] = $_SESSION['LoginUserData']['role'];
            $data['permission'] = $rolePermission;
            
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Service_center/view', $data);
            }
        }
    }

    public function serviceView($id) {
        $data = array();
        $data['page_name'] = 'Service Centers';
        $data['serviceCenter'] = $this->ServiceCenter->serviceCenter($id);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Welcome to York Transport Equipment (Asia) Pte Ltd.</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Service_center/service_center_view', $data);
        }
    }

    public function create() {
        $data = array();
        $data['page_name'] = 'Create Service Center';
        $data['state'] = $this->user->states();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Service Center</li>
                                            <li class="breadcrumb-item active">Create Service Center</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Service_center/create', $data);
        }
    }

    public function addService(){
        $createdBy = $_SESSION['loginId'];
        $incId = $this->ServiceCenter->GetLastIncr();
        $prefix = 'SERCTR';
        if(count($incId)>0){
            $inc = ($incId['inc_id']+1);
            $ref_id = $prefix.sprintf('%03d',$inc);
//            if($inc<=9){
//                $ref_id = "YSC0000".$inc;    
//            }else if($inc==10){
//                $ref_id = "YSC000".$inc;    
//            }else if($inc<=99){
//                $ref_id = "YSC000".$inc;    
//            }else if($inc==100){
//                $ref_id = "YSC00".$inc;    
//            }else if($inc<=999){
//                $ref_id = "YSC00".$inc;    
//            }else if($inc==1000){
//                $ref_id = "YSC0".$inc;    
//            }else if($inc<=9999){
//                $ref_id = "YSC0".$inc;    
//            }else if($inc==10000){
//                $ref_id = "YSC".$inc;    
//            }else{
//                $ref_id = "YSC".$inc;    
//            }
        }else{
            $inc = 1;
            $ref_id = $prefix."001";
        }
        
        //echo $ref_id;

        $data = array("sc_ref"=>$ref_id,"sc_name"=>$_POST['sc_name'],"sc_contact"=>$_POST['sc_contact'],
                "sc_open_time"=>$_POST['sc_open_time'],"sc_close_time"=>$_POST['sc_close_time'],
                "sc_location"=>$_POST['sc_location'],"sc_state"=>$_POST['state'],"sc_city"=>$_POST['city'],
                "sc_lat"=>$_POST['latitude'],"sc_long"=>$_POST['langitude'],"created_date"=>date("Y-m-d h:i:s"),"inc_id"=>$inc,"sc_created_by"=>$createdBy);
         $insert = $this->ServiceCenter->insert($data);
        if ($insert) {
            $this->session->set_flashdata('success', 'Service Center Created Successfully.');
            header("Location:" . base_url() . "Ct_service_center/index");
        } else {
            $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
            header("Location:" . base_url() . "Ct_service_center/create");
        }
    }


    public function editService($id=""){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array("sc_name"=>$_POST['sc_name'],"sc_contact"=>$_POST['sc_contact'],
                "sc_open_time"=>$_POST['sc_open_time'],"sc_close_time"=>$_POST['sc_close_time'],
                "sc_location"=>$_POST['sc_location'],"sc_state"=>$_POST['state'],"sc_city"=>$_POST['city'],
                "sc_lat"=>$_POST['latitude'],"sc_long"=>$_POST['langitude'],"created_date"=>date("Y-m-d h:i:s"));
             $insert = $this->ServiceCenter->update($data, $_POST['id']);
            if ($insert) {
                $this->session->set_flashdata('success', 'Service Center Updated Successfully.');
                header("Location:" . base_url() . "Ct_service_center/index");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_service_center/edit");
            }

        }else{
            $param = array("sc_id" => $id);
            // print_r($param);
            $data = array();
            $userData = $this->ServiceCenter->getRows($param);
            // print_r($userData);
            $data['state'] = $this->user->states();
            $data['page_name'] = 'Edit Service Centr';
            $data['userData'] = $userData;

            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Service Center</li>
                                            <li class="breadcrumb-item active">Edit Service Center</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Service_center/edit', $data);
            }
        }
    }

    public function deleteService(){
        $id = $_POST['id'];
        $return = $this->ServiceCenter->delete($id);
        echo $return;
    }

}