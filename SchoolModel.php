<?php

/**
 * Description of SchoolModel
 *
 * @author deepak
 */
class SchoolModel extends CommonModel {

    public $table = 'school';

    public function lists($res = array()) {
        $query = $this->objDb->from($this->table)
                ->where('school.status = ?', 1)
                ->where('school.deleted = ?', 0);
		if (isset($_SESSION['loginSchoolId']) && $_SESSION['loginSchoolId'] != null) {
				  $query->where('school.id = ?' , $_SESSION['loginSchoolId']);
				 }
        $arView['search_name'] = '';
        if (isset($res['name']) && $res['name'] != '') {
            $arView['search_name'] = $res['name'];
            $query->where('name like "%?%"', $res['name']);
        }

        $arView['list'] = $query->fetchAll();
        return $arView;
    }

    public function schoolById($id) {
        $query = $this->objDb->from($this->table)
                ->where($this->table . '.status = ?', 1)
                ->where($this->table . '.deleted = ?', 0)
                ->where($this->table . '.id = ?', $id);
        $a = $query->fetchAll();
        //print_r($a);
        return $a['0'];
    }

    public function add($res) {
        try {
            $values = $this->createInsertUpdateArray($this->table, $res, 1);
            $query = $this->objDb->insertInto($this->table)->values($values);
            $return = $query->execute();
            if (isset($_SESSION['std_pic_path']) && $_SESSION['std_pic_path'] != null) {
                $temp = explode(".", $_SESSION['std_pic_path']);
                $extension = end($temp);
                rename($_SESSION['std_pic_path'], $this->config['student_pic_path'] . $return . '.' . $extension);
                unset($_SESSION['error_std_pic_path']);
                unset($_SESSION['std_pic_path']);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update($res, $id) {
        try {
            $values = $this->createInsertUpdateArray($this->table, $res, 0);
            $query = $this->objDb->update($this->table)->set($values)->where('id', $id);
            $res = $query->execute();
            if (isset($_SESSION['std_pic_path']) && $_SESSION['std_pic_path'] != null) {
                $temp = explode(".", $_SESSION['std_pic_path']);
                $extension = end($temp);
                rename($_SESSION['std_pic_path'], $this->config['student_pic_path'] . $id . '.' . $extension);
                unset($_SESSION['error_std_pic_path']);
                unset($_SESSION['std_pic_path']);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function isUniqueSchool($value, $scap_id = null) {
        if ($value) {
            return parent::isUnique($this->table, array('schoolcode' => $value), $scap_id);
        } else {
            return true;
        }
    }

    public function isUniqueSchoolPEmail($value, $scap_id = null) {
        if ($value) {
            return parent::isUnique($this->table, array('primary_email' => $value), $scap_id);
        } else {
            return true;
        }
    }

    public function isUniqueSchoolAEmail($value, $scap_id = null) {
        if ($value) {
            return parent::isUnique($this->table, array('alternate_email' => $value), $scap_id);
        } else {
            return true;
        }
    }

}
