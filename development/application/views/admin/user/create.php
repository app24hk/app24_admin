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
  padding:8px 0;
}

#register-form .form-group {
  width: 100%;
  float: left;
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

//if($UserDetailsData>0){

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
  <form role="form" id="register-form" action="<?php  echo base_url('admin/user/create_user'); ?>"  novalidate="novalidate">
	<div class="form-group">
      <label for="usr">First Name:</label>
      <input type="text" name="fusr"   value="" class="form-control" id="fusr">
    </div>
	<div class="form-group">
      <label for="usr">Last Name:</label>
      <input type="text" name="lusr"  value=""  class="form-control" id="lusr">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" name="email"  value="" class="form-control" id="email">
    </div>
	  <div class="form-group">
      <label for="email">Gender:</label>
					
					<div  class="form-group">
					<label  style="float:left; margin-right:5px;" class="radio-inline">Female<input type="radio" value="female" name="gender" style="float:left; padding-right:5px"></label>
					<label  style="float:left;"  class="radio-inline">Male<input type="radio" checked="checked" value="male" name="gender" style="float:left"></label>
					</div>
					
				
		</div>			
	<div class="form-group">
      <label for="usr">Paypal Account:</label>
      <input type="text" name="paypal"  value=""  class="form-control" id="paypal">
    </div>
	<div class="form-group">
      <label for="usr">Password:</label>
      <input type="password" name="pass"  value=""  class="form-control" id="pass">
    </div>
	<div class="form-group">
      <label for="usr">Confirm Password:</label>
      <input type="password" name="pass_con"  value=""  class="form-control" id="pass_con">
    </div>
	 <div class="form-group">
	 <input type="hidden" name="user_id" value="">
	<input type="submit" class="btn btn-info"  value="submit"/> 
	</div>
  </form>
  
</div>
	
<script>
  // When the browser is ready...
  $(function() {
    // Setup form validation on the #register-form element
    $("#register-form").validate({
        // Specify the validation rules
    rules: {
		fusr: {
                required: true
            },
		lusr: {
			required: true
			},
        email: {
                required: true,
                email: true
            },
		paypal: {
                required: true,
                email: true
            },
		pass: {
                required: true
            },
		pass_con: {
                required: true
            }
        },
        // Specify the validation error messages
        messages: {
				fusr: "Please enter first name",
				lusr: "Please enter last name",
				email: "Please enter a valid email address",
				paypal: "Please enter a valid paypal email address",
				pass: "Please enter  password",
				pass_con: "Please enter confirm password"
        }, 
        submitHandler: function(form) {
            form.submit();
        }
    });
  });
  </script>