<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';


if(!empty($_POST) ){	
	if($_POST['updateitemnow'] == 'Update') {
		$array = array();
		$array['model'] = $_POST['model'];
		$array['condition'] = $_POST['condition'];
		$array['label'] = $_POST['label'];
		$array['invoice_date'] = $_POST['invoice_date'];
		$array['invoice_number'] = $_POST['invoice_number'];
		$array['type'] = $_POST['type'];
		$array['brand'] = $_POST['brand'];
		$array['serial'] = $_POST['serial'];
		$where = "inventory_number =".$_GET['id'];
		$updateStaffId = $db->updateQuery('physical_inventory', $array,$where );				
	}
	
	
	else if($_POST['reassignStafftoitemnow'] == 'Reassign To Staff') {
		// echo "Assign To Staff";
		$array = array();		
		$array['ws_id'] = $_POST['table_id'];
		$where = "ps_id =".$_GET['id'];		
		if($_POST['shift'] == "night")
			$array['staff_idN'] = $_POST['user_id'];
		else
			$array['staff_id'] = $_POST['user_id'];
			
		$updateStaffId = $db->updateQuery('assigns', $array,$where );
		// echo "<script>location.reload();</script>";
	}	
	else if($_POST['assignStafftoitemnow'] == 'Assign To Staff') {
	// echo "Assign To Staff";
	// $array = array(); 
		
			$db->deleteQuery("assigns","ps_id=".$_GET['id']);
			$insertArr_invoice1 = array();
			$insertArr_invoice1['staff_id'] = $_POST['user_id'];
			$insertArr_invoice1['ws_id'] = $_POST['table_id'];
			$insertArr_invoice1['ps_id'] = $_POST['ps_id'];
			$invoiceId = $db->insertQuery('assigns', $insertArr_invoice1);  		
		// echo "<script>location.reload();</script>";
	}	
	
}	
if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
?>
<hr>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<script>

 $(function() {
	 $( "#editdialog" ).dialog({
		autoOpen: false,
		height:'auto',
		width:423,
		show: {
			modal: true,
			buttons: {
				"Delete all items": function() {
					  $( this ).dialog( "close" );
					},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			}
		},
		hide: {
			effect: "explode",
			duration: 1000
		}
    });
	$( "#assignStafftoitem" ).dialog({
		autoOpen: false,
		height:'auto',
		width:423,
		show: {
			modal: true,
			buttons: {
				"Delete all items": function() {
					  $( this ).dialog( "close" );
					},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			}
		},
		hide: {
			effect: "explode",
			duration: 1000
		}
    });
 
 
    $( "#edit" ).click(function() {			
      $( "#editdialog" ).dialog( "open" );
    });
	
	$( "#assignbutton" ).click(function() {			
      $( "#assignStafftoitem" ).dialog( "open" );
    });
	
	
});
	
</script>

<?php 			
		$where = "inventory_number = ".$_GET['id'];				
		$details = $db->selectSingleQueryArray("physical_inventory","*", $where,"");				

		?>	
<h3><?php echo $details["item_name"]; ?> Details 
	<a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  style="width:100px;"  id='edit' >Edit</button></a>
	<a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  style="width:100px;"  id='assignbutton' >Assign Staff</button></a>
</h3>	
<?php
	$staffAssign = $db->selectSingleQueryArray("assigns Left JOIN staff ON uid  = staff_id", "CONCAT(sFirst,' ', sLast) AS name " , "ps_id=".$_GET['id'], $add_sql="");	
	$staffAssignN = $db->selectSingleQueryArray("assigns Left JOIN staff ON uid  = staff_idN", "CONCAT(sFirst,' ', sLast) AS nameN " , "ps_id=".$_GET['id'], $add_sql="");	
	
	$tableAssign = $db->selectSingleQueryArray("assigns Left JOIN workstation ON workstation_id  = ws_id", "label " , "ps_id=".$_GET['id'], $add_sql="");
	echo "<br/>Table  : <b>".$tableAssign['label']."</b>";
?>
<table border="0" width="500px" >	
	<?php echo '		
		<tr bgcolor="#E0E0E0">			
			<td width="150px;">Assigned To Dayshift</label></td>
			<td >'.$staffAssign['name'].'</td>			
		</tr>
		<tr>
			<td><label>Assigned To Nightshift</label></td>
			<td >'.$staffAssignN['nameN'].'</td>			
		</tr>
		
		<tr bgcolor="#E0E0E0">			
			<td width="150px;"><label>Invoice Date</label></td>
			<td >'.$details["invoice_date"].'</td>			
		</tr>
		<tr>
			<td><label>Invoice Number</label></td>
			<td >'.$details["invoice_number"].'</td>			
		</tr>
		<tr bgcolor="#E0E0E0">			
			<td><label>Type</label></td>
			<td >'.$details["type"].'</td>			
		</tr>
		<tr>
			<td><label>Brand</label></td>
			<td >'.$details["brand"].'</td>			
		</tr>
		<tr bgcolor="#E0E0E0">			
			<td><label>Serial</label></td>
			<td >'.$details["serial"].'</td>			
		</tr>
		<tr>
			<td><label>Model</label></td>
			<td >'.$details["model"].'</td>			
		</tr>
		<tr bgcolor="#E0E0E0">			
			<td><label>Label</label></td>
			<td >'.$details["label"].'</td>			
		</tr>
		<tr>
			<td><label>Condition</label></td>
			<td >'.$details["condition"].'</td>			
		</tr>				
		<tr bgcolor="#E0E0E0">		
			<td><label>Remarks</label></td>
			<td >'.$details["remarks"].'</td>			
		</tr>	
	</table>'; ?>	
<hr>



<h3><i><?php echo $details["item_name"]; ?> Assignment History</i></h3>
	<table border="1" >
		<tr align="center">
			<th width='200px'>Time Stamp</th>						
			<th width='200px'>Last Name</th>
			<th width='200px'>First Name</th>
			<th width='100px'>Table #</th>
			<th width='100px'>Assigned By</th>
		</tr>

		<?php 
		$addON = "LEFT JOIN staff ON  uid = assign_userid LEFT  JOIN mouse ON  mouse_id = assign_mouseid";
		$where = "assign_mouseid = ".$_GET['id'];
		$fields = "assign_timestamp,assign_userid,sLast,sFirst,table_no,assign_assignedby, (select concat(lastName,'  ',firstName) as name from users where userID = assign_assignedby ) as divi";
		$details = $db->selectQuery("assignments",$fields, $where,$addON);				
			foreach( $details AS $detail ):
				echo '<tr >';				
				echo "<td >".$detail['assign_timestamp']."</td>";				
				echo "<td width='100px'>".$detail['sLast']."</td>";
				echo "<td width='100px'>".$detail['sFirst']."</td>";
				echo "<td width='100px'>".$detail['table_no']."</td>";
				echo "<td width='100px'>".$detail['divi']."</td>";
				echo '</tr>';				
			endforeach;
			
		$currentValue = $db->selectSingleQueryArray("physical_inventory", "*" , "inventory_number=".$_GET['id'], $add_query="");
		// print_r($currentValue);
		?>				
	</table>
	
	<div id="editdialog" title="Update item details" style="width:423px; height:199px;">
	  <form action="" name="updateitemform" method="POST" >
			<table border="0" cellpadding="3" cellspacing="3" align="center">	
				<tr>
					<td><label>Invoice Date</label></td>
					<td><input type="date" class="selectcss" id="invoice_date" name="invoice_date" value="<?php echo $currentValue['invoice_date'];?>" /></td>
				</tr>
				<tr>
					<td><label>Invoice Number</label></td>
					<td><input type="text" class="selectcss"  id="invoice_number" name="invoice_number" value="<?php echo $currentValue['invoice_number'];?>" /></td>
				</tr>
				<tr>
					<td><label>Type</label></td>
					<td><input type="text" class="selectcss"  id="type" name="type" value="<?php echo $currentValue['type'];?>" /></td>
				</tr>
				<tr>
					<td><label>Brand</label></td>
					<td><input type="text" class="selectcss"  id="type" name="type" value="<?php echo $currentValue['brand'];?>" /></td>
				</tr>
				<tr>
					<td><label>Serial</label></td>
					<td><input type="text" class="selectcss"  id="serial" name="serial" value="<?php echo $currentValue['serial'];?>" /></td>
				</tr>
				<tr>
					<td><label>Model</label></td>
					<td><input type="text" class="selectcss"  id="model" name="model" value="<?php echo $currentValue['model'];?>" /></td>
				</tr>
				<tr>
					<td><label>Label</label></td>
					<td><input type="text" class="selectcss"  id="label" name="label" value="<?php echo $currentValue['label'];?>" /></td>
				</tr>
				<tr>
					<td><label>Condition</label></td>
					<td><textarea style=" height: 102px;"><?php echo $currentValue['condition'];?></textarea></td>
				</tr>			
				<tr>
					<td><label>Remarks</label></td>
					<td><textarea style=" height: 102px;"><?php echo $currentValue['remarks'];?></textarea></td>
				</tr>						
				<tr>	
					<td></td>
					<td><input type="submit" name="updateitemnow" id="updateitemnow" placeholder="Brand" style="width:205px; height:30px;" value="Update"></td>		
						
				</tr>	
			</table>	
		</form>
	</div>
	
	<div id="assignStafftoitem" name="assignStafftoitem"  title="Assign To Staff" style="width:423px; height:199px;">
	  <form action="" name="" method="POST" >
			<table border="0" cellpadding="3" cellspacing="3" align="center">		
				<tr>
				<td>
					<label>Table</label>
				</td>
				<td>					
					<?php 						
						$staff = $db->selectQuery("workstation","*", "1 ORDER BY label asc");									
						echo '<select name="table_id" id="table_id" style="width:200px; height:35px;">';
						echo "<option ></option>";
						foreach( $staff AS $c ):			
							if($tableAssign['label'] == $c['label'])
								$selectedvalue = "selected";
							else $selectedvalue = "";
							echo "<option value=".$c['workstation_id']." ".$selectedvalue.">".$c['label']."</option>";													
						endforeach;
						echo '</select>';				
					?>			
				</td>
			</tr>		
				
				<tr>
					<td>
						<label>Shift</label>
					</td>
					<td>
						<select name="shift" id="shift" style="width:200px; height:35px;">
							<option></option>
							<option value="morning">Morning</option>
							<option value="night">Night</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>Staff Name</label>
					</td>
					<td>					
						<?php 
							$staff = $db->selectQuery("staff","*", "1 ORDER BY sLast");			
							echo '<select name="user_id" id="user_id" style="width:200px; height:35px;">';
							echo "<option ></option>";
							foreach( $staff AS $c ):															
								echo "<option value=".$c['uid'].">".$c['sFirst']." ".$c['sLast']."</option>";													
							endforeach;
							echo '</select>';				
						?>			
					</td>
				</tr>		
				<tr>	
					<td></td>
					<td>
						<?php 
							$tablename = $db->selectSingleQuery("assigns", "assigns_id" , "ps_id=".$_GET['id'], $add_sql="");							
						if(isset($tablename))
							echo '<input type="submit" name="reassignStafftoitemnow" id="reassignStafftoitemnow" placeholder="Brand" style="width:200px; height:30px;" value="Reassign To Staff"></td>';							
						else
							echo '<input type="submit" name="assignStafftoitemnow" id="assignStafftoitemnow" placeholder="Brand" style="width:200px; height:30px;" value="Assign To Staff"></td>';
						?>
						
						
				</tr>	
			</table>	
		</form>
	</div>
	
<?php }  require "includes/footer.php"; ?>