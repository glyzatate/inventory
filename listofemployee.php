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
<h4>List of Employee</h4>	
	
	<table border="1" >
		<tr align="center">
			<th width='200px'>Last Name</th>
			<th width='200px'>First Name</th>	
		</tr>

		<?php 
			$fields = "*";
			$mouse = $db->selectQuery("staff",$fields, " 1 order by sLast");

			foreach( $mouse AS $c ):
				echo '<tr >';				
				echo "<td ><a href='employeehistory.php?userid=".$c['uid']."'>".$c['sLast']."</a></td>";
				echo "<td width='100px'>".$c['sFirst']."</td>";			
				echo '</tr>';				
			endforeach; 
		?>				
	</table>
	

	
	
<?php }  require "includes/footer.php"; ?>