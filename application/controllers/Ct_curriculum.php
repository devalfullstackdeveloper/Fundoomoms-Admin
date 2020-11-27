<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_curriculum extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('curriculum');
        $this->load->model('lesson');
        $this->load->model('tb_class');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form','html'));
    }
    
    public function createCurriculum($curriculum_class = '',$curriculum_day ='') {
        $data = array();
        $data['page_name'] = 'Add Curriculum';
        $data['scriptname'] = 'curriculum.js';
        $data['curriculum_class'] = $curriculum_class;
        $data['curriculum_day'] = $curriculum_day;
        $data['lessons'] = $this->lesson->getLessonByClass($curriculum_class);
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_curriculum/viewCurriculum/">Curriculum</a></li>
                                            <li class="breadcrumb-item active">Create Curriculum</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/createCurriculum', $data);
        }
    }

    public function checkCurriculum() {
    	$sql="select * from curriculum where curriculum_class='".$_POST['child_class']."' AND curriculum_day='".$_POST['curriculumDay']."'";
        $query = $this->db->query($sql);
       	$curriculum = $query->result_array();
       	$result = array();
       	if(empty($curriculum)) {
       		//echo "Empty array";
            $data['curriculumDay'] = $_POST['curriculumDay'];
            $data['curriculum_class'] = $_POST['child_class'];
       		// $html = '';
	        // $html .= '<img class="img-fluid" src="'.base_url().'app-assets/images/Group 1122.png" /><div class="curriculum_buttons"><a href="'.base_url().'Ct_curriculum/createCurriculum/'.$_POST['child_class'].'/'.$_POST['curriculumDay'].'/" class="btn btn-light btn-sm">Add Curriculum</a>
         //        <a href="javascript:void(0);" class="btn btn-light btn-sm importBtn" cClass='.$_POST['child_class'].' cDay='.$_POST['curriculumDay'].'>Import Curriculum</a>
         //        <input type="file" id="importCur'.$_POST['child_class'].''.$_POST['curriculumDay'].'" style="display:none;">
         //        </div>';

	     //   $result['curriculum_html'] = $html;
	        // echo json_encode($result);
	        // echo $html;

            $this->load->view('Curriculum/addimport',$data);
       	} else {
            $cdata = $this->curriculum->getRows($_POST['child_class'],$_POST['curriculumDay']);
            $data['curriculumDay'] = $_POST['curriculumDay'];
            $data['curriculum_class'] = $_POST['child_class'];
            $data['lession'] = $cdata;
            // die(print_r($cdata));
            $this->load->view('Curriculum/datewisecur',$data);
       	}
    }

    public function createLesson($child_class = '') {
        $data = array();
        $data['page_name'] = 'Add Lesson';
         $data['classList'] = $this->tb_class->getAllRecords();
        $data['child_class'] = $child_class;
        $data['scriptname'] = "lesson.js";
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_curriculum/viewLesson/">Lesson</a></li>
                                            <li class="breadcrumb-item active">Create Lesson</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/createLesson', $data);
        }
    }

    public function addLesson(){

       $imageName = "";
       if ($_FILES["image"]["name"] != '') {

                $config['upload_path']          = './uploads/lesson/';
                $config['allowed_types']        = 'png|svg';
                $config['file_name']            = $_POST['lesson_title']."_".rand(100, 999);

                $this->load->library('upload');
                $this->upload->initialize($config);

                if(!$this->upload->do_upload('image')){
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    header("Location:" . base_url() . "Ct_curriculum/createLesson");
                }else{
                    $uploadedImage = $this->upload->data();
                    //$this->resizeImage($uploadedImage['file_name']);
                    $ext = pathinfo($uploadedImage['file_name']);
                    $imageName .="uploads/lesson/".$uploadedImage['file_name'];
                }

                // $test = explode('.', $_FILES["image"]["name"]);
                // $ext = end($test);
                // $name = $_POST['lesson_title']."_".rand(100, 999) . '.' . $ext;
                // $path = 'uploads/lesson/';
                // $urlArr = explode("/", $_SERVER['REQUEST_URI']);
                // $url = "/fundoomoms/";
                // $location =  $path . $name;
                // list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
                
                
                // if(move_uploaded_file($_FILES["image"]["tmp_name"], $location)){
                //         // echo "uploaded";
                //         $imageName.=$path . $name;
                // }else{
                //         // echo "Not Upload";
                //         $imageName.="";
                // }    
        }

        // die($imageName);
        
        $data = array(
        	"lesson_title" => $_POST['lesson_title'],
        	"lesson_class"=> $_POST['childClass'],
            "lesson_icon" => $imageName
        );
        
        $insert = $this->lesson->insert($data);
            if ($insert) {
                $this->session->set_flashdata('success', 'Lesson Created Successfully.');
                header("Location:" . base_url() . "Ct_curriculum/viewLesson");
            } else {
                $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                header("Location:" . base_url() . "Ct_curriculum/createLesson");
            }
        
    }

    

    public function editLesson($id=""){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                


               $imageName = "";
                if ($_FILES["image"]["name"] != '') {

                        $config['upload_path']          = './uploads/lesson/';
                        $config['allowed_types']        = 'png|svg';
                        $config['file_name']            = $_POST['lesson_title']."_".rand(100, 999);

                        $this->load->library('upload');
                        $this->upload->initialize($config);

                        if(!$this->upload->do_upload('image')){
                            $this->session->set_flashdata('error', $this->upload->display_errors());
                            header("Location:" . base_url() . "Ct_curriculum/editLesson/".$id);
                            // redirect(base_url()."Ct_curriculum/editLesson/".$id);
                        }else{
                            $uploadedImage = $this->upload->data();
                            //$this->resizeImage($uploadedImage['file_name']);
                            $ext = pathinfo($uploadedImage['file_name']);
                            $imageName .="uploads/lesson/".$uploadedImage['file_name'];
                        }

                        // $test = explode('.', $_FILES["image"]["name"]);
                        // $ext = end($test);
                        // $name = $_POST['lesson_title']."_".rand(100, 999) . '.' . $ext;
                        // $path = 'uploads/lesson/';
                        // $urlArr = explode("/", $_SERVER['REQUEST_URI']);
                        // $url = "/fundoomoms/";
                        // $location =  $path . $name;
                        // list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
                        
                        
                        // if(move_uploaded_file($_FILES["image"]["tmp_name"], $location)){
                        //         // echo "uploaded";
                        //         $imageName.=$path . $name;
                        // }else{
                        //         // echo "Not Upload";
                        //         $imageName.="";
                        // }    
                }

                $data = array(
		        	"lesson_title" => $_POST['lesson_title'],
		        	"lesson_class"=> $_POST['childClass']
		        );

		        if(empty($imageName)){
                }else{
                    $data["lesson_icon"] = $imageName;
                }
                
                // print_r($data);

                // die();

                $update = $this->lesson->update($data,$id);
                if ($update) {
                    $this->session->set_flashdata('success', 'Lesson Updated Successfully.');
                    header("Location:" . base_url() . "Ct_curriculum/viewLesson/".$_POST['childClass']);
                    

                } else {
                    $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
                    header("Location:" . base_url() . "Ct_curriculum/UpdateLesson");
                }
        }else{
        	//$param = array("lesson_id" => $id);
            $data = array();
	        $data['page_name'] = 'Edit Lesson';
            $data['classList'] = $this->tb_class->getAllRecords();
	        $lessonData = $this->lesson->getRows($id);
            $data['lessonData'] = $lessonData;
            $data['scriptname'] = "lesson.js";
	        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
	                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
	                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_curriculum/viewLesson/">Lesson</a></li>
	                                            <li class="breadcrumb-item active">Edit Lesson</li>
	                                        </ol>';
	        if (!isset($_SESSION['username'])) {
	            $this->load->view('login');
	        } else {
	            $this->load->view('Curriculum/updateLesson', $data);
	        }
        }
    }

    public function resizeImage($filename)
   {
    
      ini_set('memory_limit', '512M');
      $source_path = $_SERVER['DOCUMENT_ROOT'] . '/FundooMomsAdmin/uploads/lesson/' . $filename;
      $target_path = $_SERVER['DOCUMENT_ROOT'] . '/FundooMomsAdmin/uploads/lesson/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => FALSE,
          'create_thumb' => FALSE,
          'width' => 38,
          'height' => 38
      );

      $this->load->library('image_lib');
      $this->image_lib->initialize($config_manip);
      if (!$this->image_lib->resize()) {
         
      }else{
         $this->image_lib->clear();     
         
      }
   }

    public function deleteLesson() {

        $id = $_POST['id'];
        $return = $this->lesson->delete($id);

        echo $return;
    }
    
    public function viewCurriculum() {
        $data = array();
        $data['page_name'] = 'Curriculum';
        $data['scriptname'] = 'curriculum.js';
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['userList'] = $this->curriculum->getAllRecords();
        $activeMenu = $this->user->getActiveMenu('Curriculum', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;

        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Curriculum List</li>
                                        </ol>';

        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/viewCurriculum', $data);
        }
    }

    public function viewLesson($class='') {
        $data = array();
        $data['page_name'] = 'Lesson';
        $data['class'] = $class;
        $data['lessonList'] = $this->lesson->getAllRecords();
        $data['classList'] = $this->tb_class->getAllRecords();
        $activeMenu = $this->user->getActiveMenu('Lesson', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;
         $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Lesson List</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/viewLesson', $data);
        }
    }

    public function loadLesson(){
        $class = $_POST['class'];
        $data['lessonList'] = $this->lesson->getLessonByClass($class);
        $this->load->view('Curriculum/lessonload',$data);
    }

    public function saveCurriculum(){
        $cnt=0; $for=array(); 
        if(empty($this->input->post('childClass'))){
            $arr = array("for"=>"childClass","message"=>'Please Select Child Class');
            array_push($for,$arr);
            $cnt++;
        }
        if(empty($this->input->post('curriculum_day'))){
            $arr = array("for"=>"curriculum_day","message"=>'curriculum day is not set');
            array_push($for,$arr);
            $cnt++;
        }

        if(empty($this->input->post('lesson'))){
            $arr = array("for"=>"lesson","message"=>'Please Select lesson');
            array_push($for,$arr);
            $cnt++;
        }

        if(empty($this->input->post('curriculum_description'))){
            $arr = array("for"=>"curriculum_description","message"=>'Please Fill Lesson Description');
            array_push($for,$arr);
            $cnt++;
        }

        if($cnt==0){
            $description = html_entity_decode($this->input->post('curriculum_description'));
            $regex = '/https?\:\/\/[^\" \n]+/i';
            preg_match_all($regex, strip_tags($description), $matches);
            $s2 = array();
            $string1 = "";
            foreach ($matches[0] as $url) {
                $s1 = substr($url, 0, strlen($url));
                array_push($s2, $s1);
            }
            
            foreach ($s2 as $Ckey => $Cvalue) {

                if(strpos($Cvalue, "www.youtube.com") !== false){
                    
                    $string1 = "<br><br>";
                    $string1 .="<iframe width='290' height='215'";
                    $string1 .="src='".$Cvalue."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen>";
                    $string1 .="</iframe>";
                    $string1 .="<br><br>";
                   
                    
                    $dom = new DOMDocument;
                    @$dom->loadHTML($description);
                    $links = $dom->getElementsByTagName('iframe');
                    
                    foreach ($links as $link){
                        $link->setAttribute('width','290');
                        $link->setAttribute('height','215');
                    }

                    $description = $dom->saveHtml();

                    $description = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $description);

                    $description = str_replace("<html><body>", "", $description);
                    $description = str_replace("</html></body>", "", $description);

                    

                        $tag = array('iframe');
                        // $temp = "";
                          foreach ($tag as $tvalue) {
                           
                        }
                          

                }else{
                    $parts1 = explode("/", $Cvalue);
                    $parts1 = end($parts1);
                    $parts1 = explode(".", $parts1);
                    $parts1 = end($parts1);

                    if(trim($parts1)=="gif" || trim($parts1)=="jpg" || trim($parts1)=="jpeg" || trim($parts1)=="png"){
                        

                        $string1 ="<br><br>";
                        $string1 .="<a href='".trim($Cvalue)."'><img src='".trim($Cvalue)."' height='150' width='290' /></a>";
                        $string1 .="<br><br>";
                        $description = str_replace(trim($Cvalue), $string1, $description);
                    }

                    if(trim($parts1)=="mp4"){
                        $string1 = "<br><br>";
                        $string1 .="<video controls height='120' width='290'>";
                        $string1 .="<source src='".trim($Cvalue)."' type='video/".trim($parts1)."'>";
                        $string1 .="</video>";
                        $string1 .="<br><br>";
                        $description = str_replace(trim($Cvalue), $string1, $description);
                    }

                    if(trim($parts1)=="doc" || trim($parts1)=='docx'){
                        
                        $string1 = "<br><br>";
                        $string1="<a href='".trim($Cvalue)."'>View Document</a>";
                        $description = str_replace(trim($Cvalue), $string1, $description);
                    }

                      if(trim($parts1)=="pdf"){
                         $string1 .="<a href='".trim($Cvalue)."'>View Pdf</a>";
                         $description = str_replace(trim($Cvalue), $string1, $description);
                    }    

                    if(trim($parts1)=="ppt"){
                         $string1 .="<a href='".trim($Cvalue)."'>View PPT</a>";
                         $description = str_replace(trim($Cvalue), $string1, $description);
                    }
                    
                }
            }

            

            $data = array("curriculum_class"=>$this->input->post('childClass'),
                        "curriculum_day"=>$this->input->post('curriculum_day'),
                        "curriculum_lesson"=>$this->input->post('lesson'),
                        "curriculum_lesson_description"=>$description
                        );
            if($this->input->post('curriculum_id')){
                $data['updated_at'] = date("Y-m-d h:i:s");
                $insert = $this->curriculum->update($data,$this->input->post('curriculum_id'));
            }else{
                $data['created_at'] = date("Y-m-d h:i:s");
                $data['updated_at'] = date("Y-m-d h:i:s");
                $insert = $this->curriculum->insert($data);
            }
            
            if($insert>0){
                $cClass = $this->input->post('childClass');
                $cDay = $this->input->post('curriculum_day');
                if($this->input->post('curriculum_id')){
                    $arr1 = array("status"=>true,"data"=>$insert,"class"=>$cClass,"cDay"=>$cDay,"message"=>"Curriculum Updated Successfully");
                }else{
                    $arr1 = array("status"=>true,"data"=>$insert,"class"=>$cClass,"cDay"=>$cDay,"message"=>"Curriculum Created Successfully");    
                }
                
            }else{
                $arr1 = array("status"=>true,"data"=>$insert,"message"=>"Failed To Add Curriculum! Please try again");
            }
        }else{
            $arr1 = array("status"=>false,"data"=>$for[0]['for'],"message"=>$for[0]['message']);
        }

        echo json_encode($arr1);
    }

    public function aftercuriculum($id,$curriculum_class,$curriculum_day){
        $data = array();
        $data['page_name'] = 'Add Curriculum';
        $data['scriptname'] = 'curriculum.js';
        $data['curriculum_class'] = $curriculum_class;
        $data['child_age'] = getData('tb_class',array('child_age'),'class_id',$curriculum_class);
        $data['curriculum_day'] = $curriculum_day;
        $data['lessons'] = $this->lesson->getLessonByClass($curriculum_class);
        $data['curriculumData'] = $this->curriculum->getRows($curriculum_class,$curriculum_day);
        $this->load->helper('get_data_helper');
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_curriculum/viewCurriculum/">Curriculum</a></li>
                                            <li class="breadcrumb-item active">Edit Curriculum</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/viewaftercreate', $data);
        }
    }

    public function editCurriculumn($id,$curriculum_class,$curriculum_day){
        $data = array();
        $data['page_name'] = 'Edit Curriculum';
        $data['scriptname'] = 'curriculum.js';
        $data['curriculum_class'] = $curriculum_class;
        $data['curriculum_day'] = $curriculum_day;
        $data['lessons'] = $this->lesson->getLessonByClass($curriculum_class);

        $data['curriculumData'] = $this->curriculum->getRows($curriculum_class,$curriculum_day,'',$id);
        $data['classList'] = $this->tb_class->getAllRecords();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="'.base_url().'Ct_curriculum/viewCurriculum/">Curriculum</a></li>
                                            <li class="breadcrumb-item active">Edit Curriculum</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/editCurriculum', $data);
        }
    }

    public function loadProgressBar(){
        $class = $this->input->post('class');
        $getRecords = $this->curriculum->countClassWise($class);
        $days = getData('tb_class',array('c_days'),'class_id',$class);
        $data = array();
        $data['total_records'] = $getRecords;
        $data['classdays'] = $days[0]['c_days'];
        $this->load->view('Curriculum/curprogress',$data);
    }

    public function importCurriculum(){
        $path = 'uploads/Import/';

        require_once APPPATH . "third_party/PHPExcel/PHPExcel.php";

        $config['upload_path'] = $path;
        $config['allowed_types'] = 'xlsx|xls';
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('importFile')) {

            $error = array('error' => $this->upload->display_errors());
        } else {

            $data = array('upload_data' => $this->upload->data());
        }

              $cnt=0; 
             $existArr = array(); $classArr = array();
        if(empty($error)){
          if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];

        } else {
            $import_xls_file = 0;
        }

        $inputFileName = $path . $import_xls_file;
        try {


                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value) {
                      if($flag){
                        $flag =false;
                        continue;
                      } 

                      $value['D'] = str_replace("[img]", "", $value['D']);

                      
                      $changed = $value['D'];
                      

                          $regex = '/https?\:\/\/[^\" \n]+/i';
                          preg_match_all($regex, $changed, $matches);
                            //note below that we use $matches[0], this is because we have an array of arrays
                            $imageArr = array('gif','jpg','jpeg','png');
                            $videoArr = array('mp4');
                            $s2 = array();
                            $string1 = "";
                            foreach ($matches[0] as $url) {
                                $s1 = substr($url, 0, strlen($url));
                                // $s2 .= $s1;
                                array_push($s2, $s1);
                            }
                            foreach ($s2 as $Ckey => $Cvalue) {

                                if(strpos($Cvalue, "www.youtube.com") !== false){
                                    
                                    $string1 = "<br><br>";
                                    $string1 .="<iframe width='290' height='215'";
                                    $string1 .="src='".$Cvalue."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen>";
                                    $string1 .="</iframe>";
                                    $string1 .="<br><br>";
                                    // $string1 .=$Cvalue;
                                    
                                    $dom = new DOMDocument;
                                    @$dom->loadHTML($value['D']);
                                    $links = $dom->getElementsByTagName('iframe');
                                    
                                    foreach ($links as $link){
                                        $link->setAttribute('width','290');
                                        $link->setAttribute('height','215');
                                    }

                                    $value['D'] = $dom->saveHtml();

                                    $value['D'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $value['D']);

                                    $value['D'] = str_replace("<html><body>", "", $value['D']);
                                    $value['D'] = str_replace("</html></body>", "", $value['D']);

                                    // $value['D'] .= $string1;

                                        $tag = array('iframe');
                                        // $temp = "";
                                          foreach ($tag as $tvalue) {
                                           
                                        }
                                        // $value['D'] = implode(' ', array_unique(explode(' ', $value['D'])));
                                        // $value['D'] = $temp;

                                    // $value['D'] = str_replace($Cvalue, $string1, $value['D']);    

                                }else{
                                    $parts1 = explode("/", $Cvalue);
                                    $parts1 = end($parts1);
                                    $parts1 = explode(".", $parts1);
                                    $parts1 = end($parts1);
                                    
                                    if($parts1=="gif" || $parts1=="jpg" || $parts1=="jpeg" || $parts1=="png"){
                                        $string1 ="<br><br>";
                                        $string1 .="<a href=".$Cvalue."><img src=".$Cvalue." height='150' width='290' /></a>";
                                        $string1 .="<br><br>";
                                        $value['D'] = str_replace($Cvalue, $string1, $value['D']);
                                    }

                                    if($parts1=="mp4"){
                                        $string1 = "<br><br>";
                                        $string1 .="<video controls height='120' width='290'>";
                                        $string1 .="<source src=".$Cvalue." type='video/".$parts1."'>";
                                        $string1 .="</video>";
                                        $string1 .="<br><br>";
                                        $value['D'] = str_replace($Cvalue, $string1, $value['D']);
                                    }

                                    if($parts1=="doc" || $parts1=="docx"){
                                        $string1 = "<br><br>";
                                        $string1="<a href=".$Cvalue.">View Document</a>";
                                        $value['D'] = str_replace($Cvalue, $string1, $value['D']);
                                    }

                                      if($parts1=="pdf"){
                                         $string1 .="<a href=".$value.">View Pdf</a>";
                                         $value['D'] = str_replace($Cvalue, $string1, $value['D']);
                                    }    

                                    if($parts1=="ppt"){
                                         $string1 .="<a href=".$value.">View PPT</a>";
                                         $value['D'] = str_replace($Cvalue, $string1, $value['D']);
                                    }
                                    
                                }

                                 

                                // $changed =str_replace($Cvalue, "", $changed);
                                

                            }
                            // die($string1);
                            $changed .= $string1;

                                 $class = getData('tb_class',array('class_id'),'title',$value['A']);
                            
                            if(count($class)>0){
                                $classId = $class[0]['class_id'];
                            }else{
                                $classId = "";
                            }
                            $lesson = getData('lesson',array('lesson_id'),'lesson_title',$value['C']);
                            if(count($lesson)>0){
                                $lessonId = $lesson[0]['lesson_id'];
                            }else{
                                $lessonId = '';
                            }       
                          
                          $checkExist = $this->curriculum->getRows($classId,$value['B'],$lessonId);
                          
                          if(count($checkExist)>0){
                              // array_push($existArr, $checkExist[0]['curriculum_day']);
                              
                              $existArr[$value['A']] .= $value['B'].",";
                              $cnt++;   
                          }

                            // die($value['D']);

                            // echo $string;  
                      

                      $inserdata[$i]['curriculum_class'] = trim($value['A']);
                      $inserdata[$i]['curriculum_day'] = trim($value['B']);
                      $inserdata[$i]['curriculum_lesson'] = trim($value['C']);
                      $inserdata[$i]['curriculum_lesson_description'] = "<p style='font-size: 14px;
    font-family: montserrat;
    text-align: justify;
    line-height: 24px;'>".$value['D']."</p>";
                      $i++;
                      
                    }

                    // die(print_r($inserdata));              
                    foreach ($inserdata as $key => $value) {
                        // print_r($value['curriculum_class']);
                        $class = getData('tb_class',array('class_id'),'title',$value['curriculum_class']);
                        
                        if(count($class)>0){
                            $classId = $class[0]['class_id'];
                        }else{
                            $classId = "";
                        }
                        $lesson = getData('lesson',array('lesson_id'),'lesson_title',$value['curriculum_lesson']);
                        $lesson = getMultiWhere('lesson',array('lesson_id'),array('lesson_title'=>$value['curriculum_lesson'],'lesson_class'=>$classId));
                        if(count($lesson)>0){
                            $lessonId = $lesson[0]['lesson_id'];
                        }else{
                            $lessonId = '';
                        }

                        // echo $value['curriculum_lesson'].",";

                        $checkExist = $this->curriculum->getRows($classId,$value['curriculum_day'],$lessonId);
                        if(count($checkExist)>0){
                        }else{
                            $arr = array("curriculum_class"=>$classId,
                                "curriculum_day"=>$value['curriculum_day'],
                                "curriculum_lesson"=>$lessonId,
                                "curriculum_lesson_description"=>$value['curriculum_lesson_description']);    

                            $result = $this->curriculum->insert($arr);  
                            if($result>0){
                                $cnt++;
                            }     
                        }
                    }
                    // die();
                    // if($result){
                    //   echo "Imported successfully";
                    // }else{
                    //   echo "ERROR !";
                    // }             
      
        } catch (Exception $e) {
            // die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
            //                 . '": ' .$e->getMessage());
        }
    }
        unlink($data['upload_data']['full_path']);

        $Classes = "";
        $Days = "";
        if(count($existArr)>0){
            foreach ($existArr as $key => $value) {
                $trim = trim($value,",");
                $existArr[$key] = implode(",",array_unique(explode(",", $trim)));

            }
        }

        // print_r($existArr);

        if($cnt>0){
            // $existArr = implode(",", array_unique($existArr));
            $arr2 = array("status"=>true,"data"=>"","exist"=>json_encode($existArr),"message"=>"File Imported Successfully");
            // echo "1";   
        }else{
            $arr2 = array("status"=>true,"data"=>"","exist"=>'',"message"=>"File Imported Successfully");    
            // echo "2";
        }
        echo json_encode($arr2);

        }

    public function getUrls($string){
        $regex = '/https?\:\/\/[^\" \n]+/i';
          preg_match_all($regex, $string, $matches);
            //note below that we use $matches[0], this is because we have an array of arrays
            $imageArr = array('gif','jpg','jpeg','png');
            $videoArr = array('mp4');
            $s2 = array();
            $string1 = "";
            foreach ($matches[0] as $url) {
                $s1 = substr($url, 0, strlen($url));
                // $s2 .= $s1;
                array_push($s2, $s1);
            }
            foreach ($s2 as $key => $value) {
                if(strpos($value, "www.youtube.com") !== false){
                    $string1 .="<iframe width='420' height='315'";
                    $string1 .="src='".str_replace("watch?v=", "embed/", $value)."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen>";
                    $string1 .="</iframe>";
                }else{
                    $parts1 = explode("/", $value);
                    $parts1 = end($parts1);
                    $parts1 = explode(".", $parts1);
                    $parts1 = end($parts1);
                    if($parts1=="gif" || $parts1=="jpg" || $parts1=="jpeg" || $parts1=="png"){
                        $string1 .="<img src=".$value." height='100' width='100' />";
                    }

                    if($parts1=="mp4"){
                        $string1 .="<video controls height='150' width='150'>";
                        $string1 .="<source src=".$value." type='video/".$parts1."'>";
                        $string1 .="</video>";
                    }

                    if($parts1=="doc" || $parts1=="docx"){
                         $string1 .="<img src=".$value." height='100' width='100' />";
                    }

                    if($parts1=="pdf"){
                         $string1 .="<img src=".$value." height='100' width='100' />";
                    }    
                }
                $string =str_replace($value, "", $string);
            }
            $string .= $string1;
            echo $string;
            
            // die();
            // echo "$s2<br />\n";
    }    

    public function uploadImage(){
        $fullUrl = $_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."uploads/photos/".$_FILES['PhotoFile']['name'];
        if(file_exists($fullUrl)){
            $arr = array("status"=>false,"message"=>'The file you are trying to upload with name <b>'.$_FILES['PhotoFile']['name']."</b> already exist on server, please rename it to upload again");
        }else{
            $Ctype = $this->input->post('uploadType');
            $config['upload_path']          = './uploads/photos/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|mp4|pdf|doc|docx|ppt';
            $config['file_name']            = $_FILES['PhotoFile']['name'];
            if($Ctype=="2"){
                $config['max_size']             = 6144;
            }else{
                $config['max_size']             = 2048;
            }

            
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('PhotoFile'))
            {
                $uploadedImage = $this->upload->data();
                
                $ext = pathinfo($uploadedImage['file_name']);
                // die(print_r($ext));
                $data = array("image_name"=>$uploadedImage['file_name'],"path"=>str_replace("./", "", $config['upload_path']."".$config['file_name']),"type"=>$Ctype);

                $insert = $this->curriculum->insertPhoto($data);

                if($insert>0){
                    $arr = array("status"=>true,"message"=>'File Uploaded Successfully');
                }else{
                    $arr = array("status"=>false,"message"=>'Something went wrong!please try again');
                }
                
            }else{
                $arr = array("status"=>false,"message"=>$this->upload->display_errors());
            }
        }
        echo json_encode($arr);
    }

    public function loadPhotos(){
        $get = $this->curriculum->getPhotos();
        $data = array();
        $data['photos'] = $get;
        $this->load->view("Curriculum/loadphotos",$data);
        // $table="<table width='100%''>";
        // if(count($get)>0){
        //     $j = 1;
        //     foreach ($get as $key => $value) {
        //          if($value['type']=="1"){
        //             $img = base_url()."".$value['path'];
        //            }else if($value['type']=="3"){
        //             $img = base_url()."app-assets/images/pdf-file-icon.png";
        //            }else if($value['type']=="4"){
        //              $img = base_url()."app-assets/images/docs-icon.png";
        //            }  
        //         $table .="<tr>";
        //         $table .="<td><img src='".$img."' width='120' height='120' /></td>";        
        //         $table .='</td>';
        //         $table .="<td><a href='javascript:void(0);' class='linkbox'>".base_url()."".$value['path']."</a></td>";
        //         $table .='<td><a href="javascript:void(0);" class="removePhoto" remId='.$value['image_id'].' ><i class="fa fa-times"></i></a>
        //         <p id="p1'.$j.'" style="display: none;">'.base_url()."".$value['path'].'</p>';
        //         $table .="<a onclick='copyToClipboard('#p1".$j."','btnid".$j."')' class='btn btn-sm btn-primary' id='btnid'><i class='fa fa-copy'></i></a>
        //             </td>";
        //         $table .='</tr>';
        //         $table .="<tr><td colspan='3' align='center'>&nbsp; </td></tr>";
        //       $j++;  
        //     }
        // }
        // $table .="</table>";
        // echo $table;
    }

    public function removeImage(){
        $getFile = getData('tb_photos',array('path'),'image_id',$this->input->post('id'));
        $fileName = $getFile[0]['path'];
        
        $delete = $this->curriculum->removePhoto($this->input->post('id'));
        if($delete>0){
            unlink($_SERVER['DOCUMENT_ROOT']."".str_replace("index.php", "", $_SERVER['SCRIPT_NAME'])."".$fileName);

            $arr = array("status"=>true,"message"=>"Successfully Removed");
        }else{
            $arr = array("status"=>false,"message"=>"Failed To Remove");
        }
        echo json_encode($arr);
    }    

    public function getPreview($class,$day,$lesson){
        $data = array();
        $data['class'] = $class;
        $data['day'] = $day;
        $data['lesson'] = $lesson;
        $data['page_name'] = 'Preview';
        $this->load->view("Curriculum/preview",$data);
    }

    public function loadPreview($class,$day,$lesson){
        $cdata = $this->curriculum->getRows($class,$day,$lesson);
        $data = array();
        if(count($cdata)>0){
            $data['curriculumData'] = $cdata;
            $data['day'] = $day;
            $lesson = getData("lesson",array('lesson_title','lesson_icon'),'lesson_id',$lesson);
            $data['lesson'] = (count($lesson)>0) ? $lesson : '';
        }else{
            $data['curriculumData'] = array();
            $data['day'] = $day;
            $data['lesson'] = '';
        }
        $data['hideboot'] = "1";
        $this->load->view('Curriculum/loadpreview',$data);
    }

    public function loadCurdates(){
        $data['dates'] = $this->tb_class->getRows($_POST['class']);
        $data['dclass'] = $_POST['class'];
        $this->load->view("Curriculum/curriculum_days",$data);
    }

    public function removeCurriculum(){
        $getClass = getMultiWhere('curriculum',array('curriculum_class'),array('curriculum_id'=>$_POST['id']));
        $classId = (count($getClass)>0) ? $getClass[0]['curriculum_class'] : '';
        $remove = $this->curriculum->delete($_POST['id']);
        if($remove==true){
            $arr1 = array("status"=>true,"data"=>$classId,"message"=>"Curriculum Removed Successfully");
        }else{
            $arr1 = array("status"=>true,"data"=>"","message"=>"Failed To Remove Curriculum");
        }
        echo json_encode($arr1);
    }


    public function InstantPreview($descr='',$day,$lesson){
        $descr[0] = array("curriculum_lesson_description"=>$_POST['descr']);
        $data['curriculumData'] = $descr;
        $data['day'] = $_POST['day'];
        $lesson = getData("lesson",array('lesson_title','lesson_icon'),'lesson_id',$_POST['lesson']);
        $data['lesson'] = (count($lesson)>0) ? $lesson : '';
        $data['hideboot'] = "1";
        $this->load->view('Curriculum/loadpreview',$data);
        // echo $html;
    }

    public function loadInstantPreview(){
        $tempdesc = html_entity_decode($_POST['descr']);
        $regex = '/https?\:\/\/[^\" \n]+/i';
            preg_match_all($regex, strip_tags($tempdesc), $matches);
            $s2 = array();
            $string1 = "";
            foreach ($matches[0] as $url) {
                $s1 = substr($url, 0, strlen($url));
                array_push($s2, $s1);
            }
            
            foreach ($s2 as $Ckey => $Cvalue) {

                if(strpos($Cvalue, "www.youtube.com") !== false){
                    
                    $string1 = "<br><br>";
                    $string1 .="<iframe width='290' height='215'";
                    $string1 .="src='".$Cvalue."' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen>";
                    $string1 .="</iframe>";
                    $string1 .="<br><br>";
                   
                    // die($_POST['descr']);
                    $dom = new DOMDocument;
                    $dom->loadHTML($tempdesc);
                    $links = $dom->getElementsByTagName('iframe');

                    foreach ($links as $link){
                        $link->setAttribute('width','290');
                        $link->setAttribute('height','215');
                    }

                    $tempdesc = $dom->saveHtml();



                    $tempdesc = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $tempdesc);

                    $tempdesc = str_replace("<html><body>", "", $tempdesc);
                    $tempdesc = str_replace("</html></body>", "", $tempdesc);

                    

                        $tag = array('iframe');
                        // $temp = "";
                          foreach ($tag as $tvalue) {
                           
                            }
                          

                }else{
                    $parts1 = explode("/", $Cvalue);
                    $parts1 = end($parts1);
                    $parts1 = explode(".", $parts1);
                    $parts1 = end($parts1);

                    if(trim($parts1)=="gif" || trim($parts1)=="jpg" || trim($parts1)=="jpeg" || trim($parts1)=="png"){
                        

                        $string1 ="<br><br>";
                        $string1 .="<a href='".trim($Cvalue)."'><img src='".trim($Cvalue)."' height='150' width='290' /></a>";
                        $string1 .="<br><br>";
                        $tempdesc = str_replace(trim($Cvalue), $string1, $tempdesc);
                    }

                    if(trim($parts1)=="mp4"){
                        $string1 = "<br><br>";
                        $string1 .="<video controls height='120' width='290'>";
                        $string1 .="<source src='".trim($Cvalue)."' type='video/".trim($parts1)."'>";
                        $string1 .="</video>";
                        $string1 .="<br><br>";
                        $tempdesc = str_replace(trim($Cvalue), $string1, $tempdesc);
                    }

                    if(trim($parts1)=="doc" || trim($parts1)=='docx'){
                        
                        $string1 = "<br><br>";
                        $string1="<a href='".trim($Cvalue)."'>View Document</a>";
                        $tempdesc = str_replace(trim($Cvalue), $string1, $tempdesc);
                    }

                      if(trim($parts1)=="pdf"){
                         $string1 .="<a href='".trim($Cvalue)."'>View Pdf</a>";
                         $tempdesc = str_replace(trim($Cvalue), $string1, $tempdesc);
                    }    

                    if(trim($parts1)=="ppt"){
                         $string1 .="<a href='".trim($Cvalue)."'>View PPT</a>";
                         $tempdesc = str_replace(trim($Cvalue), $string1, $tempdesc);
                    }
                    
                }
            }
        $descr[0] = array("curriculum_lesson_description"=>$tempdesc);
        $data['curriculumData'] = $descr;
        $data['day'] = $_POST['day'];
        $lesson = getData("lesson",array('lesson_title','lesson_icon'),'lesson_id',$_POST['lesson']);
        $data['lesson'] = (count($lesson)>0) ? $lesson : '';
        $data['hideboot'] = "1";
         
        $this->load->view('Curriculum/instant_preview',$data);

    }

    public function removeCurriculumDay(){
        $class = $_POST['class'];
        $day = $_POST['day'];
        $delete = $this->curriculum->deleteCurriculumday($class,$day);
        if($delete==true){
            $arr1 = array("status"=>true,"data"=>$class,"message"=>"Curriculum Removed Successfully");
        }else{
            $arr1 = array("status"=>true,"data"=>"","message"=>"Failed To Remove Curriculum");
        }
        echo json_encode($arr1);
    }

    public function ExportCurriculum($class){
        $class1 = getMultiWhere('curriculum',array(),array('curriculum_class'=>$class));
        $ctitle = getData('tb_class',array('title'),'class_id',$class);
        $fileName = "EXPORTOFCLASS-".$ctitle[0]['title'].".xls";
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Curriculum class');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Curriculum day');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Curriculum lesson');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Curriculum lesson description');
        $rowCount = 2;
        foreach ($class1 as $list) {
            $class = getData('tb_class',array('title'),'class_id',$list['curriculum_class']);
            $lesson = getData('lesson',array('lesson_title'),'lesson_id',$list['curriculum_lesson']);

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, (count($class)>0) ? $class[0]['title'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['curriculum_day']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, (count($lesson)>0) ? $lesson[0]['lesson_title'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['curriculum_lesson_description']);
            $rowCount++;
        }
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output');

    }
}