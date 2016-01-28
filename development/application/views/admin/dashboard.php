<div class="container top">
	<ul class="breadcrumb">
		<li>
			<?php echo anchor($this->uri->segment(1), ucfirst('Dashboard')); ?>
			<span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
	</ul>

    <div class="page-header users-header">
        <h2>
          <?php echo ucfirst($this->uri->segment(2));?> 
		</h2>
    </div>
  
    <div class="row">
        <div class="span12 columns">
		<div id="left_col">
			<table class="table table-striped table-bordered table-condensed" style="width:70%;">
				<thead>
					<tr>
						<th>Manage Profits</th>
					</tr>
				</thead>	
				<tbody>
					<tr>
						<td>
						<?php echo anchor('../admin/profit/', 'Profit Parameters','title="Profit Parameters"'); ?>
						</td>
						</td>
					</tr>
				<!--	<tr>
						<td>
							<?php// echo anchor('../admin/post', 'Post management','title="Post management"'); ?>
						</td>
						</td>
					</tr>-->
			
				</tbody>	
			</table>	
			
			
			</div>
			
			<div id="left_col">
			<table class="table table-striped table-bordered table-condensed" style="width:70%;">
				<thead>
					<tr>
						<th>Manage Users</th>
					</tr>
				</thead>	
				<tbody> 
					<tr>
						<td>
							<?php echo anchor('../admin/user', 'User management','title="User management"'); ?>
						</td>
					</tr>
					<!--<tr>
						<td>
							<?php //echo anchor('#', 'Add User');
 ?>
						</td>
					</tr>-->
					
				</tbody>	
			</table>
			
			</div>
			
		
		<div id="right_col">
			
			
			<table class="table table-striped table-bordered table-condensed" style="width:70%;">
				<thead>
					<tr>
						<th>Manage Posts</th>
					</tr>
				</thead>	
				<tbody>
					<tr>
						<td>
							<?php echo anchor('../admin/post/', 'Post management','title="Post management"'); ?>
						</td>
					</tr>
					<!--<tr>
						<td>
							<?php //echo anchor('#', 'Add User');
 ?>
						</td>
					</tr>-->
				</tbody>	
			</table>
			
			
			
			</div>
			
	
		</div>
    </div> 
