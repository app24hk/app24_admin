<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	protected $client = '';
	public function __construct() {
        parent::__construct();
		$this->load->model('Admin/Users/Usersmodel');
	//	if (!$this->isLogged()) {
     //       redirect(base_url('admin'));
     //   }
       // $this->client = CI_Neo4j::get();  
		    
    }


	public function index()
	{				
	if(isset($_GET['per_page']) && $_GET['per_page']!=''){
	$page=$_GET['per_page'];
	}else{$page=0;}
		if($this->session->userdata('logged_in'))
			{
			$data=array();
		
			$this->load->library('pagination');
			$config['base_url'] = base_url('admin/user');
			$config['total_rows'] = $this->Usersmodel->UsersCount();
			$config['per_page'] = 50;
			$config['page_query_string'] = TRUE;
  $config['full_tag_open'] = '<div class="pagination"><ul>';
  $config['full_tag_close'] = '</ul></div>';

  $config['first_link'] = '<< First';
  $config['first_tag_open'] = '<li class="prev page">';
  $config['first_tag_close'] = '</li>';

  $config['last_link'] = 'Last >>';
  $config['last_tag_open'] = '<li class="next page">';
  $config['last_tag_close'] = '</li>';

  $config['next_link'] = 'Next >>';
  $config['next_tag_open'] = '<li class="next page">';
  $config['next_tag_close'] = '</li>';

  $config['prev_link'] = '<< Previous';
  $config['prev_tag_open'] = '<li class="prev page">';
  $config['prev_tag_close'] = '</li>';

  $config['cur_tag_open'] = '<li class="active"><a href="">';
  $config['cur_tag_close'] = '</a></li>';

  $config['num_tag_open'] = '<li class="page">';
  $config['num_tag_close'] = '</li>';
			
			
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();
		
			
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			$page;
			$data['users_list']=$this->Usersmodel->getUserList($config["per_page"], $page);
								
			$this->load->view('includes/header');
			$this->load->view('admin/user/user', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
	

		public function edit()
		{	
		$id = $this->uri->segment(4);
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			
			$data['UserDetailsData']=$this->Usersmodel->getUserDetails($id);
			$this->load->view('includes/header');
			$this->load->view('admin/user/edit', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
	public function create()
		{	
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			
			$this->load->view('includes/header');
			$this->load->view('admin/user/create', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
	
	
	public function view(){	
	$data['UserspostsData']['viewcount']=0;
		$id = $this->uri->segment(4);
		
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$SumProfitofCreated=0;
			$sumProfitofShared=0;
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			
			$data['UserDetailsData']=$this->Usersmodel->getUserDetails($id);
	
							$UserspostsData=$this->Usersmodel->getUserFeeds($id);
							$data['UserspostsData']=$UserspostsData;
							$a=0;
								foreach($UserspostsData as $Usersposts){
								$profitAmount= 0;
								$Profit= !empty($Usersposts['Profit'])?$Usersposts['Profit']:0;
								$Creator= !empty($Usersposts['Creator'])?$Usersposts['Creator']:0;
								$Sharer= !empty($Usersposts['Sharer'])?$Usersposts['Sharer']:0;
								$Adjustment= !empty($Usersposts['Adjustment'])?$Usersposts['Adjustment']:0;


								$data['UserspostsData'][$a]['ProfitofCreated']= (($Usersposts['viewcount']) * ($Profit) * ($Creator/100) * ($Adjustment/100));	
								$SumProfitofCreated=$SumProfitofCreated+$data['UserspostsData'][$a]['ProfitofCreated'];
								$a++;
								}
								
								//SumProfitofCreated
								$data['SumProfitofCreated']=0;
								$data['SumProfitofCreated']=$SumProfitofCreated;
		
		
							$UsersSharesData=$this->Usersmodel->getPostshares($id);
							$data['UsersSharesData']=$UsersSharesData;
							$a=0;
							foreach($UsersSharesData as $UsersShares){
									$profitAmount= 0;
										$Profit= !empty($UsersShares['Profit'])?$UsersShares['Profit']:0;
										$Creator= !empty($UsersShares['Creator'])?$UsersShares['Creator']:0;
										$Sharer= !empty($UsersShares['Sharer'])?$UsersShares['Sharer']:0;
										$Adjustment= !empty($UsersShares['Adjustment'])?$UsersShares['Adjustment']:0;
									
								$data['UsersSharesData'][$a]['ProfitofShared']= (($UsersShares['viewcount']) * ($Profit) * ($Sharer/100) * ($Adjustment/100));		
								$sumProfitofShared=$sumProfitofShared+$data['UsersSharesData'][$a]['ProfitofShared'];
								$a++;
							}
							//sumProfitofShared
							$data['sumProfitofShared']=0;
							$data['sumProfitofShared']=$sumProfitofShared;
							
							
							//totalprofit
							$data['totalprofit']=0;
							$data['totalprofit']=$SumProfitofCreated+$sumProfitofShared;
			
			
			$this->load->view('includes/header');
			$this->load->view('admin/user/view', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
	
	public function update_user(){
	$data=array(
			'user_fname'=>$_GET['fusr'],
			'user_lname'=>$_GET['lusr'],
			'user_email'=>$_GET['email'],
			'user_name'=>$_GET['fusr'].' '.$_GET['lusr'],
	);
	$data2=array(
	'paypal_email'=>$_GET['paypal_email']
	);
	$id=$_GET['user_id'];
	$updation = $this->Usersmodel->UpdateUser($data,$data2,$id);
	if($updation== true){
			$this->session->set_userdata('message_user_updation', 'User is Updated Successfully.'); 
			$this->session->set_userdata('message_user_error', 'false'); 
			redirect('admin/user');
	}else {
		$this->session->set_userdata('message_user_updation', 'Something went worng user data not updated!!!'); 
				$this->session->set_userdata('message_user_error', 'true'); 
		$this->load->view('admin/user/edit/'.$id);
	}
	
	}
	
	public function create_user(){
	if($_GET['pass'] == $_GET['pass_con']){
					
					$data=array(
							'user_fname'=>$_GET['fusr'],
							'user_lname'=>$_GET['lusr'],
							'user_email'=>$_GET['email'],
							'user_name'=>$_GET['fusr'].' '.$_GET['lusr'],
							'user_password'=>md5($_GET['pass']),
							'user_dateCreated'=>date("Y-m-d H:i:s"),
							'user_gender'=>$_GET['gender']
							
					);
					$data2=array(
					'paypal_email'=>$_GET['paypal']
					);
					$updation = $this->Usersmodel->CreateUser($data,$data2);
					if($updation== true){
							$this->session->set_userdata('message_user_updation', 'User is Updated Successfully.'); 
							$this->session->set_userdata('message_user_error', 'false'); 
							redirect('admin/user');
					}else {
						$this->session->set_userdata('message_user_updation', 'Something went worng user data not updated!!!'); 
								$this->session->set_userdata('message_user_error', 'true'); 
						$this->load->view('admin/user/create');
					}
					}else{
						$this->session->set_userdata('message_user_updation', 'Password and Confirmation password did not match !!!'); 
								$this->session->set_userdata('message_user_error', 'true'); 
								$this->load->view('includes/header');
								$this->load->view('admin/user/create');
								$this->load->view('includes/footer');
						
					
					}
	}
	
	
	public function update_user_status()
	{	 $id=$_POST['id'];
			$status=$_POST['status'];
		$this->Usersmodel->UpdateUserStatus($id,$status);
	}
	public function delete_user()
	{	 $id=$_POST['id'];
		$this->Usersmodel->DeleteUser($id);
		
		$this->db->where('user_id', $id);
		$this->db->delete('tbl_seen');
		
		$this->db->where('user_id', $id);
		$this->db->delete('tbl_feeds');
		
	}
	
	public function delete_all_user()
	{	 $id=$_POST['id'];
			$this->Usersmodel->DeleteAllUser($id);

			$this->db->where_in('user_id', $id);
			$this->db->delete('tbl_seen');

			$this->db->where_in('user_id', $id);
			$this->db->delete('tbl_feeds');
		
	}
	
	
}

