<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';
require 'endorsemen_tab.php';

if(!empty($_POST) ){	
	if($_POST['assignnow'] == 'Assign') {
		$alltypevalue_var = $_POST['alltypevalue'];
		$explode_ = explode("|",$alltypevalue_var);	
		$counter = 0;	
		$size = count($explode_);
		$insertArr_invoice = array();
		for($ctr = $size ; $counter < $size; $counter++) {
			$values = $_POST[$explode_[$counter]];
			if(!empty($values))
				array_push($insertArr_invoice,$values);
		}

		$item_name = $_GET['itemName'];
		foreach($insertArr_invoice as $insertvalue){
			$insertArr_invoice1 = array();
			$insertArr_invoice1['ws_id'] = $item_name;
			$insertArr_invoice1['ps_id'] = $insertvalue;
			$invoiceId = $db->insertQuery('assigns', $insertArr_invoice1);  
			}
		// echo "<script>location.reload();</script>";
		
	}
	else if($_POST['assignnow'] == 'Update') {
		echo "Update";
		$db->deleteQuery("assigns","ws_id=".$_GET['itemName']);
			$alltypevalue_var = $_POST['alltypevalue'];
			// print_r($alltypevalue_var );
		$explode_ = explode("|",$alltypevalue_var);	
		echo "explode -"; 
		// print_r($explode_);
		$counter = 0;	
		$size = count($explode_);
		$insertArr_invoice = array();
		for($ctr = $size ; $counter < $size; $counter++) {
			$values = $_POST[$explode_[$counter]];
			// echo $values;
			if(!empty($values))
				array_push($insertArr_invoice,$values);
		}
// print_r($insertArr_invoice);
		$item_name = $_GET['itemName'];
		foreach($insertArr_invoice as $insertvalue){
			$insertArr_invoice1 = array();
			$insertArr_invoice1['ws_id'] = $item_name;
			$insertArr_invoice1['ps_id'] = $insertvalue;
			// $invoiceId = $db->insertQuery('assigns', $insertArr_invoice1);  
			}
			print($insertArr_invoice1);
		// echo "<script>location.reload();</script>";	
	}
	
	else if($_POST['assignnow'] == 'Assign To Staff') {
		echo "Assign To Staff";
		$array = array();
		if($_POST['shift'] == "night")
			$array['staff_idN'] = $_POST['user_id'];
		else
			$array['staff_id'] = $_POST['user_id'];
		$where = "ws_id =".$_GET['itemName'];
		$updateStaffId = $db->updateQuery('assigns', $array,$where );
		// echo "<script>location.reload();</script>";
	}	
	else if($_POST['assignnow'] == 'Transfer') {
		echo "Transfer";
		$array = array();
		$array['ws_id'] = $_POST['table_id'];
		$where = "ws_id =".$_GET['itemName'];
		$updateStaffId = $db->updateQuery('assigns', $array,$where );
	}
		
}
if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	
	//print_r($user);
	
	
	?>
<hr>

<style>
.selectcss {
  -webkit-border-radius: 1;
  -moz-border-radius: 1;
  border-radius: 1px;
  font-family: Arial;
  color: #858585;
  font-size: 14px;
  background: #ffffff;
  padding: 6px 20px 6px 20px;
  border-top: solid #a3a1a3 1px;
  border-right: solid #a3a1a3 1px;
  border-bottom: solid #a3a1a3 1px;
  border-left: solid #a3a1a3 1px;
  text-decoration: none;
}

</style>
<br/>

<div id="div_id" style="display:none;" >
<form action="" name="" method="POST">
		<table border="0" cellpadding="3" cellspacing="3">		
			<tr>
				<td>
					<label>Table #</label>
				</td>
				<td>
					<?php
						$tablename = $db->selectSingleQuery("workstation", "label" , "workstation_id=".$_GET['itemName'], $add_sql="");
					?>
					- Day Shift
					<input value="<?php echo $tablename;?>" class="selectcss" style="width:100px;" readonly />
				</td>
			</tr>		
			<?php $items = $db->selectQuery("physical_inventory","DISTINCT (item_name) as item", "1");		
						$size = count($items);
						$counter = 0;		
						$alltype ="";
						for($ctr = $size ; $counter < $size; $counter++) {
							$alltype .= $items[$counter]['item']."|";
							echo "<tr>
										<td width=100px;'>
											<label>".$items[$counter]['item']."</label>
										</td>";												
									// $test = $db->selectQuery("physical_inventory","*","item_name like '%".$items[$counter]['item']."%' ");									
									$test = $db->selectQuery("physical_inventory LEFT JOIN assigns on ps_id = inventory_number","*", "inventory_number  NOT IN(Select ps_id from `assigns` where staff_id IS NOT  NULL ) AND item_name like '%".$items[$counter]['item']."%'  ");									
									// print_r($test);
									// echo "physical_inventory LEFT JOIN assigns on ps_id = inventory_number","*", "inventory_number not IN(Select assigns_id from `assigns` where staff_id IS NULL AND staff_idN IS NULL  ) AND item_name like '%".$items[$counter]['item']."%'   ";
								echo "<td>";
									echo '<select name="'.$items[$counter]['item'].'" style="width:200px;" class="selectcss">';			
										echo "<option ></option>";						
										foreach( $test AS $c ){		
										
										echo "<option value=".$c['inventory_number']." >".strtolower($c['item_name'])." - ".$c['inventory_number']."</option>";							
										}
									echo '</select>';		
								echo "</td>";
							echo "</tr>"; 
			
					}
			
			?>
				<input type="hidden" value="<?php echo $alltype;?>" name="alltypevalue">
				<input type="hidden" value="<?php echo $_GET['itemName'];?>" name="itemName" id="itemName">
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Assign"></td>				
				<td colspan="4" align="center"><a href="assignment.php">Cancel</a></td>				
			</tr>	
		</table>	
	</form>
</div>
<?php
$table = "assigns INNER JOIN physical_inventory ON inventory_number = ps_id";
$field ="*";
$where = "ws_id =".$_GET['itemName'] ;
$assignedItems = $db->selectQuery($table, $field, $where, $add_sql="");
// print_r($assignedItems); concat(sFirst,' ',sLast) as name
$sizeofassign  = count($assignedItems);
$item_array = "";
if($sizeofassign > 0){

$getStafflist = $db->selectQuery("assigns", "staff_id, staff_idN", "ws_id =".$_GET['itemName'], $add_sql="");
// print_r($getStafflist);
?>
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="#">Assigned Item/s</a></li>
		<li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  id='opener' style="width:122px;">Edit</button></a></li>
		<li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  id='editNightButton' style="width:122px;">Edit- Night</button></a></li>
		<li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle" id='assignStaffbutton'>Assign To Staff</button></a></li>
		<li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  id='transferbutton' style="width:122px;">Transfer</button></a></li>
		<li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle" id='historybutton' style="width:122px;">History</button></a></li>
	</ul>
	<br/><br/>
<?php	
	$tableLabel = $db->selectSingleQuery("workstation", "label" , "workstation_id=".$_GET['itemName'], $add_sql="");
	echo "Table # : ".$tableLabel;
	echo "<div style='border:0px solid red; position:absolute; '>";
	$staffAssign = $db->selectSingleQueryArray("assigns Left JOIN staff ON uid  = staff_id", "CONCAT(sFirst,' ', sLast) AS name " , "ws_id=".$_GET['itemName'], $add_sql="");
	echo "Assigned To : <b>".$staffAssign['name']."</b>";
	echo '<div class="table-responsive">';
	echo "<div align='right' style='width:400px;'>";
	echo '<table border="0" class="table table-hover" style="width:400px;">';
	echo "<tr><th>Item</th><th>Label</th></tr>";
	foreach($assignedItems as $items) {
			echo "<tr><td>".$items['item_name'] ."</td><td>".$items['item_name'] ." - ".$items['inventory_number']."</td></tr>";
	}
	echo "</table>";
	echo "</div>";
	echo "</div>";
// echo $item_array;
	### NIGHT SHIFT
	echo "<div style='border:0px solid red; position:absolute; float: left;'>";
	echo "<b>Night Shift </b><br/><br/>";
	$staffAssign = $db->selectSingleQueryArray("assigns Left JOIN staff ON uid  = staff_idN", "CONCAT(sFirst,' ', sLast) AS name " , "ws_id=".$_GET['itemName'], $add_sql="");
	echo '<div class="table-responsive">';
	echo "<div align='right' style='width:400px;'>";
	echo '<table border="0" class="table table-hover" style="width:400px;">';
	echo "<tr><td>Assigned To</td><td>".$staffAssign['name']."</td></tr>";
	echo "<tr><th>Item</th><th>Label</th></tr>";
	foreach($assignedItems as $items) {
			echo "<tr><td>".$items['item_name'] ."</td><td>".$items['label'] ."</td></tr>";
	}
	echo "</table>";
	echo "</div>";
	echo "</div>";
}
else { 
	echo "
		<script type='text/javascript'>
			$('#div_id').css('display','block');
			// document.getElementById('div_id').style.display = 'block';
			// alert('eee');
		</script>
	";

}
?>


 
	
<?php }  require "includes/footer.php"; ?>