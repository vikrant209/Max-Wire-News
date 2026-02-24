<?php

use PFBC\Form;
use PFBC\Element;
use PFBC\View;
use PFBC\View\SideBySide;

/**
 * Description of StaffController
 *http://school.local/load.php?q=Staff/listteachercomments
 * http://school.local/load.php?q=Staff/listteachercomments
 * http://school.local/load.php?q=Staff/addCommentsToClass
 * @author deepak
 */
class StaffController extends CommonController {

    function addAction($res) {
        if ($this->isPost()) {
            Form::clearErrors('frmstaff');
            if (isset($_SESSION['error_std_pic_path'])) {
                Form::setError("frmstaff", "Error: " . $_SESSION['error_std_pic_path']);
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStaff($res['Username'], null);

            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStaffPEmail($res['primary_email'], null);

            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Primary Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStaffAEmail($res['alternate_email'], null);

            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Alternate Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $isUnique = $this->objModel->checkUserLogin($res['Username'], null, null);
            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            try {
                $id = $this->objModel->add($res);
                if ($res['Password']) {
                    $this->objModel->createUserLogin($res['Username'], 'staff', $id, $res['Password']);
                }
            } catch (Exception $e) {
                Form::setError("frmstaff", "Error: " . $e->getMessage());
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        } else {
            Form::clearErrors('frmstaff');
        }
        $ar['staffposition'] = $this->staffpositionDropDownArray();
        $ar['staffrole'] = $this->staffroleDropDownArray();
        $ar['specialization'] = $this->specializationDropDownArray();
        $ar['schoolClass'] = $this->classDropDownArray();        
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
            Form::clearErrors('frmstaff');
            if (isset($_SESSION['error_std_pic_path'])) {
                Form::setError("frmstaff", "Error: " . $_SESSION['error_std_pic_path']);
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStaff($res['Username'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStaffPEmail($res['primary_email'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Primary Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->isUniqueStaffAEmail($res['alternate_email'], array('id' => $res['id']));

            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Alternate Email should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            $isUnique = $this->objModel->checkUserLogin($res['Username'], 'staff', $res['id']);
            if (!$isUnique) {
                Form::setError("frmstaff", "Error: Username should be unique.");
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }

            try {
                $id = $this->objModel->update($res, $res['id']);

                if ($res['Password']) {
                    $this->objModel->updateUserLogin($res['Username'], null, 'staff', $res['id']);
                }
            } catch (Exception $e) {
                Form::setError("frmstaff", "Error: " . $e->getMessage());
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
        } else {
            Form::clearErrors('frmstaff');
        }
        $ar['editstaff'] = $this->objModel->assessmentById($res['id']);
        $ar['staffposition'] = $this->staffpositionDropDownArray();
        $ar['staffrole'] = $this->staffroleDropDownArray();
        $ar['specialization'] = $this->specializationDropDownArray();
        $ar['schoolClass'] = $this->classDropDownArray();      
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

            if (!in_array($extension, $allowedExts)) {
                $error .= "Extension not allowed";
            }

            if ($error == "") {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $this->config['staff_pic_path'] . '/' . $_FILES["file"]["name"])) {
                    $name = session_id() . '.' . $extension;
                    rename(
                            $this->config['staff_pic_path'] . '/' . $_FILES["file"]["name"], $this->config['staff_pic_path'] . '/' . $name
                    );
                    $_SESSION['std_pic_path'] = $this->config['staff_pic_path'] . '/' . $name;
                    unset($_SESSION['error_std_pic_path']);
                }
            } else {
                $_SESSION['error_std_pic_path'] = $error;
            }
        }
    }

    //staffsubject class 
    function addstaffsubjectAction($res) {
        if ($this->isPost()) {
            $ar['schoolid'] = $res['school_id'];
            $ar['sessionid'] = $res['session_id'];
            $ar['classid'] = $res['class_id'];
            $ar['termid'] = $res['term_id'];
            $i = 0;
            foreach ($res['staffid'] as $key => $val) {
                $subjectid = $res['subject_id_' . $val];
                $ar['approved'] = $res['auth'][$i];
                $ar['deleted'] = !isset($res['delid'][$i]) || $res['delid'][$i] == null ? 0 : 1;
                $ar['staffid'] = $val;

                foreach ($subjectid as $key => $svalues) {
                    $ar['subjectid'] = $svalues;
                    $this->objModel->deleteStaffSubject($ar);
                    $this->objModel->addstaffsubject($ar);
                }
                $i++;
            }
        } else {
            //return $ar['frm'] = ;
        }
    }

    function viewstaffsubjectAction() {
        
    }

    function liststaffsubjectAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar['arrsubject'] = $this->subjectDropDownArray();
        $ar['list'] = $this->objModel->listsstaffsubject($res);
        //print_r($ar['list']);die;
        $s = $ar['list']['stafflist'];
        $list = array();
        if (count($ar['list']) > 0) {
            foreach ($ar['list']['list'] as $key => $val) {
                $list[$val['staffid']][] = $val['subjectid'];
            }
        }
        $ar['list']['stafflist'] = $s;
        $ar['list']['list'] = $list;

        if (isset($res['schoolid']) && $res['schoolid'] != null) {
            $ar['post'] = $res;
        }
        return $ar;
    }

    function deletestaffsubjectAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updatestaffsubject($res, $res['id']);
    }

    function editstaffsubjectAction($res) {
        if ($this->isPost()) {
            return $this->objModel->updatestaffsubject($res, $res['id']);
        }
        return $this->objModel->staffsubjectById($res['id']);
    }

    //staffteacher
    function addstaffteacherAction($res) {
        if ($this->isPost()) {
            $this->objModel->addstaffteacher($res);
        } else {
            //return $ar['frm'] = ;
        }
    }

    function viewstaffteacherAction() {
        
    }

    function liststaffteacherAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();

        $ar['list'] = $this->objModel->listsstaffteacher($res);
        return $ar;
    }

    function deletestaffteacherAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updatestaffteacher($res, $res['id']);
    }

    function editstaffteacherAction($res) {
        if ($this->isPost()) {
            return $this->objModel->updatestaffteacher($res, $res['id']);
        }
        return $this->objModel->staffteacherById($res['id']);
    }

    //teachercomments

    function teachercommentsAction($res) {
        header("Content-type: application/json");
        $ar = array();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrstudent'] = $this->studentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar1 = $this->objModel->liststeachercomments($res);
        $ar['selected'] = $ar1['selected'];
        $ar['comments'] = $ar1['comment'];
        echo json_encode($ar);
        die;
    }

    function addCommentsToClassAction($res) {
        $this->objModel->addCommentsToClass($res);
        die('Added');
    }

    function addteachercommentsAction($res) {
        if ($this->isPost()) {
            $this->objModel->addteachercomments($res);
        } else {
            //return $ar['frm'] = ;
        }
    }

    function viewteachercommentsAction() {
        
    }

    function listteachercommentsAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();

        $ar['list'] = $this->objModel->liststeachercomments($res);
        return $ar;
    }

    function deleteteachercommentsAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updateteachercomments($res, $res['id']);
    }

    function editteachercommentsAction($res) {
        if ($this->isPost()) {
            return $this->objModel->updateteachercomments($res, $res['id']);
        }
        return $this->objModel->teachercommentsById($res['id']);
    }

    //staffcategory
    function addstaffcategoryAction($res) {
        if ($this->isPost()) {
            $this->objModel->addstaffcategory($res);
        } else {
            //return $ar['frm'] = ;
        }
    }

    function viewstaffcategoryAction() {
        
    }

    function liststaffcategoryAction($res) {
        return $this->objModel->listsstaffcategory($res);
    }

    function deletestaffcategoryAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updatestaffcategory($res, $res['id']);
    }

    function editstaffcategoryAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        if ($this->isPost()) {
            foreach ($res['school_id'] as $key => $val) {
                if (isset($val) && $val != null) {
                    $schoolid = $val;
                    $auth = $res['auth'][$key];
                    $delid = isset($res['delid'][$key]) ? 1 : '0';
                    $this->objModel->replace_staff_school($schoolid, $res['id'], $auth, $delid);
                }
            }
            return;
            //return $this->objModel->updatestaffcategory($res, $res['id']);
        }
        $ar['staffid'] = $res['id'];
        $ar['list'] = $this->objModel->staffcategoryByIdInEdit($res['id']);
        //print_r($ar['list']);
        return $ar;
    }

    //staff position
    function addstaffpositionAction($res) {
	 	$ar['arrschool'] = $this->schoolDropDownArray();
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $this->objModel->addstaffposition($res);
        } else {
            //return $ar['frm'] = ;
        }
		return $ar;
    }

    function viewstaffpositionAction() {
        
    }

    function liststaffpositionAction($res) {
        return $this->objModel->listsstaffposition($res);
    }

    function deletestaffpositionAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updatestaffposition($res, $res['id']);
    }

    function editstaffpositionAction($res) {
	 	$ar['arrschool'] = $this->schoolDropDownArray();
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            return $this->objModel->updatestaffposition($res, $res['id']);
        }
         $ar['fee'] =  $this->objModel->staffpositionById($res['id']);
		 return $ar;
    }
//specialization
    function addspecializationAction($res) {
	 	$ar['arrschool'] = $this->schoolDropDownArray();
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $this->objModel->addspecialization($res);
        } else {
            //return $ar['frm'] = ;
        }
		return $ar;
    }

    function viewspecializationAction() {
        
    }

    function listspecializationAction($res) {
        return $this->objModel->listsspecialization($res);
    }

    function deletespecializationAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updatespecialization($res, $res['id']);
    }

    function editspecializationAction($res) {
	 	$ar['arrschool'] = $this->schoolDropDownArray();
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            return $this->objModel->updatespecialization($res, $res['id']);
        }
         $ar['fee'] =  $this->objModel->specializationById($res['id']);
		 return $ar;
    }
    function vstaffschoolAction($res) {
        return $this->objModel->vstaffschool($res);
    }

    function vstaffteacherAction($res) {
        return $this->objModel->vstaffteacher($res);
    }

    function vheadcommentsAction($res) {
        return $this->objModel->vheadcomments($res);
    }

    function editheadcommentsAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstudent'] = $this->studentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        if ($this->isPost()) {
            return $this->objModel->updateheadcomments($res, $res['id']);
        }
        $ar['list'] = $this->objModel->headcommentsById($res['id']);
        return $ar;
    }

    //headcomments
    function addheadcommentsAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstudent'] = $this->studentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        if ($this->isPost()) {
            $this->objModel->addheadcomments($res);
        } else {
            //return $ar['frm'] = ;
        }
        return $ar;
    }

    function vstaffsubjectAction($res) {
        return $this->objModel->vstaffsubject($res);
    }

    function staffteacherAction($res) {
        header("Content-type: application/json");
        $ar = array();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        $ar1 = $this->objModel->listsstaffteacher($res);
        $ar['selected'] = $ar1['selected'];
        echo json_encode($ar);
        die;
    }

    function addTeacherToClassAction($res) {
        $this->objModel->addTeacherToClass($res);
        die('Added');
    }

    //view student/parent head comments

    function viewstudenthousenoteAction($res) {
        return $this->objModel->viewstudenthousenote($res);
    }

    function editparentcommentsAction($res) {
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstudent'] = $this->studentDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();
        if ($this->isPost()) {
            return $this->objModel->updateheadcomments($res, $res['id']);
        }
        $ar['list'] = $this->objModel->headcommentsById($res['id']);
        return $ar;
    }

    //Medical comments

    function vmedicalcommentsAction($res) {
        $ar['medicalid'] = $res['medicalid'];
        return $this->objModel->vmedicalcomments($res);
    }

    function editmedicalcommentsAction($res) {

        if ($this->isPost()) {
            return $this->objModel->updatemedicalcomments($res, $res['id']);
        }
        $ar['list'] = $this->objModel->medicalcommentsById($res['id']);
        return $ar;
    }

    function addmedicalcommentsAction($res) {
        $ar['medicalid'] = $res['medicalid'];
        if ($this->isPost()) {
            $this->objModel->addmedicalcomments($res);
        } else {
            //return $ar['frm'] = ;
        }
        return $ar;
    }

    function viewmedicalpcommentsAction($res) {
        return $this->objModel->viewmedicalcomments($res);
    }

    function editmedicalpcommentsAction($res) {

        if ($this->isPost()) {
            return $this->objModel->updatemedicalcomments($res, $res['id']);
        }
        $ar['list'] = $this->objModel->medicalcommentsById($res['id']);
        return $ar;
    }
    //listteachercommentsAction househead
    function listclassteachercommentsAction($res) {
        $ar['who'] = 'classteacher';
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();

        $ar['list'] = $this->objModel->liststeachercomments($res);
        return $ar;
    }
    
    function listPrincipalsCommentsAction($res) {
        $ar['who'] = 'principle';
        $ar['arrschool'] = $this->schoolDropDownArray();
        $ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        $ar['arrstaff'] = $this->staffDropDownArray();
        $ar['arrclass'] = $this->classDropDownArray();

        $ar['list'] = $this->objModel->liststeachercomments($res);
        return $ar;
    }

}
