<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class API_curriculum extends REST_Controller {

    public function __construct() {
        parent::__construct();

        // Load the user model
        $this->load->model('user');
        $this->load->model('curriculum');
    }
    
    public function index_post(){
        $allRecords = $this->curriculum->getAllRecords();
        if(isset($allRecords) && $allRecords != "" && count($allRecords) > 0){
            $this->response(['status' => TRUE,'data'=>$allRecords,'message' => ''], REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => FALSE,'data'=>NULL,'message' => 'No Record Found.'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
?>

