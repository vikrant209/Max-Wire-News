<?php

use PFBC\Form;
use PFBC\Element;
use PFBC\View;
use PFBC\View\SideBySide;

/**
 * Description of AccountController
 *
 * @author Mahesh
 */
class AccountController extends CommonController {

    function addAction($res) {
        if ($this->isPost()) {
            $isUnique = $this->objModel->isUniqueFeetype($res['name'], null);
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Fee Title should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $this->objModel->add($res);
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
            $isUnique = $this->objModel->isUniqueFeetype($res['name'], array('id' => $res['id']));

            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Fee Title should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            return $this->objModel->update($res, $res['id']);
        }
        $ar['fee'] = $this->objModel->feetypeById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }
	//Fees template 
	
	function addaccfeetemplateAction($res) {
        if ($this->isPost()) {
            $isUnique = $this->objModel->isUniqueFeetype($res['name'], null);
            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Fee Title should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            $this->objModel->addaccfeetemplate($res);
        }
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }

    function viewaccfeetemplateAction($res) {
		$ar['generate']= $res['generate'];
       	$ar['fee'] = $this->objModel->viewaccfeetemplateById($res);
        $ar['ddschool'] = $this->schoolDropDownArray();
		$ar['adminfee'] = $this->objModel->adminfeeById($res);
		
        return $ar;  
    }
	  function viewfeetempAction($res) {
		$ar['generate']= $res['generate'];
       	$ar['fee'] = $this->objModel->viewfeetempById($res);
        $ar['ddschool'] = $this->schoolDropDownArray();
		$ar['adminfee'] = $this->objModel->adminfeeById($res);
        return $ar;  
    }

    function listaccfeetemplateAction($res) {
        return $this->objModel->listsaccfeetemplate($res);
    }

    function deleteaccfeetemplateAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updateaccfeetemplate($res, $res['id']);
    }

    function editaccfeetemplateAction($res) {
        if ($this->isPost()) {
            $isUnique = $this->objModel->isUniqueFeetype($res['name'], array('id' => $res['id']));

            if (!Form::isValid($res['form']) || !$isUnique) {
                if (!$isUnique) {
                    header("Content-type: application/json");
                    echo '{"errors":["Error: Fee Title should be unique."]}';
                    exit();
                }
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            return $this->objModel->updateaccfeetemplate($res, $res['id']);
        }
        $ar['fee'] = $this->objModel->accfeetemplateById($res['id']);
        $ar['ddschool'] = $this->schoolDropDownArray();
        return $ar;
    }
	//payment slip for parents
	function listaccparentsfeeslipsAction($res)
	{
	 	if(!empty($res['student'])){
		$ar['student']= $res['student'];
		$ar['schoolterm']= $res['schoolterm'];
		$ar['schoolsession']= $res['schoolsession'];
		$ar['fee'] = $this->objModel->getstudentfeeById($res);
       	$ar['paymentfee'] = $this->objModel->getfeepaymentbyId($res);
		$ar['paynow']= $res['paynow'];
		}
        
		$ar['arrstudent'] = $this->objModel->getstudentbyparent($res); //$this->studentDropDownArray();
		$ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        return $ar;  
	}
	//Payment Slip
	function listaccpayslipsAction($res)
	{
	 	if(!empty($res['student'])){
		$ar['student']= $res['student'];
		$ar['schoolterm']= $res['schoolterm'];
		$ar['schoolsession']= $res['schoolsession'];
		$ar['fee'] = $this->objModel->getstudentfeeById($res);
       	$ar['paymentfee'] = $this->objModel->getfeepaymentbyId($res);
		
		}
        
		$ar['arrstudent'] = $this->studentDropDownArray();
		$ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        return $ar;  
	}
	//make payment
	 function listaccsetpaymentAction($res) {
	 	
        $ar['arrstudent'] = $this->studentDropDownArray();
		$ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        return $ar;  
    }
	function getpayslipAction($res)
	{
	 	$ar['paynow']= $res['paynow'];
		$ar['adddisc']= $res['adddisc'];
		$ar['student']= $res['student'];
		$ar['schoolterm']= $res['schoolterm'];
		$ar['schoolsession']= $res['schoolsession'];
		$ar['saletype']= $res['saletype'];
		if($ar['saletype']==1){
				$this->objModel->makefeepayment($res);
		}
		if($ar['saletype']==2){
				$this->objModel->makefeepayment($res);
		}
		$ar['fee'] = $this->objModel->getstudentfeeById($res);
       	$ar['paymentfee'] = $this->objModel->getfeepaymentbyId($res);
		
        $ar['arrstudent'] = $this->studentDropDownArray();
		$ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        return $ar;  
	}
	
	//discount 
	 function listaccrebateAction($res) {
	 if(isset($res['adddisc'])){
			$ar['paynow']= $res['paynow'];
			$ar['adddisc']= $res['adddisc'];
			$ar['student']= $res['student'];
			$ar['schoolterm']= $res['schoolterm'];
			$ar['schoolsession']= $res['schoolsession'];
			$ar['saletype']= $res['saletype'];
			if($ar['saletype']==1){
					$this->objModel->makefeepayment($res);
			}
			if($ar['saletype']==2){
					$this->objModel->makefeepayment($res);
			}
		}
		$ar['fee'] = $this->objModel->getstudentfeeById($res);
       	$ar['paymentfee'] = $this->objModel->getfeepaymentbyId($res);
        $ar['arrstudent'] = $this->studentDropDownArray();
		$ar['arrterm'] = $this->schooltermDropDownArray();
        $ar['arrsession'] = $this->schoolsessionDropDownArray();
        return $ar;  
    }
	//generate fee 
	
	 function listaccgeneratefeeAction($res) {
        return $this->objModel->listaccgeneratefee($res);
    }
	 function generateAction($res) {
	 	$adminfee = $this->objModel->adminfeeById($res);
	 	$list = $this->objModel->viewaccfeetemplateById($res);
        return $this->objModel->generateclastermfee($list,$adminfee);
    }
    //fees class 
    function addfeeAction($res) {
        $feetype = $this->objModel->dropdownarray('feestype', 'id', 'name');
        $schoolterm = $this->objModel->dropdownarray('schoolterm', 'id', 'name');
        $schoolsession = $this->objModel->dropdownarray('schoolsession', 'id', 'name');
        $class = $this->objModel->dropdownarray('class', 'id', 'name');
        $school = $this->objModel->dropdownarray('school', 'id', 'name');

        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            return $this->objModel->addfee($res);
        }
        return $view = array('feetype' => $feetype, 'arrschoolterm' => $schoolterm, 'arrschoolsession' => $schoolsession, 'arrschool' => $school, 'arrclass' => $class);
    }

    function viewfeeAction() {
        
    }

    function listfeeAction($res) {
        return $this->objModel->listsfee($res);
    }

    function deletefeeAction($res) {
        $res['deleted'] = 1;
        return $this->objModel->updatefee($res, $res['id']);
    }

    function editfeeAction($res) {
        $feetype = $this->objModel->dropdownarray('feestype', 'id', 'name');
        $schoolterm = $this->objModel->dropdownarray('schoolterm', 'id', 'name');
        $schoolsession = $this->objModel->dropdownarray('schoolsession', 'id', 'name');
        $class = $this->objModel->dropdownarray('class', 'id', 'name');
        $school = $this->objModel->dropdownarray('school', 'id', 'name');
        if ($this->isPost()) {
            if (!Form::isValid($res['form'])) {
                Form::renderAjaxErrorResponse($res['form']);
                exit();
            }
            return $this->objModel->updatefee($res, $res['id']);
        }
        $classfee = $this->objModel->feeById($res['id']);
        return array('feetype' => $feetype, 'arrschoolterm' => $schoolterm, 'arrschoolsession' => $schoolsession, 'arrclass' => $class, 'arrschool' => $school, 'classfee' => $classfee);
    }
	
	 function viewstudentfeeAction($res) {       
        return $this->objModel->viewstudentfee($res);
    }


}

//Comments for test