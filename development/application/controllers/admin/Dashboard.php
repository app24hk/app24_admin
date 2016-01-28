<?php 
class Dashboard extends CI_Controller {
		
	public function __construct()
    {
        parent::__construct();
		
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
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
	}

	public function logout(){
        $this->session->unset_userdata('logged_in');
        //session_start();
        session_destroy();
        redirect(base_url('admin'));
    }
	public function changepassword() {		
		$this->load->view('includes/header');
		$this->load->view('admin/changepassword');
		$this->load->view('includes/footer');
	}
	public function add() {
		
		$this->load->library('form_validation');
		$data = array();
		 //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('current_password', 'current password', 'trim|required');
	    	$this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[5]');
	    	$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|matches[new_password]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>', '</strong></div>');
            
			//echo $this->form_validation->run(); die('run'); 
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
              	
				$old_password = $this->input->post('current_password');
				$new_password = $this->input->post('new_password');
				$match = 0;				
				$queryMatch = "MATCH user where user:admin and user.password='".$old_password."' RETURN user;";
        		$query = new Everyman\Neo4j\Cypher\Query($this->client, $queryMatch);
        		$result = $query->getResultSet();
				foreach($result as $row) {				
					//echo "<pre>"; print_r($row['user']);
		        	if($row['user']->getProperty('password')==$old_password) {
						$match = 1;
					}	
				}				
				
				if($match==1) {
					$queryMatch = "MATCH user where user:admin and user.password='".$old_password."' set user.password='".$new_password."' RETURN user;";
        			$query = new Everyman\Neo4j\Cypher\Query($this->client, $queryMatch);
        			$result = $query->getResultSet();
					$data['flash_message'] = TRUE;
					
				} else {
					$data['flash_message'] = FALSE;
				}
				
				/*if($check_oldpass != md5($old_password))
				{
					$data['flash_message'] = FALSE;
				}
				else
				{
					if($this->changepassword_model->change_password($new_password,$this->session->userdata['id']))
					{
						$data['flash_message'] = TRUE; 
					}
				}*/
            }
				
		
		}		

				$this->session->set_flashdata('message', 'Password has been changed Successfully.');
				//echo ($this->session->flashdata('message')!='');
				//echo $this->session->flashdata('message'); die;
				redirect(base_url('admin/dashboard/changepassword'));
				//unset($this->_field_data);
				//$this->load->view('includes/header');
				//$this->load->view('admin/changepassword', $data); 
				//$this->load->view('includes/footer');
	}
}
?>
