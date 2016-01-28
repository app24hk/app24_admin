<div class="container top">
<style>
.btn {
    width: 80px;
}
	.table {
		margin-left: 15px;
	}
input, textarea, .uneditable-input {
    width: 70px;
}	
select {
    width: 80px;
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


<?php //print_r($postparams_list) ?>
  <!--<h2>Profit Management</h2>  -->
  
  <div class="page-header users-header">
        <h2>
          <?php echo ucfirst('Profit Management');?> 
		</h2>
    </div>
   <div class="row">

  <div id="message" class="col-xs-4"  style="display:none;"></div>    
<a class="btn btn-primary" onClick="add_params();" title="Change Status" style="cursor: pointer;  width:155px;  float: right; margin-bottom: 36px; margin-top: -70px;"  ><span class="glyphicon glyphicon-plus"></span> Add New Params</a> 
  
  <table class="table table-striped">
  
    <thead>
      <tr>
			<th>Profit</th>
			<th>Creator</th>
			<th>Sharer</th>
			<th>Adjustment</th>
			<th>Number of Sharers</th>
			<th>Month</th>
			<th>Year</th>
			
			<th  style="text-align:center;" >Action</th>
		   
      </tr>
    </thead>
    <tbody>
	
	

<tr id="newparams" style="display:none;"> 
<form name="newparams" action="" type="post">
<td>
<input name="profit" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="profit" type="text" value="">
</td>

<td>
<input name="Creator" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="Creator" type="text" value="">
</td>

<td>
<input name="Sharer" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="Sharer" type="text" value="">
</td>

<td>
<input name="Adjustment" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="Adjustment" type="text" value="">
</td>

<td>
<input name="Numberofshares" onkeypress="return isNumberKey(event)" class="form-control input-sm" id="Numberofshares" type="text" value="">
</td>

<td>
<select  class="form-control input-sm" name="Month" class="" id="Month">
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
</td>

<td>
<select class="form-control input-sm"  name="Year"   class="" id="Year"  >

<?php 
$i=date("Y");
echo '<option value="'.$i.'">'.$i.'</option>';
for($a=1; $a<=10;$a++){
$year=$i+$a;
echo '<option value="'.$year.'">'.$year.'</option>';
}
?>
</select>
</td>

<td style="text-align:center;"  > 
 <a class="btn btn-success"  style="cursor: pointer;" onclick="add_prms()" >Save</a>
 <a class="btn btn-danger"  style="cursor: pointer;" onclick="confirm('New profit not saved yet.'); $('#newparams').hide();" >Cancel</a>
 </td>
 
</form>
</tr>

	
	
	
	<?php  
    foreach ($postparams_list as $pplist){  
     echo  '<tr id="profit-'.$pplist['id'].'">
				
				<td  id="profitval-'.$pplist['id'].'">'.$pplist['Profit'].'</td>
				<td id="Creator-'.$pplist['id'].'">'.$pplist['Creator'].'</td>
				<td id="Sharer-'.$pplist['id'].'">'.$pplist['Sharer'].'</td>
				<td id="Adjustment-'.$pplist['id'].'">'.$pplist['Adjustment'].'</td>
				<td id="Numberofshares-'.$pplist['id'].'">'.$pplist['Number_of_Sharers'].'</td>';
				
				$monthName = date('F', mktime(0, 0, 0, $pplist['Month'], 10)); // March
				
				
				echo '<td>'.$monthName.'</td>
				<td>'.$pplist['Year'].'</td>';

		 echo   '<td  id="action-'.$pplist['id'].'" style="text-align:center;"  >';
						//	 <a href="'.base_url().'admin/post/paramsedit/'.$pplist['id'].'" class="btn btn-primary"  style="cursor: pointer;">Edit</a>
		echo 		'<a   class="btn btn-primary" onclick="edit_params('.$pplist['id'].');" style="cursor: pointer;">Edit</a>
							  <a id="delete-'.$pplist['id'].'" class="btn btn-danger"  style="cursor: pointer;" onclick="delete_params('.$pplist['id'].');" >Delete</a>
						</td>	
      </tr>';
	  }
   ?>
    </tbody>
  </table>
</div>


<script>


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
        return false;
    return true;

}


function add_params()
{
$('#newparams').show();
}

function delete_params(id){
var r = confirm("Do you want to delete the Profit Parameters for this month !!!");
if(r == true){
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/profit/delete_profitparams',
            data:{'id':id},
            success:function(data){	
			$('#profit-'+id).css('display','none');
				
            }
        });
}

}

function add_prms(){
var profit=$('#profit').val();
var Creator=$('#Creator').val();
var Sharer=$('#Sharer').val();
var Adjustment=$('#Adjustment').val();
var Numberofshares=$('#Numberofshares').val();
var Month=$('#Month').val();
var Year=$('#Year').val();
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/profit/add_prms',
            data:{'Profit':profit,'Creator':Creator,'Sharer':Sharer,'Adjustment':Adjustment,'Number_of_Sharers':Numberofshares,'Month':Month,'Year':Year},
            success:function(data){	
			$('#message').css('display','block');
			if(data==='0') {
				$('#message').addClass('alert alert-error');	
				$('#message').text('Profit parameters for this month already exists');
			} else {
				$('#message').addClass('alert alert-success');	
				$('#message').text('Profit parameters  added');
				setInterval(function() {
				  window.location = '<?php echo base_url(); ?>'+'admin/profit/';
				}, 2000);				
			}			
			$('#newparams').css('display','none');	
            }
        });


}

function edit_params(id){
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/profit/getprofitvalues',	
            data:{'id':id},
            success:function(data){	
			var myObject = JSON.parse(data);
			var Profit = myObject['Profit'];
			var Creator = myObject['Creator'];
			var Sharer = myObject['Sharer'];
			var Adjustment = myObject['Adjustment'];
			var Number_of_Sharers = myObject['Number_of_Sharers'];
			var Month = myObject['Month'];
			var Year = myObject['Year'];
			
			$('#profitval-'+id).replaceWith("<td id='profitval-"+id+"'><form name='editparams'  type='post'><input onkeypress='return isNumberKey(event)' name='profits-"+id+"' id='profits-"+id+"' type='text' value='" +Profit + "'></td>");
			$('#Creator-'+id).replaceWith("<td id='Creator-"+id+"'><input  onkeypress='return isNumberKey(event)' name='Creator-"+id+"'  id='Creators-"+id+"' type='text' value='" +Creator + "'></td>");
			$('#Sharer-'+id).replaceWith("<td id='Sharer-"+id+"'><input onkeypress='return isNumberKey(event)' name='Sharer-"+id+"'  id='Sharers-"+id+"'  type='text' value='" +Sharer + "'></td>");
			$('#Adjustment-'+id).replaceWith("<td id='Adjustment-"+id+"'><input  onkeypress='return isNumberKey(event)' name='Adjustment-"+id+"'  id='Adjustments-"+id+"'  type='text' value='" +Adjustment + "'></td>");
			$('#Numberofshares-'+id).replaceWith("<td id='Numberofshares-"+id+"'><input onkeypress='return isNumberKey(event)'  name='Numberofshares-"+id+"'  id='Numberofsharess-"+id+"' type='text' value='" +Number_of_Sharers + "'></td>");
			
			$('#action-'+id).replaceWith("<td style='text-align:center;'  > <a class='btn btn-success'  style='cursor: pointer;' onclick='save_edit_prms("+id+")' >Save</a><a class='btn btn-danger'  style='cursor: pointer;'  onClick='cancel_save();'>Cancel</a></form></td>");
            }	
        });

}
function cancel_save(){
var a=confirm('Do you want to descard the changes?');
	if(a==true){
	window.location = '<?php echo base_url(); ?>'+'admin/profit/';
	}
}
function save_edit_prms(id){
var profit=$('#profits-'+id).val();
var Creator=$('#Creators-'+id).val();
var Sharer=$('#Sharers-'+id).val();
var Adjustment=$('#Adjustments-'+id).val();
var Numberofshares=$('#Numberofsharess-'+id).val();
$.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>'+'admin/profit/save_edit_prms',
            data:{'id':id,'Profit':profit,'Creator':Creator,'Sharer':Sharer,'Adjustment':Adjustment,'Number_of_Sharers':Numberofshares},
            success:function(data){	
			$('#message').css('display','block');
			if(data==='0') {
				$('#message').addClass('alert alert-error');	
				$('#message').text('Error !!! Profit parameters not updated');
			} else {
				$('#message').addClass('alert alert-success');	
				$('#message').text('Profit parameters updated');
				setInterval(function() {
				window.location = '<?php echo base_url(); ?>'+'admin/profit/';
				}, 2000);				
			}			
            }
        });


}


</script>