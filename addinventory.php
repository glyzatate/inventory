<?php 


require 'config.php'; 
$err = false;
if( !empty($_POST) ){
	$insertArr_mouse = array();
	$insertArr_mouse['mouse_brand'] = $_POST['mouse_brand'];
	$insertArr_mouse['mouse_model'] = $_POST['mouse_model'];
	$insertArr_mouse['mouse_serial'] = $_POST['mouse_serial'];
	if( !empty($insertArr_mouse) )
		$mouseId = $db->insertQuery('mouse', $insertArr_mouse);

	$insertArr_keyboard = array();
	$insertArr_keyboard['keyboard_brand'] = $_POST['keyboard_brand'];
	$insertArr_keyboard['keyboard_model'] = $_POST['keyboard_model'];
	$insertArr_keyboard['keyboard_serial'] = $_POST['keyboard_serial'];
	if( !empty($insertArr_keyboard) )
		$keyboardId = $db->insertQuery('keyboard', $insertArr_keyboard);
	
	$insertArr_cpu = array();
	$insertArr_cpu['cpu_brand'] = $_POST['cpu_brand'];
	$insertArr_cpu['cpu_model'] = $_POST['cpu_model'];
	$insertArr_cpu['cpu_serial'] = $_POST['cpu_serial'];
	if( !empty($insertArr_cpu) )
		$cpuId = $db->insertQuery('cpu', $insertArr_cpu);	
	
	$insertArr_monitor = array();
	$insertArr_monitor['monitor_brand'] = $_POST['monitor_brand'];
	$insertArr_monitor['monitor_model'] = $_POST['monitor_model'];
	$insertArr_monitor['monitor_serial'] = $_POST['monitor_serial'];
	if( !empty($insertArr_monitor) )
		$monitorId = $db->insertQuery('monitor', $insertArr_monitor); 
	
	$insertArr_headset = array();
	$insertArr_headset['headset_brand'] = $_POST['headset_brand'];
	$insertArr_headset['headset_model'] = $_POST['headset_model'];
	$insertArr_headset['headset_serial'] = $_POST['headset_serial'];
	if( !empty($insertArr_headset) )
		$headsetId = $db->insertQuery('headset', $insertArr_headset); 
	
	$insertArr_hardphone = array();
	$insertArr_hardphone['hardphone_brand'] = $_POST['hardphone_brand'];
	$insertArr_hardphone['hardphone_model'] = $_POST['hardphone_model'];
	$insertArr_hardphone['hardphone_serial'] = $_POST['hardphone_serial'];
	if( !empty($insertArr_hardphone) )
		$hardphoneId = $db->insertQuery('hardphone', $insertArr_hardphone); 
	
	$insertArr_tablet = array();
	$insertArr_tablet['tablet_brand'] = $_POST['tablet_brand'];
	$insertArr_tablet['tablet_model'] = $_POST['tablet_model'];
	$insertArr_tablet['tablet_serial'] = $_POST['tablet_serial'];
	if( !empty($insertArr_tablet) )
		$tabletId = $db->insertQuery('tablet', $insertArr_tablet); 
	
	$insertArr_avr = array();
	$insertArr_avr['avr_brand'] = $_POST['avr_brand'];
	$insertArr_avr['avr_model'] = $_POST['avr_model'];
	$insertArr_avr['avr_serial'] = $_POST['avr_serial'];
	if( !empty($insertArr_avr) )
		$avrId = $db->insertQuery('avr', $insertArr_avr); 
	
	$insertArr_ups = array();
	$insertArr_ups['ups_brand'] = $_POST['ups_brand'];
	$insertArr_ups['ups_model'] = $_POST['ups_model'];
	$insertArr_ups['ups_serial'] = $_POST['ups_serial'];
	if( !empty($insertArr_avr) )
		$upsId = $db->insertQuery('ups', $insertArr_ups); 
	
	$insertArr_printer = array();
	$insertArr_printer['printer_brand'] = $_POST['printer_brand'];
	$insertArr_printer['printer_model'] = $_POST['printer_model'];
	$insertArr_printer['printer_serial'] = $_POST['printer_serial'];
	if( !empty($insertArr_printer) )
		$printerId = $db->insertQuery('printer', $insertArr_printer); 
	
	$insertArr_invoice = array();
	$insertArr_invoice['invoice_no'] = $_POST['invoice_no'];
	$insertArr_invoice['supplier_name'] = $_POST['supplier_name'];
	$insertArr_invoice['invoice_date'] = $_POST['invoice_date'];
	$insertArr_invoice['mouseId'] = $mouseId;
	$insertArr_invoice['keyboardId'] = $keyboardId;
	$insertArr_invoice['cpuId'] = $cpuId;
	$insertArr_invoice['monitorId'] = $monitorId;
	$insertArr_invoice['headsetId'] = $headsetId;	
	$insertArr_invoice['hardphoneId'] = $hardphoneId;
	$insertArr_invoice['tabletId'] = $tabletId;
	$insertArr_invoice['avrId'] = $avrId;
	$insertArr_invoice['upsId'] = $upsId;
	$insertArr_invoice['printerId'] = $printerId;
	
	if( !empty($insertArr_invoice) )
		$invoiceId = $db->insertQuery('invoices', $insertArr_invoice);  
	
	
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
	
	<form action="" name="addinventorForm" method="POST">
		<table border="0" cellpadding="3" cellspacing="3">
			<tr>
				<td>Invoice No.</td>
				<td><input type="text" name="invoice_no" id="invoice_no" /></td>
			</tr>	
			<tr>
				<td>Invoice Date</td>
				<td><input type="text" name="invoice_date" id="invoice_date" /></td>
			</tr>		
			<tr>
				<td>Supplier</td>
				<td colspan="4"><input type="text" name="supplier_name" id="supplier_name" style="width:480px;"/></td>
			</tr>	
			<tr>
				<td>Mouse</td>
				<td><input type="text" name="mouse_brand" id="mouse_brand" placeholder="Brand" /></td>
				<td><input type="text" name="mouse_model" id="mouse_model" placeholder="Model"/></td>
				<td><input type="text" name="mouse_serial" id="mouse_serial" placeholder="Serial"/></td>
			</tr>
			
			<tr>
				<td>Keyboard</td>
				<td><input type="text" name="keyboard_brand" id="keyboard_brand" placeholder="Brand" /></td>
				<td><input type="text" name="keyboard_model" id="keyboard_model" placeholder="Model"/></td>
				<td><input type="text" name="keyboard_serial" id="keyboard_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>CPU</td>
				<td><input type="text" name="cpu_brand" id="cpu_brand" placeholder="Brand" /></td>
				<td><input type="text" name="cpu_model" id="cpu_model" placeholder="Model"/></td>
				<td><input type="text" name="cpu_serial" id="cpu_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Monitor</td>
				<td><input type="text" name="monitor_brand" id="monitor_brand" placeholder="Brand" /></td>
				<td><input type="text" name="monitor_model" id="monitor_model" placeholder="Model"/></td>
				<td><input type="text" name="monitor_serial" id="monitor_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Headset</td>
				<td><input type="text" name="headset_brand" id="headset_brand" placeholder="Brand" /></td>
				<td><input type="text" name="headset_model" id="headset_model" placeholder="Model"/></td>
				<td><input type="text" name="headset_serial" id="headset_serial" placeholder="Serial"/></td>
			</tr>				
			<tr>
				<td>Hardphone</td>
				<td><input type="text" name="hardphone_brand" id="hardphone_brand" placeholder="Brand" /></td>
				<td><input type="text" name="hardphone_model" id="hardphone_model" placeholder="Model"/></td>
				<td><input type="text" name="hardphone_serial" id="hardphone_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Tablet</td>
				<td><input type="text" name="tablet_brand" id="tablet_brand" placeholder="Brand" /></td>
				<td><input type="text" name="tablet_model" id="tablet_model" placeholder="Model"/></td>
				<td><input type="text" name="tablet_serial" id="tablet_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>AVR</td>
				<td><input type="text" name="avr_brand" id="avr_brand" placeholder="Brand" /></td>
				<td><input type="text" name="avr_model" id="avr_model" placeholder="Model"/></td>
				<td><input type="text" name="avr_serial" id="avr_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>UPS</td>
				<td><input type="text" name="ups_brand" id="ups_brand" placeholder="Brand" /></td>
				<td><input type="text" name="ups_model" id="ups_model" placeholder="Model"/></td>
				<td><input type="text" name="ups_serial" id="ups_serial" placeholder="Serial"/></td>
			</tr>
			<tr>
				<td>Printer</td>
				<td><input type="text" name="printer_brand" id="printer_brand" placeholder="Brand" /></td>
				<td><input type="text" name="printer_model" id="printer_model" placeholder="Model"/></td>
				<td><input type="text" name="printer_serial" id="printer_serial" placeholder="Serial"/></td>
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
