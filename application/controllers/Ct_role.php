<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ct_role extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');

        $this->load->model('user');
        $this->load->model('role');
    }

    public function index() {
        $data = array();
        $data['page_name'] = 'Roles';
        $data['roleList'] = $this->role->roleList();
        $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">Dashboard</li>
                                            <li class="breadcrumb-item active">Role</li>
                                        </ol>';
        $activeMenu = $this->user->getActiveMenu('Role', 'main_menu');
        $rolePermission = $this->user->getRolePermission($_SESSION['LoginUserData']['role']);
        $data['active_menu'] = $activeMenu;
        $data['role_id'] = $_SESSION['LoginUserData']['role'];
        $data['permission'] = $rolePermission;
        
        if (!isset($_SESSION['username'])) {
            $this->load->view('login');
        } else {
            $this->load->view('Role/view', $data);
        }
    }

    public function getPermissionTree() {
        $id = $_GET['id'];
        $menu = $this->role->menu($id);
        echo json_encode($menu);
    }

    public function AddPermision() {
        $data['role_id'] = $_POST['rolid'];
        $data['permission'] = json_encode($_POST['perm']);
        $insert = $this->role->insertPerm($data, $_POST['rolid']);
        if ($insert) {
            return true;
        } else {
            return false;
        }
        // return $insert;
        // if ($insert) {
        //     $this->session->set_flashdata('success', 'Dealer Created Successfully.');
        //     header("Location:" . base_url() . "Ct_role/index");
        // } else {
        //     $this->session->set_flashdata('error', 'Something Wrong. Please Try Again.');
        //     header("Location:" . base_url() . "Ct_role/index");
        // }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $update = $this->role->update(array('role_name'=> $_POST['role_name'],'role_reporting_to'=> $_POST['reporting_to']),$id);
            header("Location:" . base_url() . "Ct_role/");
        } else {
            $data = array();
            $data['page_name'] = 'Edit Roles';
            $data['roleData'] = $this->role->roleList($id);
            $data['roleList'] = $this->role->roleList("", 1);
            $data['breadCrumb'] = '<ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="' . base_url() . '">Dashboard</a></li>
                                            <li class="breadcrumb-item">Role</li>
                                            <li class="breadcrumb-item active">Edit Role</li>
                                        </ol>';
            if (!isset($_SESSION['username'])) {
                $this->load->view('login');
            } else {
                $this->load->view('Role/edit', $data);
            }
        }
    }
    
    public function deleteRole() {
        $id = $_POST['id'];
        $return = $this->role->delete($id);
        echo $return;
    }

}