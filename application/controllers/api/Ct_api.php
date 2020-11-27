<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
     
class Ct_api extends REST_Controller {
    public function __construct() {
        parent::__construct();

        // Load the user model
        $this->load->model('user');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */

    public function index()
    {
       print_r('hiiii');
       die;
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
}
?>