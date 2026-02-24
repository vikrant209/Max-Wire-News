<?php

/**
 * Description of Acl
 *
 * @author deepak
 */
class AclModel extends CommonModel {

    public function lists() {
        $query = $this->objDb->from('acl_view');
        $row = $query->fetchAll();
        print_r($row);
        die;
    }

    public function rolelists($res) {
				$schoolcheck='';
			if (isset($_SESSION['loginSchoolId']) && $_SESSION['loginSchoolId'] != null) {
				  //$query->where($this->table_2 . '.schoolid = ?' , $_SESSION['loginSchoolId']);
				  $schoolcheck  = " school.id=". $_SESSION['loginSchoolId']." AND ";
				 }
        $sql = 'SELECT 
          ChildUserType.id, 
          ChildUserType.`name`, 
          ParentUserType.id as pid, 
          ParentUserType.`name` as pname,
          ChildUserType.approved,
          school.name as schoolname
          FROM role AS ChildUserType 
          LEFT JOIN role AS ParentUserType 
          ON ChildUserType.parent_id = ParentUserType.id JOIN school on school.id=ChildUserType.schoolid where'. $schoolcheck .' ChildUserType.deleted = 0';
        $arData = array();
        $rows = $this->objDb->getPdo()->query($sql);
        foreach ($rows as $row) {
            $arData[] = $row;
        }
        return array('list' => $arData);
    }

    public function isUniqueRole($value, $scap_id = null) {
        return parent::isUnique('role', array('name' => $value), $scap_id);
    }

    public function addRole($res) {
        $values = $this->createInsertUpdateArray('role', $res, 1);
        $query = $this->objDb->insertInto('role')->values($values);
        return $query->execute();
    }

    public function updateRole($res, $id) {
        $values = $this->createInsertUpdateArray('role', $res, 0);
        $query = $this->objDb->update('role')->set($values)->where('id', $id);
        return $query->execute();
    }

    public function roleById($id) {
        $query = $this->objDb->from('role')
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('id = ?', $id);
        $a = $query->fetchAll();
        $ar = $a['0'];
        return $ar;
    }

    public function getListActionControllerLebal() {
        $query = "SELECT 
                    ml.id AS lebalid,
                    ml.label,
                    a.id AS actionid,
                    c.id AS controllerid,
                    ml.parent_id AS parentid
                  FROM
                    menu_and_link ml
                  LEFT JOIN
                    `action` a ON ml.action_id = a.id
                  LEFT JOIN
                    controller c ON a.controller_id = c.id where  1";
        $arData = array();
        $rows = $this->objDb->getPdo()->query($query . ' and ml.parent_id = 0');

        $array = array();
        $i = 0;

        foreach ($rows as $row) {
            $arData = array();
            $crows = $this->objDb->getPdo()->query($query . ' and ml.parent_id = ' . $row['lebalid']);
            foreach ($crows as $irow) {
                $arData[] = $irow;
            }
            $row['child'] = $arData;
            $array[$i++] = $row;
        }
        return $array;
    }
    
    public function proleBySchoolId($pid){
        $query = $this->objDb->from('role')
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('parent_id = ?', $pid);
        $arr = array();
        $i = 0;
        foreach ($query as $row) {           
            $arr[$i]['id'] = $row['id'];
            $arr[$i]['name'] = $row['name'];
            $i++;
        }
        return $arr;
    }
    
    public function savePermission($res) {
        $role = $res['role'];
        if (isset($res['srole']) && $res['srole'] != null ) {
            $role = $res['srole'];
        }
        $delete = "DELETE FROM permission where role_id=".$role;
        $this->objDb->getPdo()->query($delete);
        foreach($res['permission'] as $key=>$val) {
           $ea = explode('_', $val);
           if (isset($ea['0']) && $ea['0'] != null) {
             $insert = "INSERT INTO `permission`(`action_id`, `role_id`, `controller_id`, `label_id`)
                      VALUES ('".$ea['1']."','".$role."','".$ea['2']."','".$ea['0']."')"; 
             $this->objDb->getPdo()->query($insert);
           }
        }
    }
    
    public function getPermission($role_id){
        $sql = "SELECT * FROM `permission` where `role_id`=".$role_id; 
        $rows = $this->objDb->getPdo()->query($sql);
        $ar = array();
        foreach ($rows as $row) {
          $ar[]['id'] =  $row['label_id'];    
        }
        return $ar;
    }
}