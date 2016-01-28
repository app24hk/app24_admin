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
          <?php echo ucfirst('Post management');?> 
		</h2>
    </div>
   <div class="row">

<?php //print_r($postcreatedProfitList);
if($postDetailsData>0){
?>

<?php

	if($postDetailsData['media']!=''){
					 	$ext = pathinfo($postDetailsData['media'], PATHINFO_EXTENSION);
						
											if($ext!='jpg' && $ext!='png'){
											$filename = preg_replace('"\.(mp4)$"', '.jpg', $postDetailsData['media']);
											echo '<p">'.'<img src="'.base_url('assets/images/uploads/feeds').'/'.$filename.'" width="200px" height="150px"></p>';	
												
											echo '<p">'.'<video width="400px" height="250px" controls>
												<source src="'.base_url('assets/images/uploads/feeds').'/'.$postDetailsData['media'].'" type="video/mp4">	
												<source src="'.base_url('assets/images/uploads/feeds').'/'.$filename.'" type="video/jpg">	
												</video></p>';
							
										
											}else{
											echo '<p">'.'<img src="'.base_url('assets/images/uploads/feeds/thumbnail').'/'.$postDetailsData['media'].'" width="400px" height="250px"></p>';
											}
											
					}else{
						echo '<p">'.'<img src="'.base_url('assets/images/uploads/noimage2.png').'" width="200" height="150px"></p>';
					}

 ?>

 <h2> <?php echo $postDetailsData['title']; ?></h2>
 <p> <?php echo $postDetailsData['description']; ?></p>
 <p> Username : <?php echo $postDetailsData['user_name']; ?></p>
 <p> Created  : <?php echo $postDetailsData['created']; ?></p>
  <p> Modified : <?php echo $postDetailsData['modified']; ?></p>
   <p> Profit of Created Post (Current month) : <?php echo '$'.$postDetailsData['ProfitofCreated']; ?></p>
    <p> Profit of Shared Post (Current month) : <?php echo '$'.$postDetailsData['ProfitofShared']; ?></p>
  <?php }else{
   redirect('admin/post', 'refresh');
  }?> 
</div>
<?php 


if(isset($postcreatedProfitList['profitdata']) && count($postcreatedProfitList['profitdata'])>0){ ?>
<div class="user-data">
<h3>Profit History</h3>
 <table class="table">
    <thead>
      <tr>
	  
        <th>Month</th>
        <th>Year</th>
		<th>Month Views</th> 
		 <th>Profit of Created</th> 
		  <th>Profit of Shared</th>
		  <th>Month Profit</th>
      </tr>
    </thead>
    <tbody>
<?php 
foreach($postcreatedProfitList['profitdata'] as $ProfitList){
 echo '<tr class="success">
       
        <td>'.$ProfitList['Month'].'</td>
        <td>'.$ProfitList['Year'].'</td>
		  <td>'.$ProfitList['monthviews'].'</td>
		<td>$'.$ProfitList['ProfitofCreated'].'</td>
		<td>$'.$ProfitList['ProfitofShared'].'</td>
		<td>$'.$ProfitList['totalProfitbymonth'].'</td>
      </tr>';
}?>
<tr><td colspan=4><h4>Total profit</h4></td><td><h4><?php echo '$'.$postcreatedProfitList['totalprofit']; ?></h4></td></tr>
 </tbody>
  </table>
</div>
<?php 
} ?>



<?php if(count($postUsersData)>0){ ?>
<div class="user-data">
<h3>Sharers List</h3>
 <table class="table">
    <thead>
      <tr>
	      <th>Sr. no</th>
        <th>Username</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
	<?php 
	$a=1;
	//echo $postDetailsData['Number_of_Sharers'];
	foreach($postUsersData as $k=>$userData){  if($postDetailsData['Number_of_Sharers']<=$k) { break; }
    echo '<tr class="success">
        <td>'.$a.'</td>
        <td>'.$userData['user_name'].'</td>
        <td>'.$userData['user_email'].'</td>
      </tr>';
	  $a++;
   }
   ?>
  
    </tbody>
  </table>
</div>
<?php } ?>