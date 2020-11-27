<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_customer extends CI_Controller {

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
        $this->load->model('Customer');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $data = array();
            $data['page_name'] = 'Customer';
            $data['customerlist'] = $this->Customer->customerList();
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Welcome to York Transport Equipment (Asia) Pte Ltd.</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Customer/view', $data);
            }
        }
    }

    // public function customerView($id) {
    //     $data = array();
    //     $data['page_name'] = 'Customer Details';
    //     $data['serviceCenter'] = $this->Customer->serviceCenter($id);
    //     $data['breadCrumb'] = '<ol class="breadcrumb m-0">
    //                                         <li class="breadcrumb-item active">Welcome to York Transport Equipment (Asia) Pte Ltd.</li>
    //                                     </ol>';
    //     if (!isset($_SESSION['username'])) {
    //         $this->load->view('login');
    //     } else {
    //         $this->load->view('Dealer/dealerview', $data);
    //     }
    // }

    public function create() {
        $data = array();
        $data['page_name'] = 'Create Customer ';
        $data['cities'] = $this->user->cities('0');
        $data['state'] = $this->user->states();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Customer </li>
                                            <li class="breadcrumb-item active">Create Customer</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Customer/create', $data);
        }
    }

    public function addCustomer(){

        $checkEmail = $this->Customer->checkEmail($_POST['email']);
        $ckMobile = $this->Customer->CheckMobile($_POST['contact']);
        $ckAltMobile = $this->Customer->CheckMobile($_POST['alt_contact']);
        if(count($checkEmail)>0){
            $this->session->set_flashdata('error', 'Email Address Exist!');
            $this->session->set_flashdata('custdata',$_POST);
            header("Location:" . base_url() . "Ct_customer/create");
            // $this->load->view("Customer/create",array("data"=>$_POST));
        }else if(count($ckMobile)>0){
            $this->session->set_flashdata('error', 'Contact Number Exist!');
             $this->session->set_flashdata('custdata',$_POST);
            header("Location:" . base_url() . "Ct_customer/create");        
        }else if(count($ckAltMobile)>0){
            $this->session->set_flashdata('error', 'Alternat Contact Number Exist!');
             $this->session->set_flashdata('custdata',$_POST);
            header("Location:" . base_url() . "Ct_customer/create");            
        }else{

            if(empty($_POST['alt_contact'])){
                $alt_contact = NULL;
            }else{
                $alt_contact = $_POST['alt_contact'];
            }

            if(empty($_POST['email'])){
                $email = NULL;
            }else{
                $email = $_POST['email'];
            }

            if(isset($_POST['gender'])){
                $gender = $_POST['gender'];
            }else{
                $gender = "";
            }

            $data = array("cust_name"=>$_POST['cust_name'],"gender"=>$gender,"email"=>$email,"contact"=>$_POST['contact'],
                "alt_contact"=>$alt_contact,"address"=>$_POST['address'],"city"=>$_POST['city'],"state"=>$_POST['state'],
                "zipcode"=>$_POST['zipcode'],"country"=>$_POST['country'],"created_by"=>$_SESSION['username'],"added_on"=>date("Y-m-d h:i:s"));
            $insert = $this->Customer->insert($data);
            if ($insert) {
                $this->session->set_flashdata('success', 'Customer Created Successfully.');
                header("Location:" . base_url() . "Ct_customer/index");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_customer/create");
            }
        }


        
    }


    public function editCustomer($id=""){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

             $checkEmail = $this->Customer->checkEmail($_POST['email'],$_POST['id']);
            $ckMobile = $this->Customer->CheckMobile($_POST['contact'],$_POST['id']);
            $ckAltMobile = $this->Customer->CheckMobile($_POST['alt_contact'],$_POST['id']);
            if(count($checkEmail)>0){
                $this->session->set_flashdata('error', 'Email Address Exist!');
                $this->session->set_flashdata('custdata',$_POST);
                header("Location:" . base_url() . "Ct_customer/editCustomer");
                // $this->load->view("Customer/create",array("data"=>$_POST));
            }else if(count($ckMobile)>0){
                $this->session->set_flashdata('error', 'Contact Number Exist!');
                 $this->session->set_flashdata('custdata',$_POST);
                header("Location:" . base_url() . "Ct_customer/editCustomer");        
            }else if(count($ckAltMobile)>0){
                $this->session->set_flashdata('error', 'Alternat Contact Number Exist!');
                 $this->session->set_flashdata('custdata',$_POST);
                header("Location:" . base_url() . "Ct_customer/editCustomer");            
            }else{

            if(empty($_POST['alt_contact'])){
                $alt_contact = NULL;
            }else{
                $alt_contact = $_POST['alt_contact'];
            }

            if(empty($_POST['email'])){
                $email = NULL;
            }else{
                $email = $_POST['email'];
            }

            if(isset($_POST['gender'])){
                $gender = $_POST['gender'];
            }else{
                $gender = "";
            }

            $data = array("cust_name"=>$_POST['cust_name'],"gender"=>$gender,"email"=>$email,"contact"=>$_POST['contact'],
                "alt_contact"=>$alt_contact,"address"=>$_POST['address'],"city"=>$_POST['city'],"state"=>$_POST['state'],
                "zipcode"=>$_POST['zipcode'],"country"=>$_POST['country'],"created_by"=>$_SESSION['username'],"modified_on"=>date("Y-m-d h:i:s"));

             $insert = $this->Customer->update($data, $_POST['id']);
            if ($insert) {
                $this->session->set_flashdata('success', 'Customer Updated Successfully.');
                header("Location:" . base_url() . "Ct_customer/index");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_customer/editCustomer");
            }
        }

        }else{
            $param = array("cust_id" => $id);
            // print_r($param);
            $data = array();
            $userData = $this->Customer->getRows($param);
            // print_r($userData);
            // $data['state'] = $this->user->states();
            $data['cities'] = $this->user->cities('0');
           $data['state'] = $this->user->states();
            $data['page_name'] = 'Edit Customer';
            $data['userData'] = $userData;
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Customer</li>
                                            <li class="breadcrumb-item active">Edit Customer</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Customer/edit', $data);
            }
        }
    }

    public function deleteCustomer(){
        $id = $_POST['id'];
        $return = $this->Customer->delete($id);
        echo $return;
    }

}