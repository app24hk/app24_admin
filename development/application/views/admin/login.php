<?php // die('here'); ?>
<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title>24 App Administrator</title>
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
  </head>
  <style>
  .form-signin-logo{
   background-color: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 5px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    margin: 0 auto 20px;
	max-width: 293px;
	}
	.form-signin {
	max-width: 231px;
	}
	.login img {
	margin-left: 322px;
	}
  </style>
  <body>
    <div class="container login">
	<img class="form-signin-logo" width="100%" height="100%" src="<?php echo base_url(); ?>assets/img/logo3.jpg">
      <?php 
      $attributes = array('class' => 'form-signin');
      echo form_open('admin/login/validate_credentials', $attributes);
      echo '<h2 class="form-signin-heading">Login</h2>';
	  $opts1 = 'placeholder="User Email" , ';
	  $opts2 = 'placeholder="Password" , ';
	  echo form_input('user_email', isset($user_email)?$user_email:'', $opts1 );
      echo form_password('password', isset($password)?$password:'', $opts2 );
	  
	
      if(isset($message_error) && $message_error){
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Wrong user name and password combination.';
          echo '</div>';             
      }
	  //echo '<br/><a href="'.base_url().'admin/login/forgot_password">Forgot Password?</a>';
      echo form_submit('submit', 'Login', 'class="btn btn-large btn-primary"');
      echo form_close();
	  
      ?>  
		
    </div><!--container-->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>    
    
