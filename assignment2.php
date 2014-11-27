<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';
if( !empty($_POST) ){
	$insertArr_invoice = array();
	$insertArr_invoice['table_no'] = $_POST['table_no'];
	$insertArr_invoice['assign_userid'] = $_POST['user_id'];
	$insertArr_invoice['assign_avrid'] = $_POST['avr_id'];
	$insertArr_invoice['assign_cpuid'] = $_POST['cpu_id'];
	$insertArr_invoice['assign_hardphoneid'] = $_POST['hardphone_id'];
	$insertArr_invoice['assign_headsetid'] = $_POST['headset_id'];
	$insertArr_invoice['assign_keyboardid'] = $_POST['keyboard_id'];
	$insertArr_invoice['assign_monitorid'] = $_POST['monitor_id'];
	$insertArr_invoice['assign_mouseid'] = $_POST['mouse_id'];
	$insertArr_invoice['assign_printerid'] = $_POST['printer_id'];
	$insertArr_invoice['assign_tabletid'] = $_POST['tablet_id'];
	$insertArr_invoice['assign_upsid'] = $_POST['ups_id'];
	$insertArr_invoice['assign_chair'] = $_POST['chair_no'];
	$insertArr_invoice['assign_assignedby'] = $user->getUID();
	$insertArr_invoice['assign_status'] =1;
	
	if( !empty($insertArr_invoice) )
		$invoiceId = $db->insertQuery('assignments', $insertArr_invoice);  
	
	
	if( $id ){
		echo "<script> parent.$.fn.colorbox.close(); parent.window.location.reload();  </script>";
	}else{
		$err = true;
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
<table border="0" width="25%">
		<tr align="center">
			<td ><a href="#adminroom" >View Active List </a></td>
			<td>|</td>
			<td ><a href="#callroom" >Inactive List</a></td>			
		</tr>
	</table>	
<hr>


	<table border="1" >
		<tr align="center">
			<th width='200px'>Last Name</th>
			<th width='200px'>First Name</th>
			<th width='100px'>Table #</th>
			<th width='100px'>Monitor</th>
			<th width='100px'>CPU</th>
			<th width='100px'>Keyboard</th>
			<th width='100px'>Mouse</th>
			<th width='100px'>AVR</th>
			<th width='100px'>hardphone</th>
			<th width='100px'>headset</th>
			<th width='100px'>printer</th>
			<th width='100px'>tablet</th>
			<th width='100px'>Pen</th>
			<th width='100px'>ups</th>
			<th width='100px'>chair</th>
		</tr>

		<?php 
			$addON = "LEFT JOIN staff ON  uid = assign_userid LEFT JOIN avr ON  avr_id = assign_avrid LEFT  JOIN ups ON  ups_id = assign_upsid LEFT  JOIN monitor ON  monitor_id = assign_monitorid  LEFT  JOIN cpu ON  cpu_id = assign_cpuid LEFT  JOIN keyboard ON  keyboard_id = assign_keyboardid LEFT  JOIN mouse ON  mouse_id = assign_mouseid LEFT  JOIN hardphone ON  hardphone_id = assign_hardphoneid LEFT  JOIN headset ON  headset_id = assign_headsetid  LEFT  JOIN printer ON  printer_id = assign_printerid LEFT  JOIN tablet ON  tablet_id = assign_tabletid ";
			$fields = "assign_userid,sLast,sFirst,table_no,monitor_label,cpu_label, keyboard_label, mouse_label,avr_label, hardphone_label,headset_label, printer_brand,tablet_label,assign_chair";
			$mouse = $db->selectQuery("assignments",$fields, "1 ORDER BY table_no asc",$addON);			
			foreach( $mouse AS $c ):
				echo '<tr >';				
				echo "<td ><a href='employeehistory.php?userid=".$c['assign_userid']."'>".$c['sLast']."</a></td>";
				echo "<td width='100px'>".$c['sFirst']."</td>";
				echo "<td width='100px'>".$c['table_no']."</td>";
				echo "<td width='100px'>".$c['monitor_label']."</td>";
				echo "<td width='100px'>".$c['cpu_label']."</td>";
				echo "<td width='100px'>".$c['keyboard_label']."</td>";
				echo "<td width='100px'>".$c['mouse_label']."</td>";
				echo "<td width='100px'>".$c['avr_label']."</td>";
				echo "<td width='100px'>".$c['hardphone_label']."</td>";
				echo "<td width='100px'>".$c['headset_label']."</td>";
				echo "<td width='100px'>".$c['printer_brand']."</td>";
				echo "<td width='100px'>".$c['tablet_label']."</td>";
				echo "<td width='100px'>".$c['headset_label']."</td>";
				echo "<td width='100px'>".$c['ups_brand']."</td>";
				echo "<td width='100px'>".$c['assign_chair']."</td>";
				echo '</tr>';				
			endforeach; 
		?>				
	</table>
	</div>

	
	
<?php }  require "includes/footer.php"; ?>