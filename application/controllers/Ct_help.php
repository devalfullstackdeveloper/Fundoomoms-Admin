<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_help extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('curriculum');
        $this->load->model('lesson');
        $this->load->model('tb_class');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form','html','file'));
        $this->load->model('bookcall');
        $this->load->model('Help');
    }
    
    public function index() {
         $data = array();
        //$hType = getData("tb_help",array('title','help_id'),"help_id",$helpId);
        $data['page_name'] = 'Help (Knowledge Base)';
        $data['scriptname'] = 'help.js';
        // $data['helpList'] = getMultiWhere('tb_help_sub',array(''),array(''),'');
        $data['helpList'] = $this->Help->getAllRecords();
        // $data['helpid'] = $helpId;
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Help List</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Help/help_list', $data);
        }
    }

    public function loadHelpList(){
        if($_POST['type']=='all'){
            // $data['helpList'] = getMultiWhere('tb_help_sub',array(''),array(''),'');
            $data['helpList'] = $this->Help->getAllRecords('','');
        }else{
            // $data['helpList'] = getMultiWhere('tb_help_sub',array(''),array('helpid'=>$_POST['type']),'');
            $data['helpList'] = $this->Help->getAllRecords('',$_POST['type']);
        }
        
        $data['mainHelp'] = getMultiWhere('tb_help',array(''),array(''),'');
        $data['ftype'] = $_POST['type'];

        $this->load->view('Help/helplistload',$data);
    }


    public function create(){
         $data = array();
        //$hType = getData("tb_help",array('title','help_id'),"help_id",$helpId);
        $data['page_name'] = 'Create Knowledge Base';
        // $data['helpId'] = $helpId;
        $data['helpData'] = $this->Help->gethelpMain('',array());
        $data['scriptname'] = 'help.js';
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_help/index">Help List</a></li>
                                            <li class="breadcrumb-item active">Create </li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Help/createHelp', $data);
        }
    }

    public function addHelp(){
        unset($_POST['descr']);
        if($_POST['htype']=="1"){
            if(empty($_POST['help_descr'])){
                $arr = array("status"=>false,"data"=>$_POST['descr'],"message"=>"Please enter description");
            }else{
                $insert = $this->Help->insert($_POST); 
                if($insert>0){
                    $arr = array("status"=>true,"data"=>"","message"=>"Successfully Saved");
                }else{
                    $arr = array("status"=>false,"data"=>"","message"=>"Failed To Save");
                }    
            }
            
        }else{
            


            $videos = array();
            $count = count($_FILES['files']['name']);

            

            
                    for($i=0;$i<$count;$i++){
                         if(!empty($_FILES['files']['name'][$i])){
                              $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                              $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                              $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                              $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                              $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                                 
                              $config['upload_path'] = './uploads/videos/'; 
                              $config['allowed_types'] = 'mp4';
                              $config['max_size'] = '6144';
                              $config['file_name'] = "support_".date("Ymdhis").$_FILES['files']['type'][$i];

                                $this->load->library('upload');
                                $this->upload->initialize($config);

                                if($this->upload->do_upload('files')){
                                    $uploadData = $this->upload->data();
                                    
                                    // $ext = pathinfo($uploadData['file_name']);
                                    $filename = "uploads/videos/".$uploadData['file_name'];
                                    array_push($videos, $filename);
                                }

                         }
                    }

            if(count($videos)>0){        
                $videos = json_encode($videos);
                    $data = array("title"=>$_POST['title'],"htype"=>$_POST['htype'],"video_url"=>$videos,
                                "created_at"=>date("Y-m-d h:i:s"),"helpid"=>$_POST['helpid']);
                    $insert = $this->Help->insert($data);
                    if($insert>0){
                        $arr = array("status"=>true,"data"=>"","message"=>"Successfully Saved");
                    }else{
                        $arr = array("status"=>false,"data"=>"","message"=>"Failed To Save");
                    }
            }else{
                $arr = array("status"=>false,"data"=>"errup","message"=>"Please Add Some File");
            }
            
            

            // if ($this->upload->do_upload('video_url'))
            // {
            //     $uploadedImage = $this->upload->data(); 
            //     $ext = pathinfo($uploadedImage['file_name']);
            //     $_POST['video_url'] = str_replace("./", "", $config['upload_path']."".$config['file_name'].".".$ext['extension']);
            //     $insert = $this->Help->insert($_POST);
            //     if($insert>0){
            //         $arr = array("status"=>true,"data"=>"","message"=>"Successfully Saved");
            //     }else{
            //         $arr = array("status"=>false,"data"=>"","message"=>"Failed To Save");
            //     }
            // }else{
            //     $arr = array("status"=>false,"data"=>"","message"=>$this->upload->display_errors());
            // }
        }
        echo json_encode($arr);
    }

    public function edit($id){
        $data = array();
        $data['page_name'] = 'Edit Help';
        $data['scriptname'] = 'help.js';
        $data['helpmain'] = $this->Help->gethelpMain('',array());
        $data['helpData'] = $this->Help->getRows($id);
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_help/index">Help List</a></li>
                                            <li class="breadcrumb-item active">Edit Help</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Help/editHelp', $data);
        }
    }

    public function updateHelp(){
        unset($_POST['descr']);
        if($_POST['htype']=="1"){
            if(empty($_POST['help_descr'])){
                $arr = array("status"=>false,"data"=>"","message"=>"Please enter description");
            }else{
                $array = array("title"=>$_POST['title'],"htype"=>$_POST['htype'],"help_descr"=>$_POST['help_descr'],
                            "updated_at"=>date("Y-m-d h:i:s"),"helpid"=>$_POST['helpid']);
                $insert = $this->Help->update($array,$_POST['hsub_id']); 
                if($insert>0){
                    $arr = array("status"=>true,"data"=>"","message"=>"Successfully Update");
                }else{
                    $arr = array("status"=>false,"data"=>"","message"=>"Failed To Update");
                }
            }
        }else{
            // unset($_POST['descr']);
            $videos = array();
            $count = count($_FILES['files']['name']);

            if($count>0){
                for($i=0;$i<$count;$i++){
                     if(!empty($_FILES['files']['name'][$i])){
                          $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                          $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                          $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                          $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                             
                          $config['upload_path'] = './uploads/videos/'; 
                          $config['allowed_types'] = 'mp4';
                          $config['max_size'] = '6144';
                          $config['file_name'] = "support_".date("Ymdhis").$_FILES['files']['type'][$i];

                            $this->load->library('upload');
                            $this->upload->initialize($config);

                            if($this->upload->do_upload('file')){
                                $uploadData = $this->upload->data();
                                
                                // $ext = pathinfo($uploadData['file_name']);
                                $filename = "uploads/videos/".$uploadData['file_name'];
                                array_push($videos, $filename);
                            }

                     }
                }
                $prevVideo = getData('tb_help_sub',array('video_url'),'hsub_id',$_POST['hsub_id']);
                if(count($prevVideo)>0){
                    $extract = json_decode($prevVideo[0]['video_url']);
                    if(count($extract)>0){
                        foreach ($extract as $key => $value) {
                            array_push($videos, $value);
                        }
                    }
                }    

                $videos = json_encode($videos);
                $array = array("title"=>$_POST['title'],"htype"=>$_POST['htype'],"video_url"=>$videos,"updated_at"=>date("Y-m-d h:i:s"));
                $insert = $this->Help->update($array,$_POST['hsub_id']);
                if($insert>0){
                    $arr = array("status"=>true,"data"=>"","message"=>"Successfully Saved");
                }else{
                    $arr = array("status"=>false,"data"=>"","message"=>"Failed To Save");
                }
            }else{
                $array = array("title"=>$_POST['title'],"htype"=>$_POST['htype'],
                            "updated_at"=>date("Y-m-d h:i:s"));
                $insert = $this->Help->update($array,$_POST['hsub_id']); 
                if($insert>0){
                    $arr = array("status"=>true,"data"=>"","message"=>"Successfully Update");
                }else{
                    $arr = array("status"=>false,"data"=>"","message"=>"Failed To Update");
                } 
            }

        }
        echo json_encode($arr);
    }

    public function removeHelp(){
        $remove = $this->Help->delete($_POST['id']);
        if($remove>0){
            echo "1";
        }else{
            echo "2";
        }
    }
       
}