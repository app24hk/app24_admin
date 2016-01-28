<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * * Users Model Class
 *
 * @package MajorMarketDeals
 * @subpackage Frontend
 */

class Profitmodel extends CI_Model 
{
	public function getProfitParams()
	{
		$year= date('Y');
		$month= date('m');
		$this->db->select('*');
		$this->db->from('tbl_profit');
		$where= "Month='".$month."' && Year='".$year."'";
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows()>0)
            return $query->row_array();
        else
            return false;
        
	}
}

?>