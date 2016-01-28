<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paymentsmodel extends CI_Model {

  function sendpayment($data){
				$pay = $this->db->insert('tbl_payments', $data);
							if($pay){
							return true;
							}else{
							return false;
								}
  }
 
	
	
}

?>