<?php

/**
 * Description of AccountModel
 *
 * @author deepak
 */
class AccountModel extends CommonModel {

    public $table = 'feestype';
    public $table_1 = 'classfees';
	 public $table_2 = 'generatedfee';
	  public $table_3 = 'feepayment';
	
	//fee type 
    public function lists($res = array()) {
        $query = $this->objDb->from($this->table)
		 		->join('school ON school.id = ' . $this->table . '.schoolid')
                ->select('school.name as schoolname')
                 ->where($this->table . '.status = ?', 1)
                ->where($this->table . '.deleted = ?', 0);
		if (isset($_SESSION['loginSchoolId']) && $_SESSION['loginSchoolId'] != null) {
				  $query->where($this->table. '.schoolid = ?' , $_SESSION['loginSchoolId']);
				 }		
        $arView['search_name'] = '';
        if (isset($res['name']) && $res['name'] != '') {
            $arView['search_name'] = $res['name'];
            $query->where('name like "%?%"', $res['name']);
        }
        $arView['search_isfixed'] = 0;
        if (isset($res['isfixed']) && $res['isfixed'] != '') {
            $arView['search_isfixed'] = $res['isfixed'];
            $query->where('isfixed = ?', $res['isfixed']);
        }
        $arView['list'] = $query->fetchAll();
        return $arView;
    }

    public function feetypeById($id) {
        $query = $this->objDb->from($this->table)
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('id = ?', $id);
        $a = $query->fetchAll();

        return $a['0'];
    }

    public function add($res) {
        $values = $this->createInsertUpdateArray($this->table, $res, 1);
        $query = $this->objDb->insertInto($this->table)->values($values);
        return $query->execute();
    }

    public function update($res, $id) {
        $values = $this->createInsertUpdateArray($this->table, $res, 0);
        $query = $this->objDb->update($this->table)->set($values)->where('id', $id);
        return $query->execute();
    }
	
	//get student by parent 
	
	public function getstudentbyparent($res) {
	
			$query = $this->objDb->from('student')					 
					->where('status = ?', 1)
					->where('deleted = ?', 0);
			 if (isset($_SESSION['TYPEID']) && $_SESSION['TYPEID'] != null) {
				  $query->where( 'student.parentid = ?' , $_SESSION['TYPEID']);
				 }
			$a = $query->fetchAll();
			//echo "<pre>";print_r($a);die;
			return $a;
		
    }
	
	//make payment
	public function getfeepaymentbyId($res) {
	if(isset($res['student'])){
			$query = $this->objDb->from($this->table_3)
					->where('status = ?', 1)
					->where('deleted = ?', 0)
					->where('studentid = ?', $res['student'])
					->where('schoolsession = ?', $res['schoolsession'])
					->where('schoolterm = ?', $res['schoolterm']);
			$a = $query->fetchAll();
			return $a;
		}
    }
	 public function makefeepayment($res) {
	 	//echo "<pre>";print_r($res);die;
		$resnew['classid'] = $res['classid'];
		$resnew['schoolid'] = $res['schoolid'];
		$resnew['studentid'] = $res['student'];
		$resnew['paymode'] = $res['paymode'];
		$resnew['type'] = $res['type'];
		$resnew['amount'] = $res['amount'];
		$resnew['schoolterm'] = $res['termid'];
		$resnew['schoolsession'] = $res['sessionid'];
		
        $values = $this->createInsertUpdateArray($this->table_3, $resnew, 1);
        $query = $this->objDb->insertInto($this->table_3)->values($values);
        return $query->execute();
    }
	public function getstudentfeeById($res) {
	if(isset($res['student'])){
       $query = $this->objDb->from($this->table_2)
	   			->join('student ON student.classid = ' . $this->table_2 . '.classid')
                ->select('student.username as studentname')
	    		->join('class ON class.id = ' . $this->table_2 . '.classid')
                ->select('class.name as classname')
                ->join('class ON class.id = ' . $this->table_2 . '.classid')
                ->select('class.name as classname')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_2 . '.schoolterm')
                ->select('schoolterm.name as termname')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_2 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
                ->join('school ON school.id = ' . $this->table_2 . '.schoolid')
                ->select('school.name as schoolname')
                ->where('student.id = ?', $res['student'])
				->where($this->table_2 . '.schoolsession = ?', $res['schoolsession'])
				->where($this->table_2 . '.schoolterm = ?', $res['schoolterm']);
         	$arView['list'] = $query->fetchAll();
			//print_r($arView['list']);die;
        	return $arView;
		}
    }
	
	//fee generation 
	public function viewfeetempById($res) {
		
       $query = $this->objDb->from($this->table_2)
                ->join('class ON class.id = ' . $this->table_2 . '.classid')
                ->select('class.name as classname')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_2 . '.schoolterm')
                ->select('schoolterm.name as termname')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_2 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
                ->join('school ON school.id = ' . $this->table_2 . '.schoolid')
                ->select('school.name as schoolname')
                ->where($this->table_2 . '.status = ?', 1)
                ->where($this->table_2 . '.deleted = ?', 0)
                ->where($this->table_2 . '.classid = ?', $res['classid'])
				->where($this->table_2 . '.schoolterm = ?', $res['termid'])
				->where($this->table_2 . '.schoolsession = ?', $res['sessionid']);
         $arView['list'] = $query->fetchAll();

        return $arView;
    }
	public function generateclastermfee($res,$adminfee)
	{
		//echo "<pre>";print_r($res);
		//print_r($adminfee);die;
		$i=0;
		foreach($res['list'] as $key=>$val){
			//print_r($val);die;
			$newres['classid'] = $val['classid'] ;
			$newres['schoolid'] = $val['schoolid'] ;
			$newres['title'] = $val['title'] ;
			$newres['amount'] = $val['amount'] ;
			$newres['schoolterm'] = $val['schoolterm'] ;
			$newres['schoolsession'] = $val['schoolsession'] ;
			//check is unique
		 	$values = $this->createInsertUpdateArray($this->table_2, $newres, 1);
        	$query = $this->objDb->insertInto($this->table_2)->values($values);
        	$query->execute();
			if($i==0){
			//add admin fee one time only
			$newres['classid'] = $val['classid'] ;
			$newres['schoolid'] = $adminfee['schoolid'] ;
			$newres['title'] = $adminfee['name'] ;
			$newres['amount'] = $adminfee['adminfee'] ;
			$newres['schoolterm'] = $val['schoolterm'] ;
			$newres['schoolsession'] = $val['schoolsession'] ;
			$values = $this->createInsertUpdateArray($this->table_2, $newres, 1);
        	$query = $this->objDb->insertInto($this->table_2)->values($values);
        	$query->execute();
			}
			$i++;
		}
		
	}
	 public function listaccgeneratefee($res = array()) {
        $query = $this->objDb->from($this->table_2)
                ->join('class ON class.id = ' . $this->table_2 . '.classid')
                ->select('class.name as classname')
				 ->select('class.id as classid')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_2 . '.schoolterm')
                ->select('schoolterm.name as termname')
				 ->select('schoolterm.id as termid')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_2 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
				 ->select('schoolsession.id as sessionid')
                ->join('school ON school.id = ' . $this->table_2 . '.schoolid')
                ->select('school.name as schoolname')
                ->where($this->table_2 . '.status = ?', 1)
                ->where($this->table_2 . '.deleted = ?', 0)
				 ->group($this->table_2 . '.schoolterm')
				->group($this->table_2 . '.schoolsession');
				 if (isset($_SESSION['loginSchoolId']) && $_SESSION['loginSchoolId'] != null) {
				  $query->where($this->table_2 . '.schoolid = ?' , $_SESSION['loginSchoolId']);
				 }
        $arView['list'] = $query->fetchAll();
        return $arView;
    }
	//fee template 
	
	  public function listsaccfeetemplate($res = array()) {
        $query = $this->objDb->from($this->table_1)
                ->join('class ON class.id = ' . $this->table_1 . '.classid')
                ->select('class.name as classname')
				 ->select('class.id as classid')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_1 . '.schoolterm')
                ->select('schoolterm.name as termname')
				 ->select('schoolterm.id as termid')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_1 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
				 ->select('schoolsession.id as sessionid')
                ->join('school ON school.id = ' . $this->table_1 . '.schoolid')
                ->select('school.name as schoolname')
                ->where($this->table_1 . '.status = ?', 1)
                ->where($this->table_1 . '.deleted = ?', 0)
               ->group($this->table_1 . '.schoolterm')
				->group($this->table_1 . '.schoolsession');
				 if (isset($_SESSION['loginSchoolId']) && $_SESSION['loginSchoolId'] != null) {
				  $query->where($this->table_1 . '.schoolid = ?' , $_SESSION['loginSchoolId']);
				 }
        $arView['list'] = $query->fetchAll();
        return $arView;
    }
	
    public function viewaccfeetemplateById($res) {
		
       $query = $this->objDb->from($this->table_1)
                ->join('class ON class.id = ' . $this->table_1 . '.classid')
                ->select('class.name as classname')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_1 . '.schoolterm')
                ->select('schoolterm.name as termname')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_1 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
                ->join('school ON school.id = ' . $this->table_1 . '.schoolid')
                ->select('school.name as schoolname')
                ->where($this->table_1 . '.status = ?', 1)
                ->where($this->table_1 . '.deleted = ?', 0)
                ->where($this->table_1 . '.classid = ?', $res['classid'])
				->where($this->table_1 . '.schoolterm = ?', $res['termid'])
				->where($this->table_1 . '.schoolsession = ?', $res['sessionid']);
         $arView['list'] = $query->fetchAll();
		 
		 //get already generated status 
		 $query = $this->objDb->from($this->table_2)
                ->join('class ON class.id = ' . $this->table_2 . '.classid')
                ->select('class.name as classname')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_2 . '.schoolterm')
                ->select('schoolterm.name as termname')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_2 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
                ->join('school ON school.id = ' . $this->table_2 . '.schoolid')
				->where($this->table_2 . '.schoolid = ?', $res['schoolid'])
				->where($this->table_2 . '.classid = ?', $res['classid'])
				->where($this->table_2 . '.schoolterm = ?', $res['termid'])
				->where($this->table_2 . '.schoolsession = ?', $res['sessionid']);
		  $arView['generatedlist'] = $query->fetchAll();

        return $arView;
    }
	 public function accfeetemplateById($id) {
        $query = $this->objDb->from($this->table)
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('id = ?', $id);
        $a = $query->fetchAll();

        return $a['0'];
    }
    public function addaccfeetemplate($res) {
        $values = $this->createInsertUpdateArray($this->table, $res, 1);
        $query = $this->objDb->insertInto($this->table)->values($values);
        return $query->execute();
    }

    public function updateaccfeetemplate($res, $id) {
        $values = $this->createInsertUpdateArray($this->table, $res, 0);
        $query = $this->objDb->update($this->table)->set($values)->where('id', $id);
        return $query->execute();
    }
	//admin Fee 
	 public function adminfeeById($res) {
	 	$schoolid = @$res['schoolid'];
		$a[0] = '';
		if($schoolid){
        $query = $this->objDb->from("adminfeestype")
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('schoolid = ?', $schoolid);
        $a = $query->fetchAll();
		}
        return @$a['0'];
    }

    //class fees 


    public function listsfee($res = array()) {
        $query = $this->objDb->from($this->table_1)
                ->join('feestype ON feestype.id = ' . $this->table_1 . '.type')
                ->select('feestype.name as feesname')
                ->join('class ON class.id = ' . $this->table_1 . '.classid')
                ->select('class.name as classname')
                ->join('schoolterm ON schoolterm.id = ' . $this->table_1 . '.schoolterm')
                ->select('schoolterm.name as termname')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_1 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
                ->join('school ON school.id = ' . $this->table_1 . '.schoolid')
                ->select('school.name as schoolname')
                ->where($this->table_1 . '.status = ?', 1)
                ->where($this->table_1 . '.deleted = ?', 0)
                ->where($this->table . '.deleted = ?', 0);
				 if (isset($_SESSION['loginSchoolId']) && $_SESSION['loginSchoolId'] != null) {
				  $query->where($this->table_1 . '.schoolid = ?' , $_SESSION['loginSchoolId']);
				 }
        $arView['search_name'] = '';
        if (isset($res['name']) && $res['name'] != '') {
            $arView['search_name'] = $res['name'];
            $query->where('name like "%?%"', $res['name']);
        }

        $arView['list'] = $query->fetchAll();
        return $arView;
    }

    public function feeById($id) {
        $query = $this->objDb->from($this->table_1)
                ->where('status = ?', 1)
                ->where('deleted = ?', 0)
                ->where('id = ?', $id);
        $a = $query->fetchAll();
        $ar = $a['0'];
        return $ar;
    }

    public function addfee($res) {
        $values = $this->createInsertUpdateArray($this->table_1, $res, 1);
        $query = $this->objDb->insertInto($this->table_1)->values($values);
        return $query->execute();
    }

    public function updatefee($res, $id) {
        $values = $this->createInsertUpdateArray($this->table_1, $res, 0);
        $query = $this->objDb->update($this->table_1)->set($values)->where('id', $id);
        return $query->execute();
    }

    public function isUniqueFeetype($value, $scap_id = null) {
        return parent::isUnique($this->table, array('name' => $value), $scap_id);
    }

    public function isUniqueClassFees($value, $field, $scap_id = null) {
        return parent::isUnique($this->table_1, array('name' => $value), $scap_id);
    }
	
	public function viewstudentfee($res = array()) {
        $query = $this->objDb->from($this->table_1)
                ->join('feestype ON feestype.id = ' . $this->table_1 . '.type')
                ->select('feestype.name as feesname')
                ->join('class ON class.id = ' . $this->table_1 . '.classid')
                ->select('class.name as classname')
				->join('student ON student.classid = ' . $this->table_1 . '.classid')
                ->select('student.first_name as student_name') 
                ->join('schoolterm ON schoolterm.id = ' . $this->table_1 . '.schoolterm')
                ->select('schoolterm.name as termname')
                ->join('schoolsession ON schoolsession.id = ' . $this->table_1 . '.schoolsession')
                ->select('schoolsession.name as sessionname')
                ->join('school ON school.id = ' . $this->table_1 . '.schoolid')
                ->select('school.name as schoolname')
                ->where($this->table_1 . '.status = ?', 1)
                ->where($this->table_1 . '.deleted = ?', 0)
                ->where($this->table . '.deleted = ?', 0);
				
       if($_SESSION['UTYPE']=='parents'){
                 	$query->where('student.parentid = ?', @$_SESSION['loginedUser']['id']);
				 } else {
				 	$query->where('student.id = ?', @$_SESSION['loginedUser']['id']);
				 } 

        $arView['list'] = $query->fetchAll();
        return $arView;
    }

}
