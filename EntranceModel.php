<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntranceModel
 *
 * @author deepak
 */
class EntranceModel  extends CommonModel {
   
    public function application($res) {
        $q = $this->objDb->getPdo()->prepare("DESCRIBE entrance_application");
        $q->execute();
        $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);

        $values = array();
        foreach ($res as $key => $val) {
            if (in_array($key, $table_fields)) {
                $values[$key] = $val;
            }
        }
        
        $query = $this->objDb->insertInto('entrance_application')->values($values);
        $return = $query->execute();
		echo "Your Application No: ". $return;
		echo "<br><br>Please Note this Application Number. Please Make Payment Request under Application Status : <a href='http://skolasuite.com/entrance.php'>http://skolasuite.com/entrance.php</a> ";
	   die;
    }
    
    public function session($sid){
        $query = $this->objDb->from('schoolsession')
                        ->where('status = ?', 1)
                        ->where('deleted = ?', 0)
                        ->where('schoolid = ?', $sid);
        $arr = array();
        $i = 0;
        foreach ($query as $row) {
            $arr[$i]['id'] = $row['id'];
            $arr[$i]['name'] = $row['name'];
            $i++;
        }
        return $arr;
    }
    
    public function status($apno)
    {
       // $sql = "SELECT appstatus FROM entrance_application where id=".$apno;
	    $sql = "SELECT  bp.ReceiptNo as ReceiptNo,bp.PaymentLogId as PaymentLogId, bp.PaymentStatus as PaymentStatus,bp.type as trantype,ea.appstatus,cf.classid,cf.amount
				FROM entrance_application AS ea
				LEFT JOIN bankpayment bp ON bp.transactionno= ea.id
				JOIN classfees cf ON ea.applied_class = cf.classid
				JOIN class cl ON ea.applied_class = cl.id where ea.id=".$apno;	
        $q = $this->objDb->getPdo()->prepare($sql);
        $q->execute();
        $ar = $q->fetchAll();
		if(!empty($ar)){
			//print_r($ar);die;
        	return $ar[0];
		}else
		{
			return '';
		}
    }
}
