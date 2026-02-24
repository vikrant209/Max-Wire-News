<?php

/**
 * Description of LoginController
 *
 * @author deepak
 */
class LoginController extends CommonController {

    function addAction($res) {
        if (isset($_POST['Fee_Title']) && $_POST['Fee_Title'] != null) {
            $this->objModel->add($_POST);
        }
    }

    function updateAction() {
        
    }

    function viewAction() {
        
    }

    function indexAction($res) {
        return $this->objModel->login($res['email'], $res['pass'], $res['code']);
    }

    function deleteAction() {
        
    }

    public function checkloginAction($controller, $action) {
        $whiteList = array('LoginController-index');
        if (!in_array($whiteList, $controller . '-' . $action)) {
            if (!isset($_SESSION['loginYN']) || $_SESSION['loginYN'] == null) {
                header('HTTP/1.0 403 Forbidden');
                die('You have not permission.');
            }
        }
    }

    public function logoutAction() {
        session_destroy();
        header('Location:login.php');
    }

    public function profileAction() {
	
		return $this->objModel->viewstudentdata();
	
        return;
    }

}
