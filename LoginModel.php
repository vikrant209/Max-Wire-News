<?php

/**
 * Description of LoginModel
 *
 * @author deepak
 */
class LoginModel extends CommonModel {

    private $parentLink = array();
    private $studentLink = array();
    //private $adminLink = array();
    public $table = 'login';

    

    public function login($email, $pass, $sc = null) {
        $query = $this->objDb->from('login')
                ->where('username like ?', $email)
                ->where('password like ?',  md5($pass));

        $id = false;
        foreach ($query as $row) { 
            if (isset($row['id']) && $row['id'] != null) {
                $id = $row['id'];
                $type = $row['type'];
                $type_id = $row['id_of_type_table'];
            }
        }
        //print_r($row);die;
        //parents
        //staff
        //student
        //users
        if ($id) {
            $schoolId = null;
	    	$schoolname = null;
            
            $type_id = $type_id;
            $_SESSION['loginYN'] = 'Y';
            $_SESSION['loginId'] = $id;
            $_SESSION['UTYPE'] = $type;
			$_SESSION['TYPEID'] = $type_id;
            $_SESSION['loginSchoolId'] = "1";
			$_SESSION['loginSchoolName'] = "Max News Wire";
//print_r($_SESSION);die;
            $query = $this->objDb->from($type)
                    ->where('id = ?', $type_id);

            foreach ($query as $row) {
                $_SESSION['loginedUser'] = $row;
                if ($type == 'student') {
                    $_SESSION['loginedUser']['firstname'] = $row['first_name'];
                    $_SESSION['loginedUser']['lastname'] = $row['last_name'];
                    $_SESSION['loginedUser']['middlename'] = $row['middle_name'];
                }
                $allowedExts = array("png", "jpg", "gif", "jpeg");
                $r = 0;
                foreach ($allowedExts as $key => $val) {
                    if (file_exists($this->config[$type . '_pic_path'] . '/' . $row['id'] . '.' . $val)) {
                        $_SESSION['loginedUser']['image'] = $this->config[$type . '_pic_path_url'] . '' . $row['id'] . '.' . $val;
                    }
                }
            }
            //print_r($_SESSION);die;
            if ($type != 'users' && !$this->checkSchoolByUserId($type_id, $type, $schoolId)) {
                unset($_SESSION);
                session_destroy();
                return false;
            }
            //var_dump($this->checkSchoolByUserId($type_id, $type, $schoolId));
            switch ($type) {
                case 'parents':
                    $leftMenu = $this->getLeftMenu(0, 1);
                    break;
                case 'student':
                    $leftMenu = $this->getLeftMenu(1, 0);
                    break;
                case 'staff':
                case 'users':
                    $leftMenu = $this->getLeftMenu(0, 0, $type);
                    break;
            }

            $_SESSION['leftMenu'] = $leftMenu;
            return true;
        } else {
            return false;
        }
    }

}
