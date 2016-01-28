<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sullivan Buses</title>
	<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/myriad-helvatica/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.jscrollpane.css" />
	<script type="text/javascript">
	 document.createElement('header');
	 document.createElement('hgroup');
	 document.createElement('nav');
	 document.createElement('menu');
	 document.createElement('section');
	 document.createElement('article');
	 document.createElement('aside');
	 document.createElement('footer');
	</script>
	
	<!-- Files for validation starts -->
		<script src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
       	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>
       
	<!-- Files for validation ends -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.jscrollpane.min.js"></script>

<script type="text/javascript" id="sourcecode">
	$(function()
	{
		$('.scroll-pane-after').jScrollPane(
			{
				showArrows: true,
				verticalArrowPositions: 'after',
				horizontalArrowPositions: 'after'
			}
		);
	});
</script>
</head>
	
<body>

	
	<?php
		//echo '<pre>';print_r($this->uri);
	?>
	<!----Header Starts---->
<header <?php if(($this->uri->segment(1) == '' || $this->uri->segment(1)=='home') && $this->session->userdata('is_front_logged_in')!='1'){ ?> class="header1" <?php } ?> >
	<section class="logo"><a href="<?php echo base_url();?>" title="Homepage"><img src="<?php echo base_url(); ?>assets/img/logo.png"></a></section>
	
	
	
	<?php if($this->session->userdata('is_front_logged_in')){ ?>
		<a href="<?php echo base_url();?>logout" title="Coming Soon" class="login">Logout</a>
		<div class="my-account">Hi, <?php echo $this->session->userdata['user_data']['user_first_name']." ".$this->session->userdata['user_data']['user_last_name']; ?>!  <?php echo anchor('login/my_account', 'My Account'); ?></div>
	<?php }else{ ?>
		<a href="<?php echo base_url();?>login" class="login">login</a>
	<?php } ?>
	<!--onclick="window.location.href='login'">login</button>-->
    <nav>
        <ul>
		
            <li <?php if($this->uri->segment(1) == ''){echo 'class="active"';}?>>
				 <?php
				  //echo anchor('dashboard', 'My Profile');	
				  echo anchor('', 'home');
				 ?>
			</li>
            <li <?php if($this->uri->segment(1) == 'about-us'){echo 'class="active"';}?>>
				<?php
				  echo anchor('about-us', 'about us');
				 ?>
			</li>
            <li><a href="javascript:void(0);">Schools</a>
               <ul class="subs">
               		<div class="scroll-pane-after">
                    <?php foreach($schools as $schoolKey=>$school){ ?>

						<li><a href="<?php echo base_url()."schools/".$school["school_url"]; ?>"><?php echo $school["school_name"]; ?></a></li>
					
					<?php }	?>
                	</div>
                </ul>
            </li>
             <li <?php if($this->uri->segment(1) == 'download'){echo 'class="active"';}?>>
				<?php
				  //echo anchor('dashboard', 'My Profile');	
				  echo anchor('schools/downloads', 'downloads');
				 ?>
			</li>
            <li <?php if($this->uri->segment(1) == 'contact-us'){echo 'class="active"';}?>>
				<?php
				  //echo anchor('dashboard', 'My Profile');	
				  echo anchor('contact-us', 'contact us');
				 ?>
			</li>
            <div class="clear"></div>
        </ul>
    </nav>
    <!----Navigation Ends---->
    <div class="clear"></div>
   



