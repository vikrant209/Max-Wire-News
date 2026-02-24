<?php

/**
 * Description of EntranceController
 *
 * @author deepak
 */
class EntranceController extends CommonController {

    //put your code here
    function applicationAction($res) {
        $this->objModel->application($res);
    }

    function schoolAction() {
        $ar = array();
        $ar = $this->schoolDropDownArray();
        header("Content-type: application/json");
        echo json_encode($ar);
        die();
    }

    function schoolclassAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->classBySchoolId($res['sid']));
        die();
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

    function classAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->classBySchoolId($res['sid']));
        die();
    }

    function sessionAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->session($res['sid']));
        die();
    }

    function studenthouseAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->studentHouseBySchoolId($res['sid']));
        die();
    }

    function stateAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->stateCountyId($res['id']));
        die();
    }
    
    function statusAction($res)
    {
         header("Content-type: application/json");
         echo json_encode($this->objModel->status($res['id']));
         die();
    }
}
