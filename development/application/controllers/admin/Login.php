<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
      //  $this->client = CI_Neo4j::get();        
		$this->load->helper('form');
		$this->load->library('form_validation');
    }

	public function index()
	{	
	
		if($this->session->userdata('logged_in'))
			{
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			$this->load->view('includes/header');
			$this->load->view('admin/dashboard', $data);
			$this->load->view('includes/footer');
			}
			else
			{	
			$this->load->view('admin/login');
			}
	}

	function validate_credentials()
	{	
		
				$user_email 	= $this->input->post('user_email');
				$password 	= $this->input->post('password');
	
	
		if (empty($user_email) || empty($password)) {
			$data['user_email'] = $user_email;
			$data['password'] = $password;
           	$data['message_error'] = TRUE;
			$this->load->view('admin/login', $data);	
				
        }else {
		$this->load->model('Admin/Users/Usersmodel');
		$userData= $this->Usersmodel->getUserData($user_email,$password);
		
			if(count($userData)>0)
			{
				
					 	$data = array(
							'user_name' => $userData['user_name'],
							'id' =>  $userData['user_id'],
							'is_logged_in' => true
						);
							$this->session->set_userdata('logged_in',$data);	
							redirect(base_url('admin/dashboard'));												
			
			} else {
					$data['user_email'] = $user_email;
					$data['password'] = $password;
					$data['message_error'] = TRUE;
					$this->load->view('admin/login', $data);		
			}
			}
			
	
	}
	
	public function forgot_password() {
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
