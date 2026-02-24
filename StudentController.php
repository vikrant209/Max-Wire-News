<?php

use PFBC\Form;
use PFBC\Element;
use PFBC\View;
use PFBC\View\SideBySide;

/**
 * Description of StudentController
 *
 * @author deepak
 */
class StudentController extends CommonController {

    function addAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmstudent');
            if (isset($_SESSION['error_std_pic_path'])) {
                Form::setError("frmstudent", "Error: " . $_SESSION['error_std_pic_path']);
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStudent($res['Username'], null);

            if (!$isUnique) {
                Form::setError("frmstudent", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            if (isset($res['primary_email']) && $res['primary_email'] != null) {
                $isUnique = $this->objModel->isUniqueStudentPEmail($res['primary_email'], null);

                if (!$isUnique) {
                    Form::setError("frmstudent", "Error: Primary Email should be unique.");
                    Form::renderAjaxErrorResponse($res['form']);
                    exit();
                }
            }
            if (isset($res['alternate_email']) && $res['alternate_email'] != null) {
                $isUnique = $this->objModel->isUniqueStudentAEmail($res['alternate_email'], null);

                if (!$isUnique) {
                    Form::setError("frmstudent", "Error: Alternate Email should be unique.");
                    Form::renderAjaxErrorResponse($res['form']);
                    exit();
                }
            }

            $isUnique = $this->objModel->checkUserLogin($res['Username'], null, null);
            if (!$isUnique) {
                Form::setError("frmstudent", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            //$parent = explode('::', $res['parentid']);
            //$res['parentid'] = $parent['1'];
            try {
                $id = $this->objModel->add($res);
                if ($res['Password']) {
                    $this->objModel->createUserLogin($res['Username'], 'student', $id, $res['Password']);
                }
            } catch (Exception $e) {
                Form::setError("frmstudent", "Error: " . $e->getMessage());
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        } else {
            Form::clearErrors('frmstudent');
        }
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['arrparents'] = $this->parentsDropDownArray();
        return $ar;
    }

    function viewAction($res) {
       	$ar['editstudent'] = $this->objModel->studentById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['arrparents'] = $this->parentsDropDownArray();
        return $ar;  
    }
	 function viewpublicAction($res) {
       	$ar['editstudent'] = $this->objModel->studentById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['arrparents'] = $this->parentsDropDownArray();
        return $ar;  
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
            Form::clearErrors('frmstudent');
            if (isset($_SESSION['error_std_pic_path'])) {
                Form::setError("frmstudent", "Error: " . $_SESSION['error_std_pic_path']);
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStudent($res['Username'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmstudent", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            if (isset($res['primary_email']) && $res['primary_email'] != null) {

                $isUnique = $this->objModel->isUniqueStudentPEmail($res['primary_email'], array('id' => $res['id']));

                if (!$isUnique) {
                    Form::setError("frmstudent", "Error: Primary Email should be unique.");
                    Form::renderAjaxErrorResponse($res['form']);
                    exit();
                }
            }
            if (isset($res['alternate_email']) && $res['alternate_email'] != null) {
                $isUnique = $this->objModel->isUniqueStudentAEmail($res['alternate_email'], array('id' => $res['id']));

                if (!$isUnique) {
                    Form::setError("frmstudent", "Error: Alternate Email should be unique.");
                    Form::renderAjaxErrorResponse($res['form']);
                    exit();
                }
            }
            //$parent = explode('::', $res['parentid']);
            //$res['parentid'] = $parent['1'];
            $isUnique = $this->objModel->checkUserLogin($res['Username'], 'student', $res['id']);
            if (!$isUnique) {
                Form::setError("frmstudent", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            try {
                $id = $this->objModel->update($res, $res['id']);
                if ($res['Password']) {
                    $this->objModel->updateUserLogin($res['Username'], null, 'student', $res['id']);
                }
            } catch (Exception $e) {
                Form::setError("frmstudent", "Error: " . $e->getMessage());
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        } else {
            Form::clearErrors('frmstudent');
        }
        $ar['editstudent'] = $this->objModel->studentById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['arrparents'] = $this->parentsDropDownArray();
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

    function addtypeAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmstudenttype');
            $isUnique = $this->objModel->isUniqueStudenttype($res['type'], null);
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Student Type should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $id = $this->objModel->addtype($res);
            if ($id) {
                
            }
        } else {
            Form::clearErrors('frmstudenttype');
        }
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }

    function edittypeAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmstudenttype');
            $isUnique = $this->objModel->isUniqueStudenttype($res['type'], array('id' => $res['id']));
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Fee Title should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $id = $this->objModel->edittype($res, $res['id']);
        } else {
            Form::clearErrors('frmstudenttype');
        }
        $ar['type'] = $this->objModel->viewtypeById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }

    function deletetypeAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->edittype($res, $res['id']);
    }

    function listtypeAction($res) {
        return $this->objModel->listtype($res);
    }

    //=============================================================
    function addhouseAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmstudenthouse');
            $isUnique = $this->objModel->isUniqueStudenttype($res['name'], null);
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Student House should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $id = $this->objModel->addhouse($res);
            if ($id) {
                
            }
        } else {
            Form::clearErrors('frmstudenthouse');
        }
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['ddstaff'] = $this->staffDropDownArray();
        return $ar;
    }

    function edithouseAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmstudenthouse');
            $isUnique = $this->objModel->isUniqueStudenttype($res['name'], array('id' => $res['id']));
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: House should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $id = $this->objModel->edithouse($res, $res['id']);
        } else {
            Form::clearErrors('frmstudenthouse');
        }
        $ar['house'] = $this->objModel->viewhouseById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        $ar['ddstaff'] = $this->staffDropDownArray();
        return $ar;
    }

    function deletehouseAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->edithouse($res, $res['id']);
    }

    function listhouseAction($res) {
        return $this->objModel->listhouse($res);
    }

    function parentAction($res) {
        echo json_encode($this->objModel->parentlist($res));
        die;
    }

    function classAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->classBySchoolId($res['sid']));
        die();
    }

    function studenttypeAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->studentTypeBySchoolId($res['sid']));
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

    function listattendanceAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrattendancetype'] = $this->attendancetypeDropDownArray();

        $ar['list'] = $this->objModel->listsattendance($res);
        return $ar;
    }

    function listsubjectattendanceAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrsubject'] = $this->subjectDropDownArray();

        $ar['list'] = $this->objModel->listsubjectattendance($res);
        return $ar;
    }

    public function subjectattandenceAction($res) {
        $this->objModel->addsubjectAttendance($res);
        die('Saved');
    }

    public function getsubjectattaAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->getsubjectAttedence($res));
        die();
    }

    function listexamAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->subjectDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrattendancetype'] = $this->attendancetypeDropDownArray();

        $ar['list'] = $this->objModel->listsexam($res);
        return $ar;
    }

    function listassscoreAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->assessmentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrattendancetype'] = $this->attendancetypeDropDownArray();
        $ar['arrsubject'] = $this->subjectDropDownArray();
        //print_r($ar['arrsubject']);
        $ar['list'] = $this->objModel->listsassscore($res);
        return $ar;
    }

    function studentbyclassschoolAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->studentbyClassSchoolId($res['cid'], $res['sid']));
        die();
    }

    public function attandenceAction($res) {
        $this->objModel->addAttendance($res);
        die('Saved');
    }

    public function getattaAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->getAttedence($res));
        die();
    }

    public function marksAction($res) {
        $this->objModel->addMarks($res);
        die('Saved');
    }

    public function getmarksAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->getMarks($res));
        die();
    }

    public function assessmentscoreAction($res) {
        $this->objModel->addScore($res);
        die('Saved');
    }

    public function getassessmentscoreAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->getScore($res));
        die();
    }

    function lgaAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->lgaByStateId($res['id']));
        die();
    }
	
    function viewstudentdataAction($res) {
        return $this->objModel->viewstudentdata($res);
    }

    function viewstudentattendanceAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrattendancetype'] = $this->attendancetypeDropDownArray();

        $ar['list'] = $this->objModel->listsattendance($res);
        return $ar;
    }

    function viewstudentassessmentAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->assessmentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrattendancetype'] = $this->attendancetypeDropDownArray();
        $ar['arrsubject'] = $this->subjectDropDownArray();

        $ar['list'] = $this->objModel->listsassscore($res);
        return $ar;
    }

    function studattendanceAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->studattendance($res['cid'], $res['sid']));
        die();
    }
    
    function viewstudentresultsAction($res) {
        $ar['list'] = $this->objModel->getListStudentExamInfo();
        return $ar;
    }
    function viewstudentresultAction($res) {
        $ar['list'] = $this->objModel->getListStudentExamInfo();
        return $ar;
    }
    
    function printstudentresultAction($res) {
        $ar['student_path'] = $this->config['student_pic_path_url'] ;
        $ar['list'] = $this->objModel->getStudentExamInfo($res['sid'], $res['tid']);
        return $ar;
    }
    
    function generatestudentresultAction($res) {
        $ar['list'] = $this->objModel->generateListStudentExamInfo($res);
        return $ar;
    }
    
    function generatestresultAction($res) {
        $ar['list'] = $this->objModel->generateListStudentExamInfoSave($res);
        return $ar;
    }
    
    
    function classDropDownAction($res) {
        $ar = array();
        $ar['arrclass'] = $this->classDropDownArray();
        return $ar;
    }    
    
    function reportParentDropDownAction($res) {
        $ar = array();
        $ar['rp'] = $this->listReportParentItem();
        return $ar;
    }  
    
    function listreportsectionAction($res) {
        $ar['list'] = $this->objModel->listReportItem($res);
        return $ar;
    }
    
    function addreportsectionAction($res) {      
        if ($this->isPost()) {
//            if (!isset($res['class']) || $res['class'] == null) {
//                echo "Please select a class.";
//                exit();
//            }
            
            if (!isset($res['heading']) || $res['heading'] == null) {
                echo "Please enter report card item.";
                exit();
            }
//            
//            if (!isset($res['termid']) || $res['termid'] == null) {
//                echo "Please select term.";
//                exit();
//            }
            
            $arp = array();
            $arp['class_id'] = $res['class'];
            $arp['heading'] = $res['heading'];
            $arp['parent_id'] = $res['parent_id'];
            $arp['term_id'] = $res['termid'];
            $this->objModel->saveReportSection($arp);
            echo "SUCCESS"; 
            exit();
        }
        $ar = array();
        $ar['arrterm'] = $this->objModel->dropdownarray('schoolterm', 'id', 'name');
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['rp'] = $this->objModel->listReportParentItem($res);
        return $ar;
    }
    
    function editreportsectionAction($res) {        
        if ($this->isPost()) {
//            if (!isset($res['class']) || $res['class'] == null) {
//                echo "Please select a class.";
//                exit();
//            }
            
            if (!isset($res['heading']) || $res['heading'] == null) {
                echo "Please enter report card item.";
                exit();
            }
//            
//            if (!isset($res['termid']) || $res['termid'] == null) {
//                echo "Please select term.";
//                exit();
//            }
            
            $arp = array();
            $arp['class_id'] = $res['class'];
            $arp['heading'] = $res['heading'];
            $arp['parent_id'] = $res['parant_id'];
            $arp['term_id'] = $res['termid'];
            $this->objModel->updateReportSection($arp, $res['rp_id']);
            echo "SUCCESS"; 
            exit();
        }
        
        $ar = array();
        $ar['arrterm'] = $this->objModel->dropdownarray('schoolterm', 'id', 'name');
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['rp'] = $this->objModel->listReportParentItem($res);
        $as = $this->objModel->listReportItembyId($res);
        $ar['list'] = $as['0'];
        return $ar;
    }
    
    public function deleteReportCartItemAction($res) 
    {
        $this->objModel->deleteReportSection($res['id']);
        echo "SUCCESS";
        exit();
    }
    
    public function createFullReportCardsAction($res)
    {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->assessmentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrattendancetype'] = $this->attendancetypeDropDownArray();
        $ar['arrsubject'] = $this->subjectDropDownArray();
        //print_r($ar['arrsubject']);
        $ar['list'] = $this->objModel->listsassscore($res);
        $as = $this->objModel->listReportItembyId($res);
        $ar['list'] = $as['0'];
        return $ar;
    }
    
    public function getassessmentratingAction($res) {
        header("Content-type: application/json");
        echo json_encode($this->objModel->getScore($res));
        die();
    }
    
    public function studentreportcardsAction($res) {
        $ar['student_path'] = $this->config['student_pic_path_url'];
        $ar['list'] = $this->objModel->getStudentReport($res['sid'], $res['tid']);
        return $ar;
    }
    
    public function saveratingAction($res) {
        //$ar['student_path'] = $this->config['student_pic_path_url'];
        $ar['list'] = $this->objModel->addRating($res);
        //return $ar;
        die();
    }
    
    public function getrateingAction($res) {       
        header("Content-type: application/json");
        echo json_encode( $this->objModel->getRating($res));
        die();
    }
}
