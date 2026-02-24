<?php

use PFBC\Form;
use PFBC\Element;
use PFBC\View;
use PFBC\View\SideBySide;

/**
 * Description of SchoolController
 *
 * @author deepak
 */
class SchoolController extends CommonController {

    function addAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmschool');
            if (isset($_SESSION['error_std_pic_path'])) {
                Form::setError("frmschool", "Error: " . $_SESSION['error_std_pic_path']);
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueSchool($res['schoolcode'], null);

            if (!$isUnique) {
                Form::setError("frmschool", "Error: School Code should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueSchoolPEmail($res['primary_email'], null);

            if (!$isUnique) {
                Form::setError("frmschool", "Error: Primary Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueSchoolAEmail($res['alternate_email'], null);

            if (!$isUnique) {
                Form::setError("frmschool", "Error: Alternate Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }


            try {
                $id = $this->objModel->add($res);
            } catch (Exception $e) {
                Form::setError("frmschool", "Error: " . $e->getMessage());
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        } else {
            Form::clearErrors('frmschool');
        }
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }

    function viewAction() {
        
    }

    function listAction($res) {
        return $this->objModel->lists($res);
    }

    function deleteAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->update($res, $res['id']);
    }

    function editAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmschool');
            if (isset($_SESSION['error_std_pic_path'])) {
                Form::setError("frmschool", "Error: " . $_SESSION['error_std_pic_path']);
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueSchool($res['schoolcode'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmschool", "Error: School Code should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueSchoolPEmail($res['primary_email'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmschool", "Error: Primary Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueSchoolAEmail($res['alternate_email'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmschool", "Error: Alternate Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $parent = explode('::', $res['parentid']);
            $res['parentid'] = $parent['1'];
            try {
                $id = $this->objModel->update($res, $res['id']);
            } catch (Exception $e) {
                Form::setError("frmschool", "Error: " . $e->getMessage());
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        } else {
            Form::clearErrors('frmschool');
        }
        $ar['editschool'] = $this->objModel->schoolById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }

    public function uploadAction($res) {
        $error = "";
        if (isset($_FILES["file"])) {
            $allowedExts = array("png", "jpg", "gif", "jpeg");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if ($_FILES["file"]["error"] > 0) {
                $error = "Error opening the file";
            }
            /* if ($_FILES["file"]["type"] != "application/pdf" &&
              $_FILES["file"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
              $_FILES["file"]["type"] != "application/msword" &&
              $_FILES["file"]["type"] != "application/vnd.oasis.opendocument.text") {
              $error .= "Mime type not allowed<br />";
              } */
            if (!in_array($extension, $allowedExts)) {
                $error .= "Extension not allowed";
            }
            /* if ($_FILES["file"]["size"] > 102400) {
              $error .= "File size shoud be less than 100 kB<br />";
              } */
            if ($error == "") {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $this->config['student_pic_path'] . '/' . $_FILES["file"]["name"])) {
                    $name = session_id() . '.' . $extension;
                    rename(
                            $this->config['student_pic_path'] . '/' . $_FILES["file"]["name"], $this->config['student_pic_path'] . '/' . $name
                    );
                    $_SESSION['std_pic_path'] = $this->config['student_pic_path'] . '/' . $name;
                    unset($_SESSION['error_std_pic_path']);
                }
            } else {
                $_SESSION['error_std_pic_path'] = $error;
            }
        }
    }

}
