<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

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
			$this->load->model('Admin/Payments/Paymentsmodel');
	//	if (!$this->isLogged()) {
     //       redirect(base_url('admin'));
     //   }
       // $this->client = CI_Neo4j::get();  
		    
    }


	public function index()
	{				
	}
	public function send_payment(){
	
						if(isset($_GET['submit']) &&  $_GET['submit']=='Send'){
						$id=$_GET['id'];
						$data=array(
								'user_id'=>$_GET['id'],
								'payment'=>$_GET['payment']	
						);
						

						$creation = $this->Paymentsmodel->sendpayment($data);
						if($creation== true){
								$this->session->set_userdata('message_user_updation', 'Payment Sent Successfully.'); 
								$this->session->set_userdata('message_user_error', 'false'); 
								redirect('admin/user/view/'.$id);
						}else {
							$this->session->set_userdata('message_user_updation', 'Something worng  in sending payment !!!'); 
									$this->session->set_userdata('message_user_error', 'true'); 
							$this->load->view('admin/user/view/'.$id);
						}
						
						}
	}
}

