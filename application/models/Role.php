<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role extends CI_Model {

    public function __construct() {
        parent::__construct();

        // Load the database library
        $this->load->database();

//        $this->userTbl = 'users';
        $this->userTbl = 'user_register';
        $this->roleTbl = 'role';
        $this->citiesTbl = 'cities';
        $this->serviceCenterTbl = 'service_center';
        $this->mainMenuTbl = 'main_menu';
        $this->subMenuTbl = 'sub_menu';
        $this->subSubMenuTbl = 'sub_sub_menu';
        $this->permissionTbl = 'permission';
        $this->role_permissionTbl = 'role_permission';
    }

    public function roleList($id = "", $admin = "") {
        $this->db->select('*');
        $this->db->from($this->roleTbl);
        $this->db->where('role_status', 1);
        if ($id != "") {
            $this->db->where('role_id', $id);
        }
        if ($admin == "") {
            $this->db->where('role_id != ', 1);
        }

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function menu($id = "") {
        $this->db->select('*');
        $this->db->from($this->mainMenuTbl);
        $this->db->where('mm_status', 1);
        $query = $this->db->get();
        $result = $query->result_array();
        $returnArr = array();
        foreach ($result as $key => $value) {
            $this->db->select('*');
            $this->db->from($this->subMenuTbl);
            $this->db->where('sm_status', 1);
            $this->db->where('mm_id', $value['mm_id']);
            $querySM = $this->db->get();
            $resultSM = $querySM->result_array();
            $smArr = array();
            if (count($resultSM) > 0) {
                foreach ($resultSM as $i => $smData) {
                    
                    $pArr = array();
                    $permission = explode(",", $smData['permission']);
                    if (count($permission) > 0 && $permission[0] != "") {
                        foreach ($permission as $pi => $pval) {
                            $this->db->select('*');
                            $this->db->from($this->permissionTbl);
                            $this->db->where('p_status', 1);
                            $this->db->where('p_id', $pval);
                            $queryP = $this->db->get();
                            $resultP = $queryP->row_array();
                            if (!empty($id)) {
                                $this->db->select('permission');
                                $this->db->from($this->role_permissionTbl);
                                $this->db->where('role_id', $id);
                                $queryR = $this->db->get();
                                $resultR = $queryR->result_array();
                                if (count($resultR) > 0) {
                                    $perm1 = json_decode($resultR[0]['permission']);
                                    if (in_array("SM_" . $smData['sm_id'] . "_P_" . $resultP['p_id'], $perm1)) {
                                        $check = true;
                                    } else {
                                        $check = false;
                                    }
                                } else {
                                    $check = false;
                                }
                            } else {
                                $check = false;
                            }
                            
                            $pArr[] = array(
                                'id' => "SM_" . $smData['sm_id'] . "_P_" . $resultP['p_id'],
                                'text' => $resultP['p_name'],
                                'population' => null,
                                'flagUrl' => null,
                                'checked' => $check,
                                'hasChildren' => false,
                                'children' => array()
                            );
                        }
                    }else{
                        $this->db->select('*');
                        $this->db->from($this->subSubMenuTbl);
                        $this->db->where('status', 1);
                        $this->db->where('mm_id', $value['mm_id']);
                        $this->db->where('sm_id', $smData['sm_id']);
                        $querySS = $this->db->get();
                        $resultSS = $querySS->result_array();

                        if(count($resultSS) > 0){
                            foreach ($resultSS as $iss => $ssData) {
                                
                                $sspArr = array();
                                $permission = explode(",", $ssData['permission']);
                                if (count($permission) > 0 && $permission[0] != "") {
                                    foreach ($permission as $pi => $pval) {
                                        $this->db->select('*');
                                        $this->db->from($this->permissionTbl);
                                        $this->db->where('p_status', 1);
                                        $this->db->where('p_id', $pval);
                                        $queryP = $this->db->get();
                                        $resultPSS = $queryP->row_array();
                                        if (!empty($id)) {
                                            $this->db->select('permission');
                                            $this->db->from($this->role_permissionTbl);
                                            $this->db->where('role_id', $id);
                                            $queryR = $this->db->get();
                                            $resultR = $queryR->result_array();
                                            if (count($resultR) > 0) {
                                                $perm1 = json_decode($resultR[0]['permission']);
                                                if (in_array("SS_" . $ssData['ss_id'] . "_P_" . $resultPSS['p_id'], $perm1)) {
                                                    $check = true;
                                                } else {
                                                    $check = false;
                                                }
                                            } else {
                                                $check = false;
                                            }
                                        } else {
                                            $check = false;
                                        }
                                        $sspArr[] = array(
                                            'id' => "SS_" . $ssData['ss_id'] . "_P_" . $resultPSS['p_id'],
                                            'text' => $resultPSS['p_name'],
                                            'population' => null,
                                            'flagUrl' => null,
                                            'checked' => $check,
                                            'hasChildren' => false,
                                            'children' => array()
                                        );
                                        
                                    }
                                }
                                
                                
                                $pArr[] = array(
                                    'id' => "SS_" . $ssData['ss_id'],
                                    'text' => $ssData['ss_name'],
                                    'population' => null,
                                    'flagUrl' => null,
                                    'checked' => $check,
                                    'hasChildren' => count($sspArr) > 0 ? true : false,
                                    'children' => $sspArr
                                );
                            }
                        }
                    }

                    if (!empty($id)) {
                        $this->db->select('permission');
                        $this->db->from($this->role_permissionTbl);
                        $this->db->where('role_id', $id);
                        $queryR = $this->db->get();
                        $resultR = $queryR->result_array();
                        if (count($resultR) > 0) {
                            $perm1 = json_decode($resultR[0]['permission']);
                            if (in_array("SM_" . $smData['sm_id'], $perm1)) {
                                $check = true;
                            } else {
                                $check = false;
                            }
                        } else {
                            $check = false;
                        }
                    } else {
                        $check = false;
                    }
                    
                    $smArr[] = array(
                        'id' => "SM_" . $smData['sm_id'],
                        'text' => $smData['sm_name'],
                        'population' => null,
                        'flagUrl' => null,
                        'checked' => $check,
                        'hasChildren' => count($pArr) > 0 ? true : false,
                        'children' => $pArr
                    );
                }
            } else {
                $permission = explode(",", $value['permission']);
                if (count($permission) > 0 && $permission[0] != "") {
                    foreach ($permission as $pi => $pval) {
                        $this->db->select('*');
                        $this->db->from($this->permissionTbl);
                        $this->db->where('p_status', 1);
                        $this->db->where('p_id', $pval);
                        $queryP = $this->db->get();
                        $resultP = $queryP->row_array();

                        if (!empty($id)) {
                            $this->db->select('permission');
                            $this->db->from($this->role_permissionTbl);
                            $this->db->where('role_id', $id);
                            $queryR = $this->db->get();
                            $resultR = $queryR->result_array();
                            if (count($resultR) > 0) {
                                $perm1 = json_decode($resultR[0]['permission']);
                                if (in_array("MM_" . $value['mm_id'] . "_P_" . $resultP['p_id'], $perm1)) {
                                    $check = true;
                                } else {
                                    $check = false;
                                }
                            } else {
                                $check = false;
                            }
                        } else {
                            $check = false;
                        }

                        $smArr[] = array(
                            'id' => "MM_" . $value['mm_id'] . "_P_" . $resultP['p_id'],
                            'text' => $resultP['p_name'],
                            'population' => null,
                            'flagUrl' => null,
                            'checked' => $check,
                            'hasChildren' => false,
                            'children' => array()
                        );
                    }
                }
            }

            if (!empty($id)) {
                $this->db->select('permission');
                $this->db->from($this->role_permissionTbl);
                $this->db->where('role_id', $id);
                $queryR = $this->db->get();
                $resultR = $queryR->result_array();
                if (count($resultR) > 0) {
                    $perm1 = json_decode($resultR[0]['permission']);
                    if (in_array("MM_" . $value['mm_id'], $perm1)) {
                        $check = true;
                    } else {
                        $check = false;
                    }
                } else {
                    $check = false;
                }
            } else {
                $check = false;
            }
            $returnArr[] = array(
                'id' => "MM_" . $value['mm_id'],
                'text' => $value['mm_name'],
                'population' => null,
                'flagUrl' => null,
                'checked' => $check,
                'hasChildren' => count($resultSM) > 0 ? true : false,
                'children' => $smArr
            );
        }
        return $returnArr;
    }

    public function insertPerm($data, $id) {
        $this->db->select("*");
        $this->db->from($this->role_permissionTbl);
        $this->db->where("role_id", $id);
        $row = $this->db->get();
        $result = $row->result_array();
        // return $result;
        if (count($result) > 0) {
            $update = $this->db->update($this->role_permissionTbl, $data, array('role_id' => $id));
            return $update ? true : false;
        } else {
            $insert = $this->db->insert($this->role_permissionTbl, $data);
            return $insert ? $this->db->insert_id() : false;
        }
    }

    public function update($data, $id) {
        //add modified date if not exists
//        if (!array_key_exists('dl_modified_date', $data)) {
//            $data['dl_modified_date'] = date("Y-m-d H:i:s");
//        }
        //update user data in users table
        $update = $this->db->update($this->roleTbl, $data, array('role_id' => $id));
        //return the status
        return $update ? true : false;
    }

    public function delete($id) {
        //update user from users table
        $delete = $this->db->delete('role', array('role_id' => $id));
        //return the status
        return $delete ? true : false;
    }

    public function GetRowData($id, $column) {
        $this->db->select($column);
        $this->db->from($this->roleTbl);
        $this->db->where("role_id", $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

}

?>