<?php

use PFBC\Form;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclController
 *
 * @author deepak
 */
class AclController extends CommonController {

    function addroleAction($res) {
        if ($this->isPost()) {
            $isUnique = $this->objModel->isUniqueRole($res['name'], null);
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Role should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $this->objModel->addRole($res);
        }
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }

    function editroleAction($res) {
        if ($this->isPost()) {
            $isUnique = $this->objModel->isUniqueRole($res['name'], array('id' => $res['id']));

            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Fee Title should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $this->objModel->updateRole($res, $res['id']);
        }
        $ar['role'] = $this->objModel->roleById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['ddparent'] = $this->ddRole($ar['role']['schoolid']);
        return $ar;
    }

    function viewroleAction() {
        
    }

    function listroleAction($res) {
        return $this->objModel->rolelists($res);
    }

    function deleteroleAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updateRole($res, $res['id']);
    }

    function roleAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->roleBySchoolId($res['sid']));
        die();
    }

    function proleAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->proleBySchoolId($res['pid']));
        die();
    }

    function ddRole($id) {
        $query = $this->objModel->roleBySchoolId($id);
        $arr = array('' => 'Select');
        foreach ($query as $row) {
            $arr[$row['id']] = $row['name'];
        }
        return $arr;
    }

    function setpermissionAction($res) {
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['ddparent'] = $this->ddRole(1);
        $ar['list'] = $this->objModel->getListActionControllerLebal();
        return $ar;
    }

    function permissionAction($res) {
        $this->objModel->savePermission($res);
        die;
    }

    function getpermissionAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->getPermission($res['pid']));
        die;
    }
    
    
    function auditlistAction($res) {   
		$userid=@$res['userid'];   
		$ar['userid'] = $userid;
	 	$ar['arrstaff'] = $this->logusernameDropDownArray();
		
        $ar['list'] =  $this->objModel->listAuditTrail($res);
        return $ar;
    }
}
