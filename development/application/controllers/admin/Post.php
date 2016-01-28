<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller {

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
		$this->load->model('Admin/Posts/Postsmodel');
	//	if (!$this->isLogged()) {
     //       redirect(base_url('admin'));
     //   }
       // $this->client = CI_Neo4j::get();  
		    
				$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
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
				$config['base_url'] = base_url('admin/post');
				$config['total_rows'] = $this->Postsmodel->getPostCount();
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
			
			//$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['post_list']=$this->Postsmodel->getPostparamsList($config["per_page"], $page);
			$this->load->view('includes/header');
			$this->load->view('admin/post/post', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
		public function edit(){	
		$id = $this->uri->segment(4);
		
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			
			$data['postDetailsData']=$this->Postsmodel->getPostDetails($id);
			$this->load->view('includes/header');
			$this->load->view('admin/post/edit', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
	
	public function update_post(){
	

	$title=$_POST['title'];
	$description=$_POST['desc'];
	$fburl=$_POST['fburl'];
	$mediaoldfile=$_POST['mediaoldfile'];
	$media = $_FILES['media']['tmp_name'];
	$id=$_POST['post_id'];

		$type=0;
		if(!empty($media)){
						$ext = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
						if($ext=='mp4'){
						$type=2;
						}else{
						$type=1;
						}					
										
								

							//$type = $this->input->post('type'); //0-no image or video,1-> image,2->video							
							if ($type == 1 && !empty($media)) {
															$directorypath1 = dirname(BASEPATH) . "/assets/images/uploads/feeds/";
															$feedImage = 'feed_' . time() . ".png";
												 
																	$config['upload_path'] =   $directorypath1;
																	$config['allowed_types'] = 'gif|jpg|png|jpeg';
																	$config['file_name']=$feedImage;
																	$this->load->library('upload', $config);
																	
																	$this->upload->initialize($config);
																	if ( ! $this->upload->do_upload('media')) {
																		$error = $this->upload->display_errors();
																		$feedData=false;
																	} else {
																					$config['max_width']  = '640';
																					$config['max_height']  = '640';
																					$config['upload_path'] = $directorypath1 . 'thumbnail/';
																							$this->load->library('upload', $config);
																							$this->upload->initialize($config);		
																							$file_data = $this->upload->data();
																		
																											if ( ! $this->upload->do_upload('media')) {
																											$error = $this->upload->display_errors();
																											} else {
																											$file_data = $this->upload->data();
																											}
																					
																											
																	}
																							$media = $feedImage;
																												$savefeed = array(
																													'title' => $title,
																													'description' => $description,
																													'media' => $media,
																													'type' => 1,
																													'created' => date('Y-m-d H:i:s')
																												);
																												$updation = $this->Postsmodel->UpdatePost($savefeed,$id);
																												
																						//		$unlinkfile = dirname(BASEPATH) . '/assets/images/uploads/feeds/'.$mediaoldfile;
																						//	$unlinkfilethumb = dirname(BASEPATH) . '/assets/images/uploads/feeds/thumbnail/'.$mediaoldfile;
																						//		unlink(	$directorypath1);
																												
							} elseif($type == 2 && !empty($media)) {

																			$mediadirectorypath = dirname(BASEPATH) . "/assets/images/uploads/feeds/";
																			$mfile_name = 'feed_media' . time() . '_' . ".mp4";
																		  /*$mfile = str_replace('data:video/MP4;base64,', '', $media);
																			$mfile = str_replace('', '+', $mfile);
																			$data = base64_decode($mfile); */

																				$config['upload_path'] =   $mediadirectorypath;
																				$config['allowed_types'] = '*';
																				$config['file_name']=$mfile_name;
																				$config['max_size'] = 0;
																				
																				$this->load->library('upload', $config);			
																				$this->upload->initialize($config);
																				
																		
																							if ( ! $this->upload->do_upload('media')) {
																											$error = $this->upload->display_errors();
																											$feedData=false;
																								} else {
																									
																							
																												$upload_data= $this->upload->data();
																												
																											
																												$mfile_path = $mediadirectorypath . $mfile_name;
																												$nam = explode(".", $mfile_name);
																												$new_image = $nam[0] . '.jpg';
																												$path = $mediadirectorypath . $mfile_name;
																												$new_image_path = $mediadirectorypath . $new_image;
																												$command = "ffmpeg -i " . $path . " " . $new_image_path;
																												exec($command);  
																												
																												$savefeed = array(
																												'title' => $title,
																												'description' => $description,
																												'media' => $mfile_name,
																												'type' => 2,
																												'created' => date('Y-m-d H:i:s')
																												);

																													$updation = $this->Postsmodel->UpdatePost($savefeed,$id);
																							}
																	
							}

								
										
										
		
			}	elseif(empty($media)) {
							$savefeed = array(
							'title' => $title,
							'description' => $description,
							'media' => $mediaoldfile,
							'fb_share_url'=>$fburl
						);
						$updation = $this->Postsmodel->UpdatePost($savefeed,$id);
			}

				if($updation== true){
						$this->session->set_userdata('message_user_updation', 'Post is Updated Successfully.'); 
						$this->session->set_userdata('message_user_error', 'false'); 
						redirect('admin/post');
				}else {
					$this->session->set_userdata('message_user_updation', 'Something went worng post data not updated!!!'); 
							$this->session->set_userdata('message_user_error', 'true'); 
					$this->load->view('admin/post/edit/'.$id);
				}
	
	}
	public function create(){	
		$id = $this->uri->segment(4);
		
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			
		$data['getUsersLists']=$this->Postsmodel->getUsersLists();
			$this->load->view('includes/header');
			$this->load->view('admin/post/create', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
	
			public function create_post(){

							$this->form_validation->set_rules('title', 'Title', 'required');
							$this->form_validation->set_rules('desc', 'Description', 'required');
								if ($this->form_validation->run() == FALSE)
								{
									$this->load->view('includes/header');
									$this->load->view('admin/post/create');
									$this->load->view('includes/footer');
								}
								else
								{
										$user_id =  $_POST['user_id'];
										$title = $_POST['title'];
										$description = $_POST['desc'];
										$media = $_FILES['media']['tmp_name'];
										$type=0;
										if(!empty($media)){
													$ext = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
													if($ext=='mp4'){
													$type=2;
													}else{
													$type=1;
													}					
										
									}	
									//	$type = $this->input->post('type'); //0-no image or video,1-> image,2->video							
	if ($type == 0) {
            $savefeed = array(
                'user_id' => $user_id,
                'title' => $title,
                'description' => $description,
                'type' => 0,
                'created' => date('Y-m-d H:i:s')
            );
			$feedData=$this->Postsmodel->saveUserFeed($savefeed);	
    } elseif ($type == 1 && !empty($media)) {
            $directorypath1 = dirname(BASEPATH) . "/assets/images/uploads/feeds/";
            $feedImage = 'feed_' . time() . ".png";
 
					$config['upload_path'] =   $directorypath1;
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['file_name']=$feedImage;
					$this->load->library('upload', $config);
					
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload('media')) {
						$error = $this->upload->display_errors();
						$feedData=false;
					} else {
									$config['max_width']  = '640';
									$config['max_height']  = '640';
									$config['upload_path'] = $directorypath1 . 'thumbnail/';
											$this->load->library('upload', $config);
											$this->upload->initialize($config);		
											$file_data = $this->upload->data();
						
															if ( ! $this->upload->do_upload('media')) {
															$error = $this->upload->display_errors();
															} else {
															$file_data = $this->upload->data();
															}
									
															
					}
											$media = $feedImage;
											$savefeed = array(
												'user_id' => $user_id,
												'title' => $title,
												'description' => $description,
												'media' => $media,
												'type' => 1,
												'created' => date('Y-m-d H:i:s')
											);
											$feedData=$this->Postsmodel->saveUserFeed($savefeed);	
        } elseif($type == 2 && !empty($media)) {

            $mediadirectorypath = dirname(BASEPATH) . "/assets/images/uploads/feeds/";
			$mfile_name = 'feed_media' . time() . '_' . ".mp4";
          /*$mfile = str_replace('data:video/MP4;base64,', '', $media);
            $mfile = str_replace('', '+', $mfile);
            $data = base64_decode($mfile); */

				$config['upload_path'] =   $mediadirectorypath;
				$config['allowed_types'] = '*';
				$config['file_name']=$mfile_name;
				$config['max_size'] = 0;
				
				$this->load->library('upload', $config);			
				$this->upload->initialize($config);
				
		
							if ( ! $this->upload->do_upload('media')) {
											$error = $this->upload->display_errors();
											$feedData=false;
								} else {
									
							
												$upload_data= $this->upload->data();
												
											
												$mfile_path = $mediadirectorypath . $mfile_name;
												$nam = explode(".", $mfile_name);
												$new_image = $nam[0] . '.jpg';
												$path = $mediadirectorypath . $mfile_name;
												$new_image_path = $mediadirectorypath . $new_image;
												$command = "ffmpeg -i " . $path . " " . $new_image_path;
												exec($command);  
												
												$savefeed = array(
												'user_id' => $user_id,
												'title' => $title,
												'description' => $description,
												'media' => $mfile_name,
												'type' => 2,
												'created' => date('Y-m-d H:i:s')
												);

												$feedData=$this->Postsmodel->saveUserFeed($savefeed);	
							}
    
        }
		
		
		// $feedData = $this->Usersmodel->saveUserFeed($savefeed);
		 
		 
      /*   if ($feedData) {
			$getUserFeedData= $this->Usersmodel->getUserFeedData($feedData);
			if ($getUserFeedData['type'] == 0) {
				$getUserFeedData['thumbnail'] = '';								
				$getUserFeedData['media'] = '';								
			} elseif ($getUserFeedData['type'] == 1) {
				$getUserFeedData['thumbnail'] = '';								
				$getUserFeedData['media'] = base_url()."assets/images/uploads/feeds/".$getUserFeedData['media'];
				
			} elseif ($getUserFeedData['type'] == 2) {
				$filename= dirname(BASEPATH) . "/assets/images/uploads/feeds/".$getUserFeedData['media'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$thumbnail = ($ext=='MP4')?base_url() . "assets/images/uploads/feeds/" . str_replace('MP4', 'jpg', $getUserFeedData['media']):base_url() . "assets/images/uploads/feeds/" . str_replace('mp4', 'jpg', $getUserFeedData['media']);
				$getUserFeedData['thumbnail'] = $thumbnail;								
				$getUserFeedData['media'] = base_url()."assets/images/uploads/feeds/".$getUserFeedData['media'];
			}		 */							
												

					if($feedData== true){
												
															$this->session->set_userdata('message_user_updation', 'Post is successfully submitted.'); 
															$this->session->set_userdata('message_user_error', 'false'); 
																 redirect('admin/post', 'refresh');
															}else {
															$this->session->set_userdata('message_user_updation', 'Something went worng post data not submitted!!!'); 
															$this->session->set_userdata('message_user_error', 'true'); 
																 redirect('admin/post/create', 'refresh');
															} 
								}
	}
	

	
	
	
	
	public function view(){	
		$id = $this->uri->segment(4);
		if($this->session->userdata('logged_in'))
			{
			$data=array();
			$session_data = $this->session->userdata('logged_in');
			$data['user_name'] = $session_data['user_name'];
			
			$data['postDetailsData']=$this->Postsmodel->getPostDetails($id);
			
			$profitAmount= 0;
					$Profit= !empty($data['postDetailsData']['Profit'])?$data['postDetailsData']['Profit']:0;
					$Creator= !empty($data['postDetailsData']['Creator'])?$data['postDetailsData']['Creator']:0;
					$Sharer= !empty($data['postDetailsData']['Sharer'])?$data['postDetailsData']['Sharer']:0;
					$Adjustment= !empty($data['postDetailsData']['Adjustment'])?$data['postDetailsData']['Adjustment']:0;
					
					$data['postDetailsData']['ProfitofCreated']= (($data['postDetailsData']['viewcount']) * ($Profit) * ($Creator/100) * ($Adjustment/100));
					$data['postDetailsData']['ProfitofShared']= (($data['postDetailsData']['viewcount']) * ($Profit) * ($Sharer/100) * ($Adjustment/100));	
				
			
			
			$data['postUsersData']=$this->Postsmodel->getUsershares($id);
			$data['postcreatedProfitList']=$this->Postsmodel->getmonthlyprofit($id);
			
			
			$this->load->view('includes/header');
			$this->load->view('admin/post/view', $data);
			$this->load->view('includes/footer');
			}
			   else
			   {
				 //If no session, redirect to login page
				 redirect('admin', 'refresh');
			   }	
		
	}
			public function add_prms(){
				$this->Postsmodel->save_profile_params($_POST);
			}
			
			public function delete_postparams(){
			$id=$_POST['id'];
			$this->db->where('id', $id);
			$this->db->delete('tbl_postparams');
			}
			public function delete_all_post()
			{	 $id=$_POST['id'];
					$this->Postsmodel->DeleteAllPost($id);

			}
			public function delete_post(){
			$id=$_POST['id'];
			$this->db->where('id', $id);
			$this->db->delete('tbl_feeds');
			
			$this->db->where('feed_id', $id);
			$this->db->delete('tbl_share');
			
			$this->db->where('feed_id', $id);
			$this->db->delete('tbl_seen');
			
			}
			
}

