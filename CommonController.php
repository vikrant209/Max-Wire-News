<?php

use PFBC\Form;

/**
 * Description of CommonController
 *
 * @author deepak
 */
class CommonController {

    protected $objModel;
    public $config;

    public function __construct($objModel, $config) {
        $this->objModel = $objModel;
        //$this->objModel->table = isset($_REQUEST['t']) ? $_REQUEST['t'] : ''; 
        $this->config = $config;

        /* if (!isset($_SESSION['loginYN']) || $_SESSION['loginYN'] != 'Y') {
          header('location:login.php');
          } */
        $this->objModel->auditTrail();
    }

    protected function isPost() {
        return $this->checkRequest('POST');
    }

    private function checkRequest($tocheck) {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($tocheck == $method) {
            return true;
        } else {
            return false;
        }
    }

    public function upload($res) {
        //Form::setError("login", "Error: Invalid Email Address / Password");
        //print_r($_SESSION);die;
    }

    public function schoolDropDownArray() {
        return $this->objModel->dropdownarray('school', 'id', 'name');
    }

    public function staffDropDownArray() {
        return $this->objModel->dropdownarray('staff', 'id', 'firstname');
    }

    public function classDropDownArray() {
        return $this->objModel->dropdownarray('class', 'id', 'name');
    }

    public function schoolclassDropDownArray() {
        return $this->objModel->dropdownarray('class', 'id', 'name');
    }

    public function schooltermDropDownArray() {
        return $this->objModel->dropdownarray('schoolterm', 'id', 'name');
    }

    public function schoolsessionDropDownArray() {
        return $this->objModel->dropdownarray('schoolsession', 'id', 'name');
    }

    public function createUpdateLogin($username, $update_id = null) {
        
    }

    public function staffpositionDropDownArray() {
        return $this->objModel->dropdownarray('staff_position', 'id', 'name');
    }

    public function staffroleDropDownArray() {
        return $this->objModel->dropdownarray('role', 'id', 'name');
    }

    public function specializationDropDownArray() {
        return $this->objModel->dropdownarray('specialization', 'id', 'name');
    }

    public function studentDropDownArray() {
        return $this->objModel->dropdownarray('student', 'id', 'first_name');
    }

    public function approveAction($res) {
        return $this->objModel->approveYn($res['tab'], $res['yn'], $res['id']);
    }

    public function assessmentDropDownArray() {
        return $this->objModel->dropdownarray('assessment', 'id', 'name');
    }

    public function subjectDropDownArray() {
        return $this->objModel->dropdownarray('subject', 'id', 'name');
    }

    public function subjecttypeDropDownArray() {
        return $this->objModel->dropdownarray('subjecttype', 'id', 'name');
    }

    public function attendancetypeDropDownArray() {
        return $this->objModel->dropdownarray('attendance', 'id', 'name');
    }

    public function psychomotorDropDownArray() {
        return $this->objModel->dropdownarray('phychomotor', 'id', 'name');
    }

    public function parentsDropDownArray() {
        return $this->objModel->dropdownarray('parents', 'id', 'Username');
    }

    public function domainDropDownArray() {
        return $this->objModel->dropdownarray('domain', 'id', 'name');
    }

    public function libauthorDropDownArray() {
        return $this->objModel->dropdownarray('library_author', 'id', 'name');
    }

    public function libcategoryDropDownArray() {
        return $this->objModel->dropdownarray('library_category', 'id', 'name');
    }

    public function libpublicationsDropDownArray() {
        return $this->objModel->dropdownarray('library_publications', 'id', 'name');
    }

    public function libbookDropDownArray() {
        return $this->objModel->dropdownarray('library_books', 'id', 'name');
    }

    public function hostalDropDownArray() {
        return $this->objModel->dropdownarray('hostal', 'id', 'name');
    }

    public function roomtypeDropDownArray() {
        return $this->objModel->dropdownarray('hostal_room', 'id', 'name');
    }

    public function commgroupDropDownArray() {
        return $this->objModel->dropdownarray('comm_group', 'id', 'name');
    }

    public function commtempDropDownArray() {
        return $this->objModel->dropdownarray('comm_template', 'id', 'name');
    }

    public function logusernameDropDownArray() {
        return $this->objModel->auditTrailUserList();
    }
    
    public function ddUderByType($type, $scid)
    {
        return $this->objModel->getUserNameByType($type, $scid);        
    }
	
	public function  bankDropDownArray() {
        return $this->objModel->dropdownarray('bank', 'id', 'name');
    }  
	public function  bankbranchDropDownArray() {
        return $this->objModel->dropdownarray('bank_branch', 'id', 'branchname');
    } 

}
