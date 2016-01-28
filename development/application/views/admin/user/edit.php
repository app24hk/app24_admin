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
          <?php echo ucfirst('User management');?> 
		</h2>
    </div>
   <div class="row">

<?php //print_r($UserDetailsData);

if($UserDetailsData>0){

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
  <form role="form" id="register-form" action="<?php  echo base_url('admin/user/update_user'); ?>"  novalidate="novalidate">
	<div class="form-group">
      <label for="usr">First Name:</label>
      <input type="text" name="fusr"   value="<?php  echo $UserDetailsData['user_fname']; ?>" class="form-control" id="fusr">
    </div>
	<div class="form-group">
      <label for="usr">Last Name:</label>
      <input type="text" name="lusr"  value="<?php  echo $UserDetailsData['user_lname']; ?>"  class="form-control" id="lusr">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" name="email"  value="<?php  echo $UserDetailsData['user_email']; ?>" class="form-control" id="email">
    </div>
	<div class="form-group">
      <label for="usr">Paypal Account:</label>
      <input type="text" name="paypal_email"  value="<?php  echo $UserDetailsData['paypal_email']; ?>"  class="form-control" id="paypal">
    </div>
	 <div class="form-group">
	 <input type="hidden" name="user_id" value="<?php  echo $UserDetailsData['user_id']; ?>">
	<input type="submit" class="btn btn-info"  value="Update"/> 
	</div>
  </form>
  <?php }else{
   redirect('admin/user', 'refresh');
  }?> 
</div>
	
<script>
  // When the browser is ready...
  $(function() {
    // Setup form validation on the #register-form element
    $("#register-form").validate({
        // Specify the validation rules
        rules: {
            email: {
                required: true,
                email: true
            },
			 paypal: {
                required: true,
                email: true
            }
        },
        // Specify the validation error messages
        messages: {
            email: "Please enter a valid email address",
			paypal: "Please enter a valid paypal email address",
        }, 
        submitHandler: function(form) {
            form.submit();
        }
    });
  });
  </script>