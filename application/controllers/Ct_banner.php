<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_banner extends CI_Controller {

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
        // $this->load->helper('url', 'form');
        $this->load->library('form_validation');

        $this->load->model('user');
        $this->load->model('banners');
    }

    public function index() {
        $data = array();
        $data['page_name'] = 'Mobile Home Banner Images';
        $data['bannerList'] = $this->banners->mobileBannerList();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">Dashboard</li>
                                            <li class="breadcrumb-item active">Mobile Home Banner Images</li>
                                        </ol>';
        $activeMenu = $this->user->getActiveMenu('View Mobile Banner', 'sub_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;
        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Banners/view', $data);
        }
    }

    public function create() {
        $data = array();
        $data['page_name'] = 'Create Banners';
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Mobile Banner Image</li>
                                            <li class="breadcrumb-item active">Create Banners</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Banners/create', $data);
        }
    }

    public function addbanner(){

       $imageName = "";
       if ($_FILES["image"]["name"] != '') {
                $test = explode('.', $_FILES["image"]["name"]);
                $ext = end($test);
                $name = $_POST['bannerTitle']."_".rand(100, 999) . '.' . $ext;
                $path = 'uploads/banner/';
                $urlArr = explode("/", $_SERVER['REQUEST_URI']);
                $url = "/vehicleserviceapp/";
                $location =  $path . $name;
                list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
                // echo $location;
                // die();
                // if($width!=400 && $height!=300){
                //     $this->session->set_flashdata('error', 'Please Upload Image in 400x300 size');
                //     header("Location:" . base_url() . "Ct_banner/create");
                // }else{
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $location)){
                        // echo "uploaded";
                        $imageName.=$path . $name;
                    }else{
                        // echo "Not Upload";
                        $imageName.="";
                    }    
                // }

                // echo $imageName;
                // die();
                
        }

        $data = array("mb_title"=>$_POST['bannerTitle'],"mb_position"=>$_POST['sortorder'],
                "mb_content"=>$_POST['descr'],"mb_img"=>$imageName,"mb_status"=>"1",
                "mb_created_on"=>date("Y-m-d h:i:s"));

        $insert = $this->banners->insert($data);
            if ($insert) {
                $this->session->set_flashdata('success', 'Banner Created Successfully.');
                header("Location:" . base_url() . "Ct_banner/index");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_banner/create");
            }
        
    }

    public function editBanner($id=""){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imageName = "";

               if ($_FILES["image"]["name"] != '') {
                        $test = explode('.', $_FILES["image"]["name"]);
                        $ext = end($test);
                        $name = $_POST['bannerTitle']."_".rand(100, 999) . '.' . $ext;
                        $path = 'uploads/banner/';
                        $urlArr = explode("/", $_SERVER['REQUEST_URI']);
                        $url = "/vehicleserviceapp/";
                        $location =  $path . $name;
                        list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
                        if($width!=400 && height!=300){
                             $this->session->set_flashdata('error', 'Please Upload Image in 400x300 size');
                            header("Location:" . base_url() . "Ct_banner/create");
                        }else{
                            if(move_uploaded_file($_FILES["image"]["tmp_name"], $location)){
                                // echo "uploaded";
                                $imageName.=$path . $name;
                            }else{
                                // echo "Not Upload";
                                $imageName.="";
                            }    
                        }
                }
                $data = array("mb_title"=>$_POST['bannerTitle'],"mb_position"=>$_POST['sortorder'],
                        "mb_content"=>$_POST['descr'],"mb_status"=>"1","mb_modified_on"=>date("Y-m-d h:i:s"));
                if(empty($imageName)){
                }else{
                    $data["mb_img"] = $imageName;
                }
                
                // print_r($data);

            $update = $this->banners->update($data,$_POST['id']);
                if ($update) {
                    $this->session->set_flashdata('success', 'Banner Updated Successfully.');
                    header("Location:" . base_url() . "Ct_banner/index");
                } else {
                    $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                    header("Location:" . base_url() . "Ct_banner/create");
                }
        }else{
            $param = array("mb_id" => $id);
            $data = array();
            $userData = $this->banners->getRows($param);
            $data['page_name'] = 'Edit Mobile Banner';
            $data['userData'] = $userData;
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Mobile Banner Image</li>
                                            <li class="breadcrumb-item active">Edit Mobile Banner</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Banners/edit', $data);
            }
        }
    }

    public function deleteBanner() {
        $id = $_POST['id'];
        $return = $this->banners->delete($id);
        echo $return;
    }

    public function ViewBannerInMobile(){
        $data = array();
        $data['page_name'] = 'Mobile Banner Preview';
        $data['bannerList'] = $this->banners->mobileBannerList();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Mobile Preview</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Banners/preview', $data);
        }
    }

    public function PreviewBanner(){
        $data = array();
        $data['bannerList'] = $this->banners->mobileBannerListPreview();
        $this->load->view('Banners/loadpreview',$data);
    }

}