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
        $this->db->where('user_id=' . $user_id);
        $this->db->where('feed_id=' . $feed_id);
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
        $where = "(tbl_feeds.created>= '" . date("Y-m-d H:i:s", strtotime('-24 hours', time())) . "' && tbl_feeds.created<= '" . date('Y-m-d H:i:s') . "')";
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
        $where = "(tbl_feeds.created>= '" . date("Y-m-d H:i:s", strtotime('-24 hours', time())) . "' && tbl_feeds.created<= '" . date('Y-m-d H:i:s') . "')";
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

    public function updateFeed($update_array, $where_array, $table_name) {
        $this->db->where($where_array);
        return $this->db->update($table_name, $update_array);
    }

    public function getUserFeedData($feed_id) {
        $this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount');
        $this->db->from('tbl_feeds');
        $this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
        $this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
        $where = '(tbl_feeds.id =' . $feed_id . ')';
        $this->db->where($where);
        $this->db->group_by('tbl_feeds.id');
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        $queryData = $query->row_array();
        return $queryData;
    }

    public function getUserFeeds($user_id, $skip, $limit) {
        $this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount');
        $this->db->from('tbl_feeds');
        $this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
        $this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
        $where = '(tbl_feeds.user_id =' . $user_id . ')';
        $this->db->where($where);
        $this->db->group_by('tbl_feeds.id');
        $this->db->order_by("tbl_feeds.created", "desc");
        $this->db->limit($limit, $skip);
        $query = $this->db->get();
        // echo $this->db->last_query();die();
        $queryData = $query->result_array();
        return $queryData;
    }

    public function deleteUserFeed($feed_id) {
        $this->db->delete('tbl_seen', array('feed_id' => $feed_id));
        return $this->db->delete('tbl_feeds', array('id' => $feed_id));
    }

    public function getAllFeeds() {
        $this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount');
        $this->db->from('tbl_feeds');
        $this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
        $this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
        $this->db->group_by('tbl_feeds.id');
        $query = $this->db->get();
        // echo $this->db->last_query();die();
        $queryData = $query->result_array();
        return $queryData;
    }

    public function checkPaypalInfo($user_id) {
        $this->db->select('*');
        $this->db->from('tbl_paypal');
        $this->db->where("user_id=" . $user_id);
        $query = $this->db->get();
        // echo $this->db->last_query();die();
        if ($query->num_rows() > 0)
            return $query->row_array();
        else
            return false;
    }

    public function saveInfo($insertArray, $table_name) {
        $this->db->insert($table_name, $insertArray);
        return $this->db->insert_id();
    }

    public function checkShareUser($user_id, $feed_id) {
        $this->db->select('*');
        $this->db->from('tbl_share');
        $this->db->where("user_id='" . $user_id . "' && feed_id='" . $feed_id . "'");
        $query = $this->db->get();
        // echo $this->db->last_query();die();
        if ($query->num_rows() > 0)
            return $query->num_rows();
        else
            return false;
    }

    public function getAllUserCreatedFeedsByMonth($user_id) {
        $this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount');
        $this->db->from('tbl_feeds');
        $this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
        $this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
        $this->db->where("tbl_feeds.user_id='" . $user_id . "' && (tbl_feeds.created BETWEEN '" . date('Y-m-1 00:00:00') . "' AND '" . date('Y-m-d H:i:s') . "') ");
        $this->db->group_by('tbl_feeds.id');
        $query = $this->db->get();
        // echo $this->db->last_query();die(); 
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    public function getAllUserSharedFeedsByMonth($user_id) {

        $this->db->select('tbl_feeds.*, COUNT(tbl_seen.id) as viewcount');
        $this->db->from('tbl_share');
        $this->db->join('tbl_feeds', 'tbl_feeds.id = tbl_share.feed_id', 'left');
        $this->db->join('tbl_seen', 'tbl_seen.feed_id = tbl_share.feed_id', 'left');
        $this->db->where("tbl_share.user_id='" . $user_id . "' && (tbl_share.created BETWEEN '" . date('Y-m-1 00:00:00') . "' AND '" . date('Y-m-d H:i:s') . "') && tbl_feeds.user_id!='" . $user_id . "' ");
        $this->db->group_by('tbl_share.id');
        $query = $this->db->get();
        // echo $this->db->last_query();die(); 
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }
	
	public function getUserFeedsByMonth($user_id, $first_day_this_month, $last_day_this_month){
		$this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares, tbl_profit.*');
		$this->db->from('tbl_feeds');
		$this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
		$this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
		$this->db->join('tbl_profit', 'tbl_profit.Year = DATE_FORMAT(tbl_feeds.created, "%Y") and tbl_profit.Month = DATE_FORMAT(tbl_feeds.created,"%m")','left');
		$where = '(tbl_feeds.user_id ='.$user_id.' and tbl_feeds.created >= "'.$first_day_this_month.'" and tbl_feeds.created <= "'.$last_day_this_month.'")';
		$this->db->where($where);
		$this->db->group_by('tbl_feeds.id');
		$query = $this->db->get();
		 // echo $this->db->last_query();die();
		$queryData= $query->result_array();
		return $queryData;
	}

	
		public function getUserFeedsAllMonth($user_id){
		$this->db->select('tbl_feeds.*,tbl_users.user_name, COUNT(tbl_seen.id) as viewcount, (SELECT count(`id`) FROM `tbl_share` WHERE `feed_id`=tbl_feeds.id) as shares, tbl_profit.*');
		$this->db->from('tbl_feeds');
		$this->db->join('tbl_seen', 'tbl_feeds.id = tbl_seen.feed_id', 'left');
		$this->db->join('tbl_users', 'tbl_feeds.user_id = tbl_users.user_id', 'left');
		$this->db->join('tbl_profit', 'tbl_profit.Year = DATE_FORMAT(tbl_feeds.created, "%Y") and tbl_profit.Month = DATE_FORMAT(tbl_feeds.created,"%m")','left');
		$where = '(tbl_feeds.user_id ='.$user_id.')';
		$this->db->where($where);
		$this->db->group_by('tbl_feeds.id');
		$query = $this->db->get();
		 // echo $this->db->last_query();die();
		$queryData= $query->result_array();
		return $queryData;
	}
	public function  getUserSharesAllMonth($user_id){
			$this->db->select('count(tbl_share.feed_id) as shares  ,tbl_users.user_name,(SELECT count(`id`) FROM `tbl_seen` WHERE `feed_id`=tbl_share.feed_id) as viewcount, tbl_feeds.*, tbl_profit.Profit, tbl_profit.Creator, tbl_profit.Sharer, tbl_profit.Adjustment, tbl_profit.Number_of_Sharers, tbl_profit.Month, tbl_profit.Year');
			$this->db->from('tbl_share');
			$this->db->join('tbl_users', 'tbl_share.user_id = tbl_users.user_id');
			$this->db->join('tbl_feeds', 'tbl_feeds.id = tbl_share.feed_id');
			$this->db->join('tbl_profit', 'tbl_profit.Year = DATE_FORMAT(tbl_feeds.created, "%Y") and tbl_profit.Month = DATE_FORMAT(tbl_feeds.created,"%m")','left');
			$this->db->where('tbl_share.user_id',$user_id);
			$this->db->group_by('tbl_share.feed_id');
			$query = $this->db->get();
			//echo $this->db->last_query();die();
			return $PostuserListData= $query->result_array();
	}
	public function  getUserallPayments($user_id){
		$this->db->select('sum(tbl_payments.payment) as payment ');
			$this->db->from('tbl_payments');
			$this -> db -> where('tbl_payments.user_id',$user_id);
			$query = $this->db->get();
			return $UserDetailsDatapayment= $query->result_array();
	}
//    public function getTotalViewcount($first_day_this_month, $last_day_this_month, $user_id) {
//        $this->db->select('*');
//        $this->db->from('tbl_seen');
//        $this->db->where('created <', $last_day_this_month);
//        $this->db->where('created >', $first_day_this_month);
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get();
//       // echo $this->db->last_query();die();
//        if ($query->num_rows() > 0)
//            return $query->result_array();
//        else
//            return false;
//    }

}

?>