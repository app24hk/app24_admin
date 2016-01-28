<div class="container top">
	<ul class="breadcrumb">
        <li>
			<?php echo anchor($this->uri->segment(1), ucfirst($this->uri->segment(1))); ?>
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php echo ucfirst($this->uri->segment(2));?>
        </li>
    </ul>
	 <div class="page-header users-header">
        <h2>
			<?php echo ucfirst($this->uri->segment(2));
			echo anchor('admin/'.$this->uri->segment(2).'/add', 'Add new '.ucfirst($this->uri->segment(2)).'', array('class'=> 'btn btn-success'));?>
		</h2>
    </div>
	  
	<div class="row">
        <div class="span12 columns">
			<div class="well" style="text-align:center;color:#FF0000;">
			<?php
				echo "Sorry, no records found.";
			?>
			</div>
		</div>
	</div>	