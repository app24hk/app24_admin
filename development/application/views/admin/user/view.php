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

<?php //print_r($UserDetailsData);
if($UserDetailsData>0){
?>

<h2 style="color:#006dcc"><?php echo $UserDetailsData['user_name']; ?></h2>
<p>Email : <?php echo $UserDetailsData['user_email']; ?></p>
<p>Gender : <?php echo $UserDetailsData['user_gender']; ?></p>
<p>Register Date : <?php echo $UserDetailsData['user_dateCreated']; ?></p>
<p><h4>Total Profit : <?php echo '$'.$totalprofit; ?></h4></p>
<p><h4>Received Profit : <?php if($UserDetailsData['payment'] !=0){echo '$'.$UserDetailsData['payment'];}else { echo '$0';} ?></h4></p>
<p><h4>Unreceived Profit : <?php if($totalprofit !=0){echo '$'; echo $totalprofit-$UserDetailsData['payment'];}else { echo '$'.$totalprofit;} ?>
</h4></p>
</div>

<div class="row">
<p><h4>Send Profit :</h4></p>
				<form id="myform" action="<?php  echo base_url('admin/payment/send_payment'); ?>">
						<input type="text" id="payment" value=""  onkeypress="return isNumberKey(event)" name="payment">
						<input  type="hidden" name="id"  id="id" value="<?php echo $UserDetailsData['user_id']; ?>">
						<br>
						<?php if($totalprofit!=0){?>
							<input class="btn btn-success" type="submit" name="submit" value="Send">
						
						<?php } else{?>
						
							<input class="btn btn-success" type="submit" name="submit" disabled value="Send">
						<?php }?>
					
				</form>
<h3 style="margin-top:50px;">Payment History</h3>
  <table class="table table-striped">
    <thead>
      <tr>
	   <th class="col-xs-1">Transaction Id</th>
	   <th class="col-xs-1">Payment</th>
	   <th class="col-xs-1">Date</th>
      </tr>
    </thead>
    <tbody>

	
	<?php 
	foreach($UserDetailsData['payments'] as $payments){
					echo '<tr><td class="col-xs-1">'.$payments['id'].'</td>';
					echo '<td class="col-xs-1">'.$payments['payment'].'</td>';
					echo '<td class="col-xs-1">'.$payments['created'].'</td></tr>';
	   }
	 ?>  
      
    </tbody>
  </table>
</div>
  <?php }else{
   redirect('admin/user', 'refresh');
  }?> 
<div class="row">
<?php 
//print_r($UserspostsData);
 if(count($UserspostsData)>0){ ?>
<h3 style="margin-top:50px;">Feeds List</h3>
<h4><?php echo 'Total Profit of Created feed : $'.$SumProfitofCreated; ?> </h4>
  <table class="table table-striped">
    <thead>
      <tr>
	   <th class="col-xs-1">Post Id</th>
        <th class="col-xs-1">Title</th>
		  <th  class="col-xs-1">Image</th>
          <th  class="col-xs-1">Description</th>
		  <th  class="col-xs-1">View counts</th>
		  <th  class="col-xs-1">Numbers of Shares</th>
		   <th  class="col-xs-1">Profit of Created</th>
	
		   <th  class="col-xs-1">Created</th>
		   <th  class="col-xs-1">Modified</th>
		 
		   <th  style="text-align:center;" >Action</th>
		   
      </tr>
    </thead>
    <tbody>
	
	<?php  
	//print_r($post_list );
	
    foreach ($UserspostsData as $plist){  
     echo  '<tr id="user-'.$plist['id'].'">';
					echo 	'<td class="col-xs-1">'.$plist['id'].'</td>';
					$title = strip_tags($plist['title']);
					if (strlen($title) > 14) {
					$titleCut = substr($title, 0, 14);
					$titleCut=$titleCut.'...';
					}else{ $titleCut=$title;}
					echo 	'<td class="col-xs-1">'.$titleCut.'</td>';
					if($plist['media']!=''){
											$ext = pathinfo($plist['media'], PATHINFO_EXTENSION);
											if($ext!='jpg' || $ext!='png'){
												$filename = preg_replace('"\.(MP4)$"', '.jpg', $plist['media']);
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
					$stringCut=$stringCut.'... <a href="">Read More</a>'; 
					}else{ $stringCut=$string;}
	
					echo '<td class="col-xs-1">'.$stringCut.'</td>';
					echo '<td class="col-xs-1">'.$plist['viewcount'].'</td>';
						echo '<td class="col-xs-1">'.$plist['shares'].'</td>';
							echo '<td class="col-xs-1">$'.$plist['ProfitofCreated'].'</td>';
					echo '<td class="col-xs-1">'.$plist['created'].'</td>';
					echo '<td class="col-xs-1">'.$plist['modified'].'</td>';
	
		   echo   '<td style="text-align:center;"  >
		   <a href="'.base_url().'admin/post/view/'.$plist['id'].'" class="btn btn-primary"  style="cursor: pointer;">View</a>
		   <a href="'.base_url().'admin/post/edit/'.$plist['id'].'" class="btn btn-success"  style="cursor: pointer;">Edit</a>
		   <a class="btn btn-danger"  style="cursor: pointer;" onclick="delete_user('.$plist['id'].');" >Delete</a>
							</td>
      </tr>';
	  }
   ?>
    </tbody>
  </table>
</div>
<?php } 
?>

<div class="row">
<?php 
//print_r($UserspostsData);
 if(count($UsersSharesData)>0){ ?>
<h3 style="margin-top:50px;">Share Feeds List</h3>
<h4><?php echo 'Total Profit of Shared post : $'.$sumProfitofShared; ?> </h4>
  
  <table class="table table-striped">
    <thead>
      <tr>
	   <th class="col-xs-1">Post Id</th>
        <th class="col-xs-1">Title</th>
		  <th  class="col-xs-1">Image</th>
          <th  class="col-xs-1">Description</th>
		  <th  class="col-xs-1">Username</th>
		  <th  class="col-xs-1">Viewcount</th>
		   <th  class="col-xs-1">Numbers of Shares</th>
		      <th  class="col-xs-1">Profit of Shares</th>
		   <th  class="col-xs-1">Created</th>
		   <th  class="col-xs-1">Modified</th>
		 
		   <th  style="text-align:center;" >Action</th>
		   
      </tr>
    </thead>
    <tbody>
	
	<?php  
	//print_r($UsersSharesData );
	//die;
    foreach ($UsersSharesData as $pslist){  
     echo  '<tr id="user-'.$pslist['id'].'">';
					echo 	'<td class="col-xs-1">'.$pslist['id'].'</td>';
					$title = strip_tags($pslist['title']);
					if (strlen($title) > 14) {
					$titleCut = substr($title, 0, 14);
					$titleCut=$titleCut.'...';
					}else{ $titleCut=$title;}
					echo 	'<td class="col-xs-1">'.$titleCut.'</td>';
					if($pslist['media']!=''){
											$ext = pathinfo($pslist['media'], PATHINFO_EXTENSION);
											if($ext!='jpg' || $ext!='png'){
												$filename = preg_replace('"\.(MP4)$"', '.jpg', $pslist['media']);
												echo '<td class="col-xs-1">'.'<img src="'.base_url('assets/images/uploads/feeds').'/'.$filename.'" width="100px" height="100px"></td>';
										
											}else{
											echo '<td class="col-xs-1">'.'<img src="'.base_url('assets/images/uploads/feeds/thumbnail').'/'.$pslist['media'].'" width="100px" height="100px"></td>';
											}
											
					}else{
						echo '<td class="col-xs-1">'.'<img src="'.base_url('assets/images/uploads/noimage2.png').'" width="100px" height="100px"></td>';
					}
					$string = strip_tags($pslist['description']);
					if (strlen($string) > 50) {
					$stringCut = substr($string, 0, 50);
					$stringCut=$stringCut.'... <a href="">Read More</a>'; 
					}else{ $stringCut=$string;}
	
					echo '<td class="col-xs-1">'.$stringCut.'</td>';
					echo '<td class="col-xs-1">'.$pslist['user_name'].'</td>';
					echo '<td class="col-xs-1">'.$pslist['viewcount'].'</td>';
					echo '<td class="col-xs-1">'.$pslist['shares'].'</td>';
						echo '<td class="col-xs-1">$'.$pslist['ProfitofShared'].'</td>';
					echo '<td class="col-xs-1">'.$pslist['created'].'</td>';
					echo '<td class="col-xs-1">'.$pslist['modified'].'</td>';
	
		   echo   '<td style="text-align:center;"  >
		   <a href="'.base_url().'admin/post/view/'.$pslist['id'].'" class="btn btn-primary"  style="cursor: pointer;">View</a>
		   <a href="'.base_url().'admin/post/edit/'.$pslist['id'].'" class="btn btn-success"  style="cursor: pointer;">Edit</a>
		   <a class="btn btn-danger"  style="cursor: pointer;" onclick="delete_user('.$pslist['id'].');" >Delete</a>
							</td>
      </tr>';
	  }
   ?>
    </tbody>
  </table>
</div>
<?php } 
?>
<script >
    function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
                return false;
 
             return true;
          }
		  
function delete_user(id){
var r = confirm("Do you want to delete the Post !!!");
if(r == true){
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/post/delete_post',
            data:{'id':id},
            success:function(data){	
			$('#user-'+id).css('display','none');
			window.location = "";	
            }
        });
}
}

jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value != param;
}, "Please send profit more than zero");

$( "#myform" ).validate({
rules: {
		payment: {
		required: true,
		notEqual: 0 
		}
		
}
}); 
    </script>
	