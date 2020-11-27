<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_dealer extends CI_Controller {

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
        $this->load->model('Dealer');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $data = array();
            $data['page_name'] = 'Dealers Centers';
            $data['serviceCenter'] = $this->Dealer->serviceCenter();
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">Dashboard</li>
                                            <li class="breadcrumb-item active">Dealers</li>
                                        </ol>';
            $activeMenu = $this->user->getActiveMenu('Dealer', 'main_menu');
            $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
            $data['active_menu'] = $activeMenu;
            $data['role_id'] = $_SESSION['LoginUserData']['role'];
            $data['permission'] = $rolePermission;
            
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Dealer/view', $data);
            }
        }
    }

    public function serviceView($id) {
        $data = array();
        $data['page_name'] = 'Dealer Centers';
        $data['serviceCenter'] = $this->Dealer->serviceCenter($id);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Welcome to York Transport Equipment (Asia) Pte Ltd.</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Dealer/dealerview', $data);
        }
    }

    public function create() {
        $data = array();
        $data['page_name'] = 'Create Dealer ';
        $data['state'] = $this->user->states();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Dealer </li>
                                            <li class="breadcrumb-item active">Create Dealer</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Dealer/create', $data);
        }
    }

    public function addService(){
        $createdBy = $_SESSION['loginId'];
        $incId = $this->Dealer->GetLastIncr();
        $prefix = 'DEAL';
        if(count($incId)>0){
            $inc = ($incId['inc_id']+1);
            $ref_id = $prefix.sprintf('%03d',$inc);
//            if($inc<=9){
//                $ref_id = "YDL0000".$inc;    
//            }else if($inc==10){
//                $ref_id = "YDL000".$inc;    
//            }else if($inc<=99){
//                $ref_id = "YDL000".$inc;    
//            }else if($inc==100){
//                $ref_id = "YDL00".$inc;    
//            }else if($inc<=999){
//                $ref_id = "YDL00".$inc;    
//            }else if($inc==1000){
//                $ref_id = "YDL0".$inc;    
//            }else if($inc<=9999){
//                $ref_id = "YDL0".$inc;    
//            }else if($inc==10000){
//                $ref_id = "YDL".$inc;    
//            }else{
//                $ref_id = "YDL".$inc;    
//            }
        }else{
            $inc = 1;
            $ref_id = $prefix."001";
        }
        //echo $ref_id;

        $data = array("dl_reference"=>$ref_id,"dl_name"=>$_POST['sc_name'],"dl_contact"=>$_POST['sc_contact'],
                "dl_email"=>$_POST['email'],"dl_location"=>$_POST['sc_location'],"dl_state"=>$_POST['state'],"dl_city"=>$_POST['city'],
                "dl_lat"=>$_POST['latitude'],"dl_long"=>$_POST['langitude'],"dl_created_date"=>date("Y-m-d h:i:s"),"inc_id"=>$inc,"dl_open_time"=>$_POST['open_time'],
                "dl_close_time"=>$_POST['close_time'],"dl_created_by"=>$createdBy);
         $insert = $this->Dealer->insert($data);
        if ($insert) {
            $this->session->set_flashdata('success', 'Dealer Created Successfully.');
            header("Location:" . base_url() . "Ct_dealer/index");
        } else {
            $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
            header("Location:" . base_url() . "Ct_dealer/create");
        }
    }


    public function editService($id=""){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = array("dl_name"=>$_POST['sc_name'],"dl_contact"=>$_POST['sc_contact'],
                "dl_email"=>$_POST['email'],"dl_location"=>$_POST['sc_location'],"dl_state"=>$_POST['state'],"dl_city"=>$_POST['city'],
                "dl_lat"=>$_POST['latitude'],"dl_long"=>$_POST['langitude'],"dl_created_date"=>date("Y-m-d h:i:s"),"dl_open_time"=>$_POST['open_time'],
                "dl_close_time"=>$_POST['close_time']);

             $insert = $this->Dealer->update($data, $_POST['id']);
            if ($insert) {
                $this->session->set_flashdata('success', 'Dealer Updated Successfully.');
                header("Location:" . base_url() . "Ct_dealer/index");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_dealer/edit");
            }

        }else{
            $param = array("dl_id" => $id);
            // print_r($param);
            $data = array();
            $userData = $this->Dealer->getRows($param);
            // print_r($userData);
            $data['state'] = $this->user->states();
            $data['page_name'] = 'Edit Dealer';
            $data['userData'] = $userData;

            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Dealers</li>
                                            <li class="breadcrumb-item active">Edit Dealer</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Dealer/edit', $data);
            }
        }
    }

    public function deleteService(){
        $id = $_POST['id'];
        $return = $this->Dealer->delete($id);
        echo $return;
    }

}