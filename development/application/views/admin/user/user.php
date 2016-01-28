<div class="container top">
<style>
.btn {
   // width: 80px;
}
.table {
   // margin-left: 15px;
}

	.table td {
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: top;
  white-space: nowrap;
}

.section_table {
  margin-left: 0;
}
.new_user {
cursor: pointer;
    float: right;
    margin-bottom: 36px;
    margin-top: -32px;
    width: 155px;
}
.pagination2{
float:right;
}
</style>
	<ul class="breadcrumb">
		<li>
			<?php echo anchor($this->uri->segment(1), ucfirst('Dashboard')); ?>
			<span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
	</ul>
<?php //print_r($pagination) ?>
  <!--<h2>User Management</h2>   -->
  <div class="page-header users-header">
        <h2>
          <?php echo ucfirst('User management');?> 
		</h2>
		 <a title="Create new user" href="<?php echo base_url().'admin/user/create'; ?> " class="new_user btn btn-primary"   name="create_new"  id="create_new">New User</a>
	<button style="float:right;  cursor: pointer;float: right; margin-bottom: 36px;margin-top: -32px; width: 155px;" title="Delete All" class="btn btn-danger" onclick="deleteall();" name="delete"  id="delete-all">Delete Selected</button>
    </div>
	
   <div class="row section_table">
  <?php //echo BASEPATH; ?>
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
	
  <table class="table table-striped">
    <thead>
      <tr>
	  <th><input id="checkbox-all" type="checkbox" onClick="toggle(this);" /></th>
        <th>User ID</th>
          <th>Name</th>
		   <th>Email</th>
		  <th>Gender</th>
		   <th>Login Type</th>
		   <th style="text-align:center;" >Status</th>
		   <th  style="text-align:center;" >Action</th>
		   
      </tr>
    </thead>
    <tbody>
	
	<?php  
    foreach ($users_list as $ulist){  
     echo  '<tr id="user-'.$ulist['user_id'].'">
	 <td align="center" bgcolor="#FFFFFF"><input name="foo" type="checkbox" value="'.$ulist['user_id'].'"></td>
	 <td>'.$ulist['user_id'].'</td>
        <td>'.ucwords($ulist['user_name']).'</td>
		 <td>'.$ulist['user_email'].'</td>
        <td>'.ucwords($ulist['user_gender']).'</td>
		  <td>'.ucwords($ulist['user_loginType']).'</td>';
		  
		  if($ulist['user_status']==1){$status='Active'; $class='btn btn-success';}elseif($ulist['user_status']==0){$status='Inactive'; $class='btn btn-danger';}			  
		  
		  echo '<td  style="text-align:center;"  ><a class="'.$class.'" id="status-'.$ulist['user_id'].'" title="Change Status" style="cursor: pointer;" onclick="update_status('.$ulist['user_id'].','.$ulist['user_status'].');" >'.$status.'</a></td>';
		   echo   '<td style="text-align:center;"  ><a href="'.base_url().'admin/user/view/'.$ulist['user_id'].'" class="btn btn-success"  style="cursor: pointer;">View</a>
		  <a href="'.base_url().'admin/user/edit/'.$ulist['user_id'].'" class="btn btn-primary"  style="cursor: pointer;">Edit</a><a class="btn btn-danger"  style="cursor: pointer;" onclick="delete_user('.$ulist['user_id'].');" >Delete</a></td>
      </tr>';
	  }
   ?>
    </tbody>
  </table>
  <div class="pagination2">
  <?php echo $pagination; ?>
  </div>
</div>
<script>
function update_status(id,status){
 $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/user/update_user_status',
            data:{'id':id,'status':status},
            success:function(data){				
			 if(status==1) {
				$('#status-'+id).attr('onclick','update_status('+id+',0);');
				$('#status-'+id).attr('class','');
				$('#status-'+id).addClass('btn btn-danger');
				 $('#status-'+id).html('Inactive');
			 } else {
				$('#status-'+id).attr('onclick','update_status('+id+',1);');
				$('#status-'+id).attr('class','');
				$('#status-'+id).addClass('btn btn-success');
				 $('#status-'+id).html('Active');
			 }
            }
        });
}
function delete_user(id){
var r = confirm("Do you want to delete the User !!!");
if(r == true){
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/user/delete_user',
            data:{'id':id},
            success:function(data){	
			$('#user-'+id).css('display','none');
				
            }
        });
}
}

function toggle(source) {
checkboxes = document.getElementsByName('foo');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function deleteall(){

						var selected = new Array();
						$(document).ready(function() {
						  $("input:checkbox[name=foo]:checked").each(function() {
							   selected.push($(this).val());
						  });

						});

						if(selected.length<1){
						alert("Please select atleast one user to delete.");
						}else{
						var r = confirm("Do you want to delete selected users !!!");
									if(r == true){
													$.ajax({
																type:'POST',
																url:'<?php echo base_url(); ?>'+'admin/user/delete_all_user',
																data:{'id':selected},
																success:function(data){	
																location.reload();
																}
															});
											}		
						}
		

}

</script>