<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * * Users Model Class
 *
 * @package MajorMarketDeals
 * @subpackage Frontend
 */

class Postsmodel extends CI_Model {

  function getPostparamsList($limit, $start){
		$this->db->select('tbl_feeds.*,tbl_users.*,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_feeds.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares');
  		$this->db->from('tbl_feeds');
		$this->db->join('tbl_users','tbl_feeds.user_id=tbl_users.user_id' );
		$this->db->order_by('created', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$PostparamsListData= $query->result_array();
		return $PostparamsListData;
  
  }
  	public function getPostCount(){
		$this->db->select('tbl_feeds.user_id');
		$this->db->from('tbl_feeds');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$PostCount= $query->num_rows();
		return $PostCount;
	}
	
	function getPostDetails($id){
		$this->db->select('tbl_feeds.*,tbl_users.*,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_feeds.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares');
		$this->db->from('tbl_feeds');
		$this->db->join('tbl_users','tbl_feeds.user_id=tbl_users.user_id' );
		$this->db->where('id',$id);
		$query = $this->db->get();
	//	echo $this->db->last_query();die();
		$PostData= $query->row_array();
		
		 $pYear=date('Y',strtotime($PostData['created']));
		 $pMonth=date('m',strtotime($PostData['created']));
		 
		$this->db->select('tbl_profit.*');
		$this->db->from('tbl_profit');
		$this->db->where('Month',$pMonth); 
		$this->db->where('Year',$pYear); 
		$query = $this->db->get();
		$ProfitData= $query->row_array(); 
		$Post=array();
		return $Post=array_merge($ProfitData,$PostData);
	}
	function getUsershares($id){
		$this->db->select('tbl_share.*,tbl_users.*');
		$this->db->from('tbl_share');
		$this->db->join('tbl_users','tbl_share.user_id=tbl_users.user_id' );
		$this->db->where('feed_id',$id);
		$query = $this->db->get();
		//	echo $this->db->last_query();die();
		return $PostuserListData= $query->result_array();
	}
	
	public function UpdatePost($data,$id){
		$this->db->where('id', $id);
		$updation = $this->db->update('tbl_feeds', $data);

		if($updation){
		return true;
		}else{
		return false;
			}
	}
/* 	public function CreatePost($data){
		$creation = $this->db->insert('tbl_feeds', $data);

		if($creation){
		return true;
		}else{
		return false;
			}
	} */
	 public function saveUserFeed($savefeed) {
        if ($this->db->insert('tbl_feeds', $savefeed)) {
            return true;
        }
        return FALSE;
    }
	
	public function DeleteAllPost($id){
	$this->db->where_in('id', $id);
	$this->db->delete('tbl_feeds');
	}
	 public function getUsersLists() {
     $this->db->select('tbl_users.user_id,tbl_users.user_name');
		$this->db->from('tbl_users');
		$this->db->where('user_status','1');
		$this->db->where('user_type','0');
		$query = $this->db->get();
		//	echo $this->db->last_query();die();
		return $getUsersListstData= $query->result_array();
    }
/* function getmonthlyprofit($id){
				$totalprofit=0;
				$data=array();
				//$this->db->select('tbl_feeds.*,tbl_users.*,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_feeds.id GROUP BY DATE_FORMAT(created, "%Y%m")) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id GROUP BY DATE_FORMAT(created, "%Y%m")) as shares');
				
				$this->db->select('tbl_feeds.*,tbl_users.*,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_feeds.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares');
				$this->db->from('tbl_feeds');
				$this->db->join('tbl_users','tbl_feeds.user_id=tbl_users.user_id' );
				$this->db->where('id',$id);
				$query = $this->db->get();
				$ProfitData= $query->row_array(); 
				
				
				$qry = 'SELECT *,count(id) viewcount FROM `tbl_seen` WHERE `feed_id`='.$ProfitData['id'].' GROUP BY DATE_FORMAT(created, "%Y%m") ';
				$ProfitData['monthscounts'] = $this->db->query($qry)->result_array();
			
				$postcreated =date('Y-m-d',strtotime($ProfitData['created']));
				$today = date('Y-m-d',time());
				
				$pYear=date('Y',strtotime($ProfitData['created']));
				$pMonth=date('m',strtotime($ProfitData['created']));
		 

				$start    = new DateTime($postcreated);
				$start->modify('first day of this month');
				$end      = new DateTime($today);
				$end->modify('first day of next month');
				$interval = DateInterval::createFromDateString('1 month');
				$period   = new DatePeriod($start, $interval, $end);

				$a=0;
	
					foreach ($period as $dt) {
					
					$this->db->select('tbl_profit.*');
					$this->db->from('tbl_profit');
					$this->db->where('Month',$dt->format("m")); 
					$this->db->where('Year',$dt->format("Y")); 
					$this->db->order_by('Year', 'DESC');
					$this->db->order_by('Month', 'DESC');
					$query = $this->db->get();
					$Profitdetails= $query->row_array(); 
					
					
					$Profit= !empty($Profitdetails['Profit'])?$Profitdetails['Profit']:0;
					$Creator= !empty($Profitdetails['Creator'])?$Profitdetails['Creator']:0;
					$Sharer= !empty($Profitdetails['Sharer'])?$Profitdetails['Sharer']:0;
					$Adjustment= !empty($Profitdetails['Adjustment'])?$Profitdetails['Adjustment']:0;
						
					$data['profitdata'][$a]['Month']=$dt->format("m");
					$data['profitdata'][$a]['Year']=$dt->format("Y");
					
					print_r($Profitdetails);
					die;
					
					foreach($ProfitData['monthscounts'] as $Profitcount)
					{
					if(date('m',strtotime($Profitcount['created']))==$Profitdetails['Month'] && date('Y',strtotime($Profitcount['created']))==$Profitdetails['Year'])
					//if(date('m',strtotime($ProfitData['created']))==$data['profitdata'][$a]['Month'] && date('Y',strtotime($ProfitData['created']))==$data['profitdata'][$a]['Year'])
									//if($Profitdetails['Month']==$data['profitdata'][$a]['Month'] && $Profitdetails['Year']==$data['profitdata'][$a]['Year'])
									{
									$data['profitdata'][$a]['monthviews']=@$ProfitData['monthscounts'][$a]['viewcount'];
									}else{
									$data['profitdata'][$a]['monthviews']=0;
									$a++;
									}
					
					$data['profitdata'][$a]['ProfitofCreated']= ((@$data['profitdata'][$a]['monthviews']) * ($Profit) * ($Creator/100) * ($Adjustment/100));
					$data['profitdata'][$a]['ProfitofShared']= ((@$data['profitdata'][$a]['monthviews']) * ($Profit) * ($Sharer/100) * ($Adjustment/100));		
					$data['profitdata'][$a]['totalProfitbymonth']= $data['profitdata'][$a]['ProfitofCreated']+$data['profitdata'][$a]['ProfitofShared'];
					}
				
					$totalprofit =$totalprofit+$data['profitdata'][$a]['totalProfitbymonth'];
					
					$a++;

				
					}
					$data['totalprofit']=$totalprofit;

				return $data;
	}	
	 */
	//backup 27/01/2016 4:55 pm
	
	function getmonthlyprofit($id){
				$totalprofit=0;
				$data=array();
				//$this->db->select('tbl_feeds.*,tbl_users.*,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_feeds.id GROUP BY DATE_FORMAT(created, "%Y%m")) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id GROUP BY DATE_FORMAT(created, "%Y%m")) as shares');
				
				$this->db->select('tbl_feeds.*,tbl_users.*,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_feeds.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares');
				$this->db->from('tbl_feeds');
				$this->db->join('tbl_users','tbl_feeds.user_id=tbl_users.user_id' );
				$this->db->where('id',$id);
				$query = $this->db->get();
				$ProfitData= $query->row_array(); 
				
				
				$qry = 'SELECT *,count(id) viewcount FROM `tbl_seen` WHERE `feed_id`='.$ProfitData['id'].' GROUP BY DATE_FORMAT(created, "%Y%m") ';
				$ProfitData['monthscounts'] = $this->db->query($qry)->result_array();
			
				$postcreated =date('Y-m-d',strtotime($ProfitData['created']));
				$today = date('Y-m-d',time());
				
				$pYear=date('Y',strtotime($ProfitData['created']));
				$pMonth=date('m',strtotime($ProfitData['created']));
		 

				$start    = new DateTime($postcreated);
				$start->modify('first day of this month');
				$end      = new DateTime($today);
				$end->modify('first day of next month');
				$interval = DateInterval::createFromDateString('1 month');
				$period   = new DatePeriod($start, $interval, $end);

				$a=0;
	
					foreach ($period as $dt) {
					
					$this->db->select('tbl_profit.*');
					$this->db->from('tbl_profit');
					$this->db->where('Month',$dt->format("m")); 
					$this->db->where('Year',$dt->format("Y")); 
					$this->db->order_by('Year', 'DESC');
					$this->db->order_by('Month', 'DESC');
					$query = $this->db->get();
					$Profitdetails= $query->row_array(); 
					
					
					$Profit= !empty($Profitdetails['Profit'])?$Profitdetails['Profit']:0;
					$Creator= !empty($Profitdetails['Creator'])?$Profitdetails['Creator']:0;
					$Sharer= !empty($Profitdetails['Sharer'])?$Profitdetails['Sharer']:0;
					$Adjustment= !empty($Profitdetails['Adjustment'])?$Profitdetails['Adjustment']:0;
						
					$data['profitdata'][$a]['Month']=$dt->format("m");
					$data['profitdata'][$a]['Year']=$dt->format("Y");
					
									//if(date('m',strtotime($ProfitData['created']))==$data['profitdata'][$a]['Month'] && date('Y',strtotime($ProfitData['created']))==$data['profitdata'][$a]['Year'])
									if($Profitdetails['Month']==$data['profitdata'][$a]['Month'] && $Profitdetails['Year']==$data['profitdata'][$a]['Year'])
									{
									$data['profitdata'][$a]['monthviews']=@$ProfitData['monthscounts'][$a]['viewcount'];
									}else{
									$data['profitdata'][$a]['monthviews']=0;
									$a++;
									}
					
					$data['profitdata'][$a]['ProfitofCreated']= ((@$data['profitdata'][$a]['monthviews']) * ($Profit) * ($Creator/100) * ($Adjustment/100));
					$data['profitdata'][$a]['ProfitofShared']= ((@$data['profitdata'][$a]['monthviews']) * ($Profit) * ($Sharer/100) * ($Adjustment/100));		
					$data['profitdata'][$a]['totalProfitbymonth']= $data['profitdata'][$a]['ProfitofCreated']+$data['profitdata'][$a]['ProfitofShared'];
					
				
					$totalprofit =$totalprofit+$data['profitdata'][$a]['totalProfitbymonth'];
					
					$a++;

				
					}
					$data['totalprofit']=$totalprofit;

				return $data;
	}	 
	
}

?>