<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';
require 'endorsemen_tab.php';
if( !empty($_POST) ){
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
									$test = $db->selectQuery("physical_inventory","*","item_name like '%".$items[$counter]['item']."%' ");									
								echo "<td>";
									echo '<select name="'.$items[$counter]['item'].'" style="width:200px;" class="selectcss">';			
										echo "<option ></option>";						
										foreach( $test AS $c ){									
										echo "<option value=".$c['inventory_number']." >".$c['label']."</option>";							
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
// print_r($assignedItems);
$sizeofassign  = count($assignedItems);
$item_array = "";
if($sizeofassign > 1){
?>
	<ul class="nav nav-tabs">
	  <li role="presentation" class="active"><a href="#">Assigned Item/s</a></li>
	  <li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  id='opener' style="width:122px;">Edit</button></a></li>
	  <li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle" id='assignStaffbutton'>Assign To Staff</button></a></li>
	  <li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle"  id='transferbutton' style="width:122px;">Transfer</button></a></li>
	  <li role="presentation"><a href="#" style="padding:5px 2px; 1px 2px;"><button type='button' class="btn btn-info dropdown-toggle" id='historybutton' style="width:122px;">History</button></a></li>
	</ul>
	<br/><br/>
<?php	
	echo '<div class="table-responsive">';
	echo "<div align='right' style='width:400px;'>";
	echo '<table border="0" class="table table-hover" style="width:400px;">';
	echo "<tr><th>Item</th><th>Label</th></tr>";
	foreach($assignedItems as $items) {
			echo "<tr><td>".$items['item_name'] ."</td><td>".$items['label'] ."</td></tr>";
	}
	echo "</table>";
	echo "</div>";
echo $item_array;
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