<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * * Users Model Class
 *
 * @package MajorMarketDeals
 * @subpackage Frontend
 */

class Profitsmodel extends CI_Model {

	public function getProfitparamsList(){
		$this->db->select('tbl_profit.*');
		$this->db->from('tbl_profit');
		
				$this->db->order_by('Year', 'DESC');
					$this->db->order_by('Month', 'DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$PostparamsListData= $query->result_array();
		return $PostparamsListData;
	}
	
	public function save_profit_params(){
				$this->db->select('tbl_profit.id');
				$this->db->from('tbl_profit');
				$this->db->where('Month', $_POST['Month']);
				$this->db->where('Year', $_POST['Year']);
				$query = $this->db->get();
				$ProfileDetailsData= $query->row_array();
		If($ProfileDetailsData>0){
		
		}	else{
		$this->db->insert('tbl_profit', $_POST);
		echo 1;
		}

	}
	
		public function save_profit_edit_params(){
		$this->db->where('id',$_POST['id']);
		$updated=$this->db->update('tbl_profit', $_POST);
					if($updated){
						echo 1;
					}else{
						echo 0; 
					}
		}
	
	public function get_profit_values($id){
				
				$this->db->select('tbl_profit.*');
				$this->db->from('tbl_profit');
				$this->db->where('id', $id);
				$query =$this->db->get();
				$ProfileDetailsData = $query->row_array();
				echo 	json_encode($ProfileDetailsData);				
	}
	
	
}

?>