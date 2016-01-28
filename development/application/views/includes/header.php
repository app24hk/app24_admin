<!DOCTYPE html> 
<html lang="en-US">
<head>
  <title>24App Administrator</title>
  <meta charset="utf-8">
	<link href="<?php echo base_url(); ?>assets/css/admin/global.css" rel="stylesheet" type="text/css">
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/admin.min.js"></script>
	
	<!--- Files for validation -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate-rules.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>
</head>
<body>
	<div class="navbar navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="brand">
			<!-- <img src="<?php echo base_url(); ?>assets/css/admin/images/logo-2.png"> -->
		  </a>
	      <ul class="nav">
			
				<li <?php if($this->uri->segment(2) == 'dashboard'){echo 'class="active"';}?>>
				   <?php
				     echo anchor('admin/dashboard', 'Dashboard');	
				   ?> 
			       </li>
			  <!--    <li>
				 <?php
			//	  echo anchor('admin/dashboard/changepassword', 'Change Password');	
				 ?>	
			     </li>-->
				<li>
				   <?php
					echo anchor('../admin/dashboard/logout', 'Logout');	
				   ?>	
				</li>
	          </ul>
	   </div>
	  </div>
	</div>	
