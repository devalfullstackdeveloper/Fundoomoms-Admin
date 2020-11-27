<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_bookrequest extends CI_Controller {
	
	public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
		$this->load->model('user');
        $this->load->model('curriculum');
        $this->load->model('lesson');
        $this->load->model('tb_class');
        $this->load->helper('get_data_helper');
        $this->load->helper(array('url','html','form','html'));
        $this->load->model('bookcall');
    }
    
    public function index() {
        $data = array();
        // $data['page_name'] = 'Request for book a call';
        $data['page_name'] = 'Call Request';
         $data['cdnstylescript'] = array('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css');
        $data['cdnscript'] = array('https://cdn.jsdelivr.net/momentjs/latest/moment.min.js','https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js');
        $data['scriptname'] = 'book.js';
        $data['requestList'] = $this->bookcall->getAllRecords();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Request list</li>
                                        </ol>';
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Curriculum/requestbooklist', $data);
        }
    }

    public function setStatus() {
        $user = getData("book_call",array('user_id','status_history'),"book_id",$_POST['id']);

        $data1 = array();
        foreach (json_decode($user[0]['status_history']) as $key => $value) {      
            $arr1 = array("status"=>$value->status,"hdate"=>$value->hdate);
            array_push($data1, $arr1);
        }
        $arr2 = array("status"=>$_POST['status'],"hdate"=>date("Y-m-d h:i:s"));
        array_push($data1, $arr2);
        $idata = array("updated_at"=>date("Y-m-d h:i:s"),"status_history"=>json_encode($data1),"current_status"=>$_POST['status']);
        $insert = $this->bookcall->update($idata,$_POST['id']);
        if($insert>0){
            $arr = array("status"=>true,"data"=>"","message"=>"Status Updated Successfully");
        }else{
            $arr = array("status"=>true,"data"=>"","message"=>"Failed To Update Status");
        }
        echo json_encode($arr);
    }

    public function requestLoad(){

        if(isset($_POST['fromlist'])){
            $viewReq = $this->bookcall->viewRequest();    
        }
        

        if(!$_POST['start']){

            $data['requestList'] = $this->bookcall->getSearchRecords($_POST['start'],$_POST['end'],$_POST['fclass'],$_POST['fstatus']);
            $data['fclass'] = $_POST['fclass'];
            // $data['fmonth'] = $_POST['fmonth'];
            $data['fstatus'] = $_POST['fstatus'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
        }else{
            // if($_POST['fclass']=="all"){
            //     $class = "all";
            // }else{
            //     $class1 = $this->bookcall->getUserClass($_POST['fclass']);
            //     $class = $class1['id'];
            // }
            // if($_POST['fstatus']=="all"){
            //     $status="all";
            // }else{
            //     $status = $this->bookcall->getbookstatuswise($_POST['fstatus']);
            // }
            // die($class);
            $data['requestList'] = $this->bookcall->getSearchRecords($_POST['start'],$_POST['end'],$_POST['fclass'],$_POST['fstatus']);
            $data['fclass'] = $_POST['fclass'];
            // $data['fmonth'] = $_POST['fmonth'];
            $data['fstatus'] = $_POST['fstatus'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
        }
        
        $data['classList'] = $this->tb_class->getAllRecords();

        
        $this->load->view('Curriculum/requestlistload',$data);
    }
    

    public function ExportRequest($start,$end,$class,$status){

        $requestList = $this->bookcall->getSearchRecords($start,$end,$class,$status);
        $fileName = "CALL-REQUESTFILE-".$start."-".$end."-".$class."-".$status.".csv";
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Parent Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Child Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Class');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Validity');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Preferred Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Message');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Status');

        $rowCount = 2;
        foreach ($requestList as $list) {
            $user = getData('user_register',array('name','child_name','mobile','class'),"id",$list['user_id']);
            if(count($user)>0){
                $class = getData("tb_class",array('title'),"class_id",$user[0]['class']);
            }else{
                $class = array();
            }
            $lastSt = $this->bookcall->getLastStatus($list['book_id']);
            $validity = getValidity($list['user_id']);

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['appt_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, (count($user)>0) ? $user[0]['name'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, (count($user)>0) ? $user[0]['child_name'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, (count($class)>0) ? $class[0]['title'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, (count($validity)) ? $validity['validity'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, (count($user)) ? $user[0]['mobile'] : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['prefer_time']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['message']);
            if($list['current_status']=="1") $cstatus = 'New';
            if($list['current_status']=="2") $cstatus = 'Follow Up';
            if($list['current_status']=="3") $cstatus = 'Pending';
            if($list['current_status']=="4") $cstatus = 'Completed';
            if($list['current_status']=="5") $cstatus = 'Reschedule Call';
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $cstatus);
            $rowCount++;
        }
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');
    }
}