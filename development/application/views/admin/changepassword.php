    <div class="container top">
      <ul class="breadcrumb">
        <li>
			<?php echo anchor($this->uri->segment(1), ucfirst($this->uri->segment(1))); ?>
        </li>
      </ul>
      <div class="page-header">
        <h2>
         Change Password
        </h2>
      </div>
      <?php
      //flash messages
	 
      if($this->session->flashdata('message')!='') {
        if($this->session->flashdata('message')!='')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">x</a>';
            echo 'Password has been changed Successfully.';
          echo '</div>';       
        }
        else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">x</a>';
            echo '<strong>Oh snap!</strong> Current password is not correct.';
          echo '</div>';          
        } 
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => 'form');

      //form validation
      echo validation_errors();
      echo form_open('admin/dashboard/add', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label style="width:160px;" for="inputError" class="control-label"><span class="error">*</span> Current Password</label>
            <div class="controls">
             <?php 
				echo form_password('current_password', set_value('current_password'),'maxlength="30"');
	     ?>
            </div>
          </div>
		  <div class="control-group">
            <label style="width:160px;" for="inputError" class="control-label"><span class="error">*</span> New Password</label>
            <div class="controls">
             <?php 
				echo form_password('new_password', set_value('new_password'),'maxlength="30"');
	     ?>
            </div> 
          </div>
		  <div class="control-group">
            <label style="width:160px;" for="inputError" class="control-label"><span class="error">*</span> Confirm Password</label>
            <div class="controls">
             <?php 
				echo form_password('confirm_password', set_value('confirm_password'),'maxlength="30"');
	     ?>
            </div>
          </div>
          <div class="form-actions">
                       <?php
			$param = 'class="btn btn-primary"';	
			echo form_submit('save','Save changes',$param);
			echo "&nbsp;";
			$param1 = 'class="btn"';	
			echo form_reset('Reset','Reset',$param1);
			?>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
    
	<script type="text/javascript">
	/*$.validator.setDefaults({
		submitHandler: function() { alert("submitted!"); }
	});*/
	$(document).ready(function() {
		$("#form").submit(function () {
			$("#form").validate();
		});
	}); 
	</script>
	
