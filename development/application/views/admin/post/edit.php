<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<div class="container top">
<style>
.btn {
    width: 80px;
}
.row {
    margin-left: 0px;
}
input[type="submit"] {
    margin-left: 0;
}

form#register-form .form-group label {
  margin-bottom: 5px;
  margin-left: 0;
}

form#register-form .form-group input {
  width: 50%;
}

#register-form .form-group textarea {
  width: 50%;
  height: 100px;
}

form#register-form .form-group input[type="submit"] {
  width: auto;
}
</style>

	<ul class="breadcrumb">
		<li>
			<?php echo anchor($this->uri->segment(1), ucfirst('Dashboard')); ?>
			<span class="divider">/</span>
        </li>
        <li >
       	<?php echo anchor('admin/'.$this->uri->segment(2), ucfirst($this->uri->segment(2))); ?>
		  <span class="divider">/</span>
        </li>
		 <li class="active">
          <?php echo ucfirst($this->uri->segment(3));?>
		  <span class="divider">/</span>
        </li>
	</ul>

<div class="page-header users-header">
        <h2>
          <?php echo ucfirst('Post management');?> 
		</h2>
    </div>
   <div class="row">

<?php //print_r($postDetailsData);

if($postDetailsData>0){
?>
 
     <?php  
	$message=$this->session->userdata('message_user_updation');
	$message_user_error=$this->session->userdata('message_user_error');
	 if($message!=''){
	 if($message_user_error=='true'){
				echo '<div class="alert alert-error">';
		  } elseif($message_user_error=='false'){
		        echo '<div class="alert alert-success">';
		  }
            echo '<strong>'.$message.'</strong>';
          echo '</div>';             
		$this->session->unset_userdata('message_user_updation');
		}
	 ?>  
  <form method="POST" role="form" enctype="multipart/form-data" id="register-form" action="<?php  echo base_url('admin/post/update_post'); ?>"  novalidate="novalidate">
  
  
  <?php

	if($postDetailsData['media']!=''){
					 	$ext = pathinfo($postDetailsData['media'], PATHINFO_EXTENSION);
						
											if($ext!='jpg' && $ext!='png'){
											$filename = preg_replace('"\.(mp4)$"', '.jpg', $postDetailsData['media']);
											echo '<p>'.'<img src="'.base_url('assets/images/uploads/feeds').'/'.$filename.'" width="200px" height="150px"></p>';	
												
											echo '<p>'.'<video width="400px" height="250px" controls>
												<source src="'.base_url('assets/images/uploads/feeds').'/'.$postDetailsData['media'].'" type="video/mp4">	
												<source src="'.base_url('assets/images/uploads/feeds').'/'.$filename.'" type="video/jpg">	
												</video></p>';
							
										
											}else{
											echo '<p>'.'<img src="'.base_url('assets/images/uploads/feeds/thumbnail').'/'.$postDetailsData['media'].'" width="400px" height="250px"></p>';
											}
											
					}else{
						echo '<p">'.'<img src="'.base_url('assets/images/uploads/noimage2.png').'" width="200" height="150px"></p>';
					}

 ?>
  
  
  <div class="form-group">
      <label for="usr">Image/video:</label>
      <input type="file" name="media" accept="image/*,video/*"   class="form-control" id="media">
    </div>
  
	<div class="form-group">
      <label for="usr">Title:</label>
      <input type="text" name="title"   value="<?php  echo $postDetailsData['title']; ?>" class="form-control" id="title">
    </div>
	<div class="form-group">
      <label for="usr">Description:</label>
      <textarea name="desc" class="form-control" id="desc"><?php  echo $postDetailsData['description']; ?></textarea>
    </div>
	
	<div class="form-group">
      <label for="usr">facebook Share Url:</label>
	   <input type="text" name="fburl"   value="<?php  echo $postDetailsData['fb_share_url']; ?>" class="form-control" id="fburl">
    </div>
	
	 <div class="form-group">
	 <input type="hidden" name="post_id" value="<?php  echo $postDetailsData['id']; ?>">
	 <input type="hidden" name="mediaoldfile" value="<?php  echo $postDetailsData['media']; ?>">
	<input type="submit" class="btn btn-info"  value="Update"/> 
	</div>
  </form>
  <?php }else{
   redirect('admin/post', 'refresh');
  }?> 
</div>
	
<!--<script>
  // When the browser is ready...
  $(function() {
    // Setup form validation on the #register-form element
    $("#register-form").validate({
        // Specify the validation rules
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        // Specify the validation error messages
        messages: {
            email: "Please enter a valid email address",
        }, 
        submitHandler: function(form) {
            form.submit();
        }
    });
  });
  </script>-->