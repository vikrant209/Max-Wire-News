<?php

use PFBC\Form;

/**
 * Description of Index
 *
 * @author deepak
 */
class IndexController extends CommonController {

    //put your code here
    function IndexAction($res) {
        return array();
    }

    function changepassAction($res) {
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        }
    }

    function resetpasswordAction($res) {        
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if ($res['npassword'] === $res['copassword']) {
               $this->objModel->updateUserPassword($res['npassword'], $res['user_id']);
               die('success');
            } else {
                Form::setError($res['form'], "Error: New Password and Confirm Password should be same.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        }
        return array();
    }
    
    function setuserddAction($res){
        header("Content-type: application/json");
        echo json_encode($this->ddUderByType($res['type'], $res['schoolid']));
        die();       
    }
}