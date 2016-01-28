<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * * Users Model Class
 *
 * @package MajorMarketDeals
 * @subpackage Frontend
 */

class Usersmodel extends CI_Model {

    /**
     * @ Function Name		: checkUserDeviceDetail
     * @ Function Purpose 	: check the user device details are already saved or not
     * @ Function Returns	: 
     */
    public function checkUserDeviceDetail($user_id, $user_deviceToken) {
        $username = $this->input->post('txtUserName');
        $password = $this->input->post('txtPassword');
        $this->db->where('user_id', $user_id);
        $this->db->where('user_deviceToken', $user_deviceToken);
        $device_details = $this->db->get('tbl_devices')->row();
        return $device_details;
    }

    /**
     * @ Function Name		: getUserDetailBySocialId
     * @ Function Purpose 	: get the detail of user as per username
     * @ Function Returns	: array
     */
    public function getUserDetailBySocialId($user_social_id) {
        if (empty($user_social_id)) {
            return FALSE;
        }
        $this->db->where('user_social_id', $user_social_id);
        $user_details = $this->db->get('tbl_users')->row();
        return $user_details;
    }

    /**
     * @ Function Name		: getUserDetailbyEmail
     * @ Function Purpose 	: get the detail of user as per email
     * @ Function Returns	: array
     */
    public function getUserDetailbyEmail() {
        $email = $this->input->post('recovery_email');
        $this->db->where('usrEmail', $email);
        $result = $this->db->get('tbl_users');
        $user_details = $result->row();
        return $user_details;
    }

    /**
     * @ Function Name		: getUserDetailbyusrId
     * @ Function Purpose 	: get the detail of user as per user Id
     * @ Function Returns	: array
     */
    public function getUserDetailbyId() {
        $userId = $this->session->userdata('uid');
        $this->db->where('usrId', $userId);
        $result = $this->db->get('tbl_users');
        //echo $this->db->last_query();
        $user_detailsbyId = $result->row();
        return $user_detailsbyId;
    }

    /**
     * @ Function Name		: registerUser
     * @ Function Purpose 	: add the new user deatails in database
     * @ Function Returns	: integer
     */
    public function registerUser() {
        $return = FALSE;
        // echo '<pre>'; print_r($_POST); die;
        $user_fname = !empty($this->input->post('user_fname')) ? $this->input->post('user_fname') : '';
        $user_lname = !empty($this->input->post('user_lname')) ? $this->input->post('user_lname') : '';
        $user_email = !empty($this->input->post('user_email')) ? $this->input->post('user_email') : '';
        $user_gender = !empty($this->input->post('user_gender')) ? $this->input->post('user_gender') : '';
        $user_loginType = !empty($this->input->post('user_loginType')) ? $this->input->post('user_loginType') : '';
        $user_name = '';
        if (!empty($user_fname))
            $user_name = $user_fname . ' ' . $user_lname;
        $data = array(
            'user_social_id' => $this->input->post('user_social_id'),
            'user_email' => $user_email,
            'user_fname' => $user_fname,
            'user_lname' => $user_lname,
            'user_name' => $user_name,
            'user_accessToken' => md5($user_email . time()),
            'user_gender' => $user_gender,
            // 'user_deviceType' => $this->input->post('user_deviceType'),
            // 'user_deviceToken' => $this->input->post('user_deviceToken'),
            'user_loginType' => $user_loginType,
            'user_dateCreated' => date('Y-m-d H:i:s'),
        );
        if ($this->db->insert('tbl_users', $data)) {
            $return = $this->db->insert_id();
        }
        return $return;
    }

    /**
     * @ Function Name		: saveUserDeviceDetail
     * @ Function Purpose 	: add the user device details in database
     * @ Function Returns	: integer
     */
    public function saveUserDeviceDetail($user_id, $user_deviceToken, $user_deviceType) {
        $return = FALSE;
        $data = array(
            'user_id' => $user_id,
            'user_deviceToken' => $user_deviceToken,
            'user_deviceType' => $user_deviceType,
        );
        if ($this->db->insert('tbl_devices', $data)) {
            $return = $this->db->insert_id();
        }
        return $return;
    }

    /**
     * @ Function Name		: updateUniqueCode
     * @ Function Purpose 	: update the unique code of user
     * @ Function Returns	: boolean
     */
    public function updateUniqueCode($code, $user_id) {
        $where = array('usrId' => $user_id);
        $update_array = array('usrUniqueCode' => $code);
        if ($this->db->update('tbl_users', $update_array, $where)) {
            return TRUE;
        }
        return FALSE;
    }

    /* rajeev code */

    public function saveUserFeed($savefeed) {
        if ($this->db->insert('tbl_feeds', $savefeed)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function isFacebookIdExist($user_social_id) {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where(array('user_social_id' => $user_social_id));
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function saveUserDeviceInformation($device_info) {
        $this->db->insert('tbl_devices', $device_info);
    }

    public function deleteDeviceId($user_deviceToken) {
        $this->db->delete('tbl_devices', array('user_deviceToken' => $user_deviceToken));
        return TRUE;
    }

    public function saveUserInformation($user_info) {
        $this->db->insert('tbl_users', $user_info);
        return $this->db->insert_id();
    }

    public function getUserInfoById($user_id) {
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where(array('user_id' => $user_id));
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getDeviceToken($user_deviceToken) {
        $this->db->select('*');
        $this->db->from('tbl_devices');
        $this->db->where(array('user_deviceToken' => $user_deviceToken));
        $query = $this->db->get();
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function logout($user_deviceToken) {
        if ($this->db->delete('tbl_devices', array('user_deviceToken' => $user_deviceToken))) {
            return true;
        } else {
            return false;
        }
    }

    public function checkTime($user_id, $feed_id) {
        $this->db->select('*');
        $this->db->from('tbl_seen');
        $this->db->where('user_id='.$user_id);       
        $this->db->where('feed_id='.$feed_id);       
        $this->db->order_by("id", "desc");
		$this->db->limit(1, 0);
        $query = $this->db->get();
		// echo $this->db->last_query();
		// die;
        if ($query->num_rows()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function saveFeedSeen($seenArray) {
        $this->db->insert('tbl_seen', $seenArray);
        return $this->db->insert_id();
    }

    public function getLatestFeed($skip, $limit) {
        $this->db->select('tbl_feeds.*,tbl_users.user_name');
        $this->db->from('tbl_feeds');
		$this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
		$where= "(tbl_feeds.created> '".DATE('Y-m-d 00:00:00')."' && tbl_feeds.created< '".DATE('Y-m-d H:i:s')."')";
		$this->db->where($where);
        $this->db->order_by("tbl_feeds.created", "desc");
        $this->db->limit($limit, $skip);
        $query = $this->db->get();
		// echo $this->db->last_query();
		// die;
        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return (array) null;
        }
    }

    public function getSeenCount($feed_id) {
        $this->db->select('*');
        $this->db->from('tbl_seen');
        $this->db->where(array('feed_id' => $feed_id));
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function mostViewedFeed($skip, $limit) {
        $this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount');
		$this->db->from('tbl_feeds');
		$this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
		$this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
		$where= "(tbl_feeds.created> '".DATE('Y-m-d 00:00:00')."' && tbl_feeds.created< '".DATE('Y-m-d H:i:s')."')";
		$this->db->where($where);
        $this->db->group_by('tbl_feeds.id');
        $this->db->order_by('viewcount', 'desc');
		$this->db->limit($limit, $skip);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return (array) null;
        }
        	 
		
    }
	
	public function updateFeed($update_array,$where_array,$table_name){
		$this->db->where($where_array);
		return $this->db->update($table_name,$update_array);
	}
	
	public function getUserFeedData($feed_id){
		$this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount');
		$this->db->from('tbl_feeds');
		$this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
		$this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
		$where = '(tbl_feeds.id ='.$feed_id.')';
		$this->db->where($where);
		$this->db->group_by('tbl_feeds.id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$queryData= $query->row_array();
		return $queryData;
	}
	
	public function getUserFeeds($user_id){
		$this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares,  tbl_profit.Profit, tbl_profit.Creator, tbl_profit.Sharer, tbl_profit.Adjustment, tbl_profit.Number_of_Sharers, tbl_profit.Month, tbl_profit.Year');
		$this->db->from('tbl_feeds');
		$this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
		$this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
		$this->db->join('tbl_profit', 'tbl_profit.Year = DATE_FORMAT(tbl_feeds.created, "%Y") and tbl_profit.Month = DATE_FORMAT(tbl_feeds.created,"%m")','left');
		$where = '(tbl_feeds.user_id ='.$user_id.')';
		$this->db->where($where);
		$this->db->group_by('tbl_feeds.id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$queryData= $query->result_array();
		return $queryData;
	}
	
	public function deleteUserFeed($feed_id){
		$this->db->delete('tbl_seen', array('feed_id' => $feed_id)); 
		return $this->db->delete('tbl_feeds', array('id' => $feed_id)); 
	}
	
	public function getUserData($email,$password){
		$this->db->select('tbl_users.*');
		$this->db->from('tbl_users');
		$this -> db -> where('user_email', $email);
		$this -> db -> where('user_password', MD5($password));
		 $this -> db -> limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$queryData= $query->row_array();
		return $queryData;
	}
	
	public function getUserList($limit, $start){
		$this->db->select('tbl_users.*');
		$this->db->from('tbl_users');
		$this -> db -> where('user_type',0);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$UserListData= $query->result_array();
		return $UserListData;
	}
	
		public function UsersCount(){
		$this->db->select('tbl_users.user_id');
		$this->db->from('tbl_users');
		$this -> db -> where('user_type',0);
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$UserListcount= $query->num_rows();
		return $UserListcount;
	}
	
	public function UpdateUserStatus($id,$status){
	
	if($status==0){$newStatus='1'; }
	elseif($status==1){$newStatus='0'; }
	
	$data = array(
               'user_status' => $newStatus       
            );
	$this->db->where('user_id', $id);
	$this->db->update('tbl_users', $data);
	}
	public function DeleteUser($id){
	$this->db->where('user_id', $id);
	$this->db->delete('tbl_users');
	$this->db->where('user_id', $id);
	$this->db->delete('tbl_paypal');
	
	}
		public function DeleteAllUser($id){
		$this->db->where_in('user_id', $id);
		$this->db->delete('tbl_users');
		$this->db->where_in('user_id', $id);
		$this->db->delete('tbl_paypal');
	}
	public function getUserDetails($id){
		$this->db->select('tbl_users.*,sum(tbl_payments.payment) as payment , tbl_paypal.paypal_email');
		$this->db->from('tbl_users');
		$this->db->join('tbl_paypal', 'tbl_paypal.user_id = tbl_users.user_id','LEFT');
		$this->db->join('tbl_payments', 'tbl_users.user_id = tbl_payments.user_id','LEFT');
		$this -> db -> where('tbl_users.user_id',$id);
		$query = $this->db->get();
	//	echo $this->db->last_query();die();
			$UserDetailsData= $query->row_array();
		
		
			$this->db->select('tbl_payments.*');
			$this->db->from('tbl_payments');
			$this -> db -> where('tbl_payments.user_id',$id);
			$query = $this->db->get();
			$UserDetailsData['payments']= $query->result_array();
		
		return $UserDetailsData;
	}
	public function getPostshares($id){
			$this->db->select('count(tbl_share.feed_id) as shares  ,tbl_users.user_name,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_share.feed_id) as viewcount, tbl_feeds.*, tbl_profit.Profit, tbl_profit.Creator, tbl_profit.Sharer, tbl_profit.Adjustment, tbl_profit.Number_of_Sharers, tbl_profit.Month, tbl_profit.Year');
			$this->db->from('tbl_share');
			$this->db->join('tbl_users', 'tbl_share.user_id = tbl_users.user_id');
			$this->db->join('tbl_feeds', 'tbl_feeds.id = tbl_share.feed_id');
			$this->db->join('tbl_profit', 'tbl_profit.Year = DATE_FORMAT(tbl_feeds.created, "%Y") and tbl_profit.Month = DATE_FORMAT(tbl_feeds.created,"%m")','left');
			$this->db->where('tbl_share.user_id',$id);
			$this->db->group_by('tbl_share.feed_id');
			$query = $this->db->get();
			//echo $this->db->last_query();die();
				return $PostuserListData= $query->result_array();
	}
	
		public function UpdateUser($data,$data2,$id){
		$this->db->where('user_id', $id);
		$updation = $this->db->update('tbl_users', $data);
		
		$this->db->where('user_id', $id);
		$updation2 = $this->db->update('tbl_paypal', $data2);
		
		if($updation && $updation2){
		return true;
		}else{
		return false;
			}
	}
	
		public function CreateUser($data,$data2){
		$creating1 = $this->db->insert('tbl_users', $data);
		
		if($creating1){
							$id=$this->db->insert_id();
							$datapaypal=array(
							'user_id'=>$id,
							'paypal_email'=>$data2['paypal_email'],
							'created_date'=>date("Y-m-d H:i:s"),
							'updated_date'=>date("Y-m-d H:i:s")
							);
							$creating2 = $this->db->insert('tbl_paypal', $datapaypal);
							if($creating1 && $creating2){
							return true;
							}else{
							return false;
								}
		}
	}
	
	
}  

?>