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
        echo '<pre>';
        print_r("1212");
        echo '</pre>';
        exit();
//        $allRecords = $this->curriculum->getAllRecords();
//        echo '<pre>';
//        print_r($allRecords);
//        echo '</pre>';
//        exit();
    }

}
?>

