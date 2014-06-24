<?php 


require 'config.php'; 
$err = false;
if( !empty($_POST) ){	
	$insertArr_mouse = array();
	$insertArr_mouse['mouse_brand'] = $_POST['mouse_brand'];
	$insertArr_mouse['mouse_model'] = $_POST['mouse_model'];
	$insertArr_mouse['mouse_serial'] = $_POST['mouse_serial'];
	$mouse_id = $db->insertQuery('mouse', $insertArr_mouse);
	
	$insertArr_keyboard = array();
	$insertArr_keyboard['keyboard_brand'] = $_POST['keyboard_brand'];
	$insertArr_keyboard['keyboard_model'] = $_POST['keyboard_model'];
	$insertArr_keyboard['keyboard_serial'] = $_POST['keyboard_serial'];
	$keyboard_id = $db->insertQuery('keyboard', $insertArr_keyboard);
	
	$insertArr_cpu = array();
	$insertArr_cpu['cpu_brand'] = $_POST['cpu_brand'];
	$insertArr_cpu['cpu_model'] = $_POST['cpu_model'];
	$insertArr_cpu['cpu_serial'] = $_POST['cpu_serial'];
	$cpu_id = $db->insertQuery('cpu', $insertArr_cpu);
	
	$insertArr_monitor = array();
	$insertArr_monitor['monitor_brand'] = $_POST['monitor_brand'];
	$insertArr_monitor['monitor_model'] = $_POST['monitor_model'];
	$insertArr_monitor['monitor_serial'] = $_POST['monitor_serial'];
	$monitor_id = $db->insertQuery('monitor', $insertArr_monitor); 
	
	$insertArr_headset = array();
	$insertArr_headset['headset_brand'] = $_POST['headset_brand'];
	$insertArr_headset['headset_model'] = $_POST['headset_model'];
	$insertArr_headset['headset_serial'] = $_POST['headset_serial'];
	$headset_id = $db->insertQuery('headset', $insertArr_headset); 
	
	$insertArr_hardphone = array();
	$insertArr_hardphone['hardphone_brand'] = $_POST['hardphone_brand'];
	$insertArr_hardphone['hardphone_model'] = $_POST['hardphone_model'];
	$insertArr_hardphone['hardphone_serial'] = $_POST['hardphone_serial'];
	$hardphone_id = $db->insertQuery('hardphone', $insertArr_hardphone); 
	
	$insertArr_tablet = array();
	$insertArr_tablet['tablet_brand'] = $_POST['tablet_brand'];
	$insertArr_tablet['tablet_model'] = $_POST['tablet_model'];
	$insertArr_tablet['tablet_serial'] = $_POST['tablet_serial'];
	$tablet_id = $db->insertQuery('tablet', $insertArr_tablet); 
	
	$insertArr_avr = array();
	$insertArr_avr['avr_brand'] = $_POST['avr_brand'];
	$insertArr_avr['avr_model'] = $_POST['avr_model'];
	$insertArr_avr['avr_serial'] = $_POST['avr_serial'];
	$avr_id = $db->insertQuery('avr', $insertArr_avr); 
	
	$insertArr_ups = array();
	$insertArr_ups['ups_brand'] = $_POST['ups_brand'];
	$insertArr_ups['ups_model'] = $_POST['ups_model'];
	$insertArr_ups['ups_serial'] = $_POST['ups_serial'];
	$ups_id = $db->insertQuery('ups', $insertArr_ups); 
	
	$insertArr_printer = array();
	$insertArr_printer['printer_brand'] = $_POST['printer_brand'];
	$insertArr_printer['printer_model'] = $_POST['printer_model'];
	$insertArr_printer['printer_serial'] = $_POST['printer_serial'];
	$printer_id = $db->insertQuery('printer', $insertArr_printer); 
	
	
	
	if( $_POST['catType'] == 'subCat' )
		$insertArr['parentID'] = $_POST['category'];
	
	$id = $db->insertQuery('editingCategory', $insertArr);
	if( $id ){
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
	
	<form action="" name="addinventorForm" >
		<table border="0" cellpadding="3" cellspacing="3">
			<tr>
				<td>Invoice No.</td>
				<td><input type="text" name="" id="" /></td>
			</tr>		
			<tr>
				<td>Supplier</td>
				<td><input type="text" name="" id="" /></td>
			</tr>	
			<tr>
				<td>Mouse</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			
			<tr>
				<td>Keyboard</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>CPU</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Monitor</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Headset</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>				
			<tr>
				<td>Hardphone</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Tablet</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>AVR</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>UPS</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Printer</td>
				<td><input type="text" name="" id="" placeholder="Brand" /></td>
				<td><input type="text" name="" id="" placeholder="Model"/></td>
				<td><input type="text" name="" id="" placeholder="Serial"/></td>
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
