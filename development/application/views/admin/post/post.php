<div class="container top">
<style>
.btn {
   // width: 80px;
}

	.table {
		//margin-left: 15px; 
	}
	
	td img {
  height: 50px;
  width: 50px;
}
.new_post {
cursor: pointer;
    float: right;
    margin-bottom: 36px;
    margin-top: -32px;
    width: 155px;
}

table td:nth-child(4) {
  float: left;
  overflow: hidden;
  width: 93px !important;
}
.pagination2{
float:right;
}

td > p {
  width: 70px;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}

.table th, .table td {

  padding: 8px 3px;

}

td .btn{margin-left:0;}


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
<?php //print_r($post_list) ?>
  <!--<h2>Post Management</h2>   -->
  <div class="page-header users-header">
        <h2>
          <?php echo ucfirst('Post management');?> 
		</h2>
		 <a title="Create new post" href="<?php echo base_url().'admin/post/create'; ?> " class="new_post btn btn-primary"   name="create_new"  id="create_new">New Post</a>
		 <button style="float:right;  cursor: pointer;float: right; margin-bottom: 36px;margin-top: -32px; width: 155px;" title="Delete All" class="btn btn-danger" onclick="deleteall();" name="delete"  id="delete-all">Delete Selected</button>
    </div>
   <div class="row">
  
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
	   <th class="col-xs-1">Post Id</th>
        <th class="col-xs-1">Title</th>
		  <th  class="col-xs-1">Image</th>
          <th  class="col-xs-1">Description</th>
		  <th  class="col-xs-1">VC</th>
		  <th  class="col-xs-1">NOS</th>
		    <th  class="col-xs-1">Username</th>
		   <th  class="col-xs-1">Created</th>
		   <th  class="col-xs-1">Modified</th>
		 
		   <th  style="text-align:center">Action</th>
		   
      </tr>
    </thead>
    <tbody>
	
	<?php  
	//print_r($post_list );
	
    foreach ($post_list as $plist){  
     echo  '<tr id="user-'.$plist['id'].'">';
					echo 	'
					<td align="center" bgcolor="#FFFFFF"><input name="foo" type="checkbox" value="'.$plist['id'].'"></td>
					<td class="col-xs-1">'.$plist['id'].'</td>';
					$title = strip_tags($plist['title']);
					if (strlen($title) > 14) {
					$titleCut = substr($title, 0, 14);
					$titleCut=$titleCut.'...';
					}else{ $titleCut=$title;}
					echo 	'<td class="col-xs-1">'.$titleCut.'</td>';
					if($plist['media']!=''){
											$ext = pathinfo($plist['media'], PATHINFO_EXTENSION);
											if($ext!='jpg' || $ext!='png'){
											$filename = preg_replace('"\.(mp4)$"', '.jpg', $plist['media']);
												echo '<td class="col-xs-1">'.'<img src="'.base_url('assets/images/uploads/feeds').'/'.$filename.'" width="100px" height="100px"></td>';
										
											}else{
											echo '<td class="col-xs-1">'.'<img src="'.base_url('assets/images/uploads/feeds/thumbnail').'/'.$plist['media'].'" width="100px" height="100px"></td>';
											}
											
					}else{
						echo '<td class="col-xs-1">'.'<img src="'.base_url('assets/images/uploads/noimage2.png').'" width="100px" height="100px"></td>';
					}
					$string = strip_tags($plist['description']);
					if (strlen($string) > 50) {
					$stringCut = substr($string, 0, 50);
					$stringCut=$stringCut.'... <a href="'.base_url().'admin/post/view/'.$plist['id'].'" >Read More</a>'; 
					}else{ $stringCut=$string;}
	
					echo '<td class="col-xs-1"><p>'.$stringCut.'</p></td>';
					echo '<td class="col-xs-1">'.$plist['viewcount'].'</td>';
					echo '<td class="col-xs-1">'.$plist['shares'].'</td>';
						echo '<td class="col-xs-1">'.$plist['user_name'].'</td>';
					echo '<td class="col-xs-1">'.$plist['created'].'</td>';
					echo '<td class="col-xs-1">'.$plist['modified'].'</td>';
	
		   echo   '<td style=""  >
		   <a href="'.base_url().'admin/post/view/'.$plist['id'].'" class="btn btn-primary"  style="cursor: pointer;">View</a>
		   <a href="'.base_url().'admin/post/edit/'.$plist['id'].'" class="btn btn-success"  style="cursor: pointer;">Edit</a>
		   <a class="btn btn-danger"  style="cursor: pointer;" onclick="delete_user('.$plist['id'].');" >Delete</a>
							</td>
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
						alert("Please select atleast one post to delete.");
						}else{
						var r = confirm("Do you want to delete selected posts !!!");
									if(r == true){
													$.ajax({
																type:'POST',
																url:'<?php echo base_url(); ?>'+'admin/post/delete_all_post',
																data:{'id':selected},
																success:function(data){	
																location.reload();
																}
															});
											}		
						}
		

}



/*function update_status(id,status){
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
}*/
function delete_user(id){
var r = confirm("Do you want to delete the Post !!!");
if(r == true){
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/post/delete_post',
            data:{'id':id},
            success:function(data){	
			$('#user-'+id).css('display','none');
				
            }
        });
}
}


</script>