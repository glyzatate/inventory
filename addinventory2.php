<?php 


require 'config.php'; 
$err = false;
if( !empty($_POST) ){
	$insertArr_input = array();
	$insertArr_input['invoice_number'] = $_POST['invoice_number'];
	$insertArr_input['invoice_date'] = $_POST['invoice_date'];
	$insertArr_input['supplier'] = $_POST['supplier'];
	$insertArr_input['item_name'] = $_POST['item_name'];	
	$insertArr_input['label'] = $_POST['label'];
	$insertArr_input['brand'] = $_POST['brand'];
	$insertArr_input['serial'] = $_POST['serial'];
	$insertArr_input['model'] = $_POST['model'];
	$insertArr_input['condition'] = $_POST['condition'];
	$insertArr_input['remarks'] = $_POST['remarks'];
	
	if( !empty($insertArr_input) )
		$invoiceId = $db->insertQuery('physical_inventory', $insertArr_input);  
	
	
	if( $invoiceId ){
		echo "<script> parent.$.fn.colorbox.close(); parent.window.location.reload();  </script>";
	}else{
		$err = true;
	}
}


$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<hr>

	<form action="" name="addinventorForm" method="POST">
		<table border="0" cellpadding="3" cellspacing="3">
			<tr>
				<td>Invoice No.</td>
				<td><input type="text" name="invoice_number" id="invoice_number" style=" width: 310px;"/></td>
			</tr>	
			<tr>
				<td>Invoice Date</td>
				<td><input type="text" name="invoice_date" id="invoice_date" style=" width: 310px;"/></td>
			</tr>		
			<tr>
				<td>Supplier</td>
				<td><input type="text" name="supplier" id="supplier" style=" width: 310px;"/></td>
			</tr>	
			<tr>
				<td>Iteam Name</td>
				<td><input type="text" name="item_name" id="item_name" style=" width: 310px;" /></td>			
			</tr>
			
			<tr>
				<td>Inventory Label</td>
				<td><input type="text" name="label" id="label" style=" width: 310px;" /></td>		
			</tr>
			<tr>
				<td>Brand</td>
				<td><input type="text" name="brand" id="brand" style=" width: 310px;" /></td>		
			</tr>
			<tr>
				<td>Serial</td>
				<td><input type="text" name="serial" id="serial" style=" width: 310px;" /></td>		
			</tr>
			<tr>
				<td>Model</td>
				<td><input type="text" name="model" id="model" style=" width: 310px;" /></td>		
			</tr>				
			<tr>
				<td>Condition</td>
				<td><textarea type="text" name="condition" id="condition" style="margin: 0px; width: 310px; height: 83px;"></textarea></td>				
			</tr>
			<tr>
				<td>Remarks</td>
				<td><textarea type="text" name="remarks" id="remarks" style="margin: 0px; width: 310px; height: 83px;"></textarea></td>				
			</tr>			
			<tr>
				<td></td>				
			</tr>	
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="" id="" placeholder="Brand" style="width:100px; height:30px;" value="Submit"></td>				
			</tr>	
		</table>	
	</form>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php }  require "includes/footer.php"; ?>
<script type="text/javascript">
	function nRead( nID ){
		window.location.href="http://employee.tatepublishing.net/index.php?nRead="+nID;
	}
</script>

