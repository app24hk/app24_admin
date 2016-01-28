<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profit extends CI_Controller {

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
		$this->load->model('Admin/Profits/Profitsmodel');
	//	if (!$this->isLogged()) {
     //       redirect(base_url('admin'));
     //   }
       // $this->client = CI_Neo4j::get();  
		    
    }


	public function index()
	{				
				
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			$data['postparams_list']=$this->Profitsmodel->getProfitparamsList();
			$this->load->view('includes/header');
			$this->load->view('admin/profit/profitparameters', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
			public function add_prms(){
				$this->Profitsmodel->save_profit_params($_POST);
			}
			public function save_edit_prms(){
				$this->Profitsmodel->save_profit_edit_params($_POST);
			}
			
			public function delete_profitparams(){
			$id=$_POST['id'];
			$this->db->where('id', $id);
			$this->db->delete('tbl_profit');
			}
			public function getprofitvalues(){
			$id=$_POST['id'];
			$this->Profitsmodel->get_profit_values($id);	
		
			}
	
}

