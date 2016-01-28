<!--<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->
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
.validations{
 color: red;
}

form.demo .form-group label {
  margin-left: 0;
  margin-bottom: 5px;
}

form.demo .form-group input {
  padding: 8px;
  width: 50%;
}

.demo .form-group textarea {
  width: 50%;
}

.demo .form-group select {
  width: 50%;
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

<?php //print_r($getUsersLists);

//if($postDetailsData>0){
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
	 
<div class="validations"><?php echo validation_errors(); ?></div>
<?php 
$attr = array('class'=>'demo');
echo form_open_multipart('admin/post/create_post',$attr); ?>
	 
  <!--<form role="form" id="register-form" action="<?php // echo base_url('admin/post/create_post'); ?>"  novalidate="novalidate">-->
	<div class="form-group">
      <label for="usr">Title:</label>
      <input type="text" name="title"   value="" class="form-control" id="title">
    </div>
	 <div class="form-group">
  <label for="comment">Description:</label>
  <textarea name="desc" class="form-control" rows="5" id="desc"></textarea>
</div>
	<div class="form-group">
      <label for="usr">Image/video:</label>
      <input type="file" name="media" accept="image/*,video/*"   class="form-control" id="media">
    </div>
 <div class="form-group">
  <label for="sel1">Feed by User:</label>
  <select class="form-control"  name="user_id" id="user_id">
 
<?php 
foreach($getUsersLists as $Users){
 echo '<option value="'.$Users['user_id'].'" >'.$Users['user_name'].'</option>';
}
 ?>
  </select>
</div>
	 <div class="form-group">
	 <input type="hidden" name="post_id" value="">
	<input type="submit" class="btn btn-info"  value="submit"/> 
	</div>
  </form>
  <?php /*  }else{
   redirect('admin/post', 'refresh');
  } */ ?> 
</div>
	
<script>
  // When the browser is ready...
  /* $(function() {
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
  }); */
  </script>
  <script language="javascript">
function Checkfiles()
{
var fup = document.getElementById('media');
var fileName = fup.value;
var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "MP4")
{
return true;
} 
else
{
alert("Upload images and mp4 videos only");
fup.focus();
return false;
}
}
</script>