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
<form action="" name="" method="POST">
		<table border="0" cellpadding="3" cellspacing="3">		
			<tr>
				<td>
					<label>Table #</label>
				</td>
				<td>
					<input type="text" name="table_no" id="table_no" />
				</td>
			</tr>		
			<tr>
				<td>
					<label>Staff</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("staff","*", "1 ORDER BY sLast");			
						echo '<select name="user_id" style="width:200px;">';
						echo "<option ></option>";
						foreach( $staff AS $c ):						
							echo "<option value=".$c['uid'].">".$c['sLast']." ".$c['sFirst']."</option>";													
						endforeach;
						echo '</select>';				
					?>				
				</td>
			</tr>			
			<tr>
				<td>
					<label>Avr</label>
				</td>
				<td>
					<?php 												
						// $staff = $db->selectQuery("avr","*","avr_id not IN(Select assign_avrid from `assignments`)  ORDER BY avr_id");			
						$staff = $db->selectQuery("avr","*","avr_id not IN(Select assign_avrid from `assignments` where assign_avrid <> 0)  ORDER BY avr_id");			
						echo '<select name="avr_id" style="width:200px;">';			
						echo "<option ></option>";						
						foreach( $staff AS $c ):						
							echo "<option value=".$c['avr_id']." >".$c['avr_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>		
				</td>
			</tr>			
			<tr>
				<td>
					<label>Cpu</label>
				</td>
				<td>
					<?php 
						
						$staff = $db->selectQuery("cpu","*", "cpu_id not IN(Select assign_cpuid from `assignments` where assign_cpuid <> 0)  ORDER BY cpu_id");			
						echo '<select name="cpu_id" style="width:200px;">';				
						echo "<option ></option>";						
						foreach( $staff AS $c ):							
							echo "<option value=".$c['cpu_id'].">".$c['cpu_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Hardphone</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("hardphone","*", "hardphone_id not IN(Select assign_hardphoneid from `assignments`  where assign_hardphoneid <> 0)  ORDER BY hardphone_id");			
						echo '<select name="hardphone_id" style="width:200px;">';					
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['hardphone_id'].">".$c['hardphone_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Headset</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("headset","*", "headset_id not IN(Select assign_headsetid from `assignments` where assign_headsetid <> 0) ORDER BY headset_id");			
						echo '<select name="headset_id" style="width:200px;">';					
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['headset_id'].">".$c['headset_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Keyboard</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("keyboard","*", "keyboard_id not IN(Select assign_keyboardid from `assignments` where assign_keyboardid <> 0)  ORDER BY keyboard_id");			
						echo '<select name="keyboard_id" style="width:200px;">';				
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['keyboard_id'].">".$c['keyboard_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>								
			<tr>
				<td>
					<label>Monitor</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("monitor","*", "monitor_id not IN(Select assign_monitorid from `assignments` where assign_monitorid <> 0)  ORDER BY monitor_id");			
						echo '<select name="monitor_id" style="width:200px;">';						
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['monitor_id'].">".$c['monitor_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>			
				<tr>
					<td>
						<label>Mouse</label>
					</td>
					<td>
						<?php 
						$staff = $db->selectQuery("mouse","*", "mouse_id not IN(Select assign_mouseid from `assignments` where assign_mouseid <> 0) ORDER BY mouse_id");			
						echo '<select name="mouse_id" style="width:200px;">';						
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['mouse_id'].">".$c['mouse_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Printer</label>
				</td>
				<td>
						<?php 
						$staff = $db->selectQuery("printer","*", "printer_id not IN(Select assign_printerid from `assignments`  where assign_printerid <> 0)  ORDER BY printer_id");			
						echo '<select name="printer_id" style="width:200px;">';					
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['printer_id'].">".$c['printer_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Tablet</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("tablet","*", "tablet_id not IN(Select assign_tabletid from `assignments` where assign_tabletid <> 0) ORDER BY tablet_id");			
						echo '<select name="tablet_id" style="width:200px;">';						
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['tablet_id'].">".$c['tablet_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Ups</label>
				</td>
				<td>
					<?php 
						$staff = $db->selectQuery("ups","*", "ups_id not IN(Select assign_upsid from `assignments` where assign_upsid <> 0) ORDER BY ups_id");			
						echo '<select name="ups_id" style="width:200px;">';				
						echo "<option ></option>";
						foreach( $staff AS $c ):							
							echo "<option value=".$c['ups_id'].">".$c['ups_label']."</option>";							
						endforeach;
						echo '</select>';				
					?>	
				</td>
			</tr>		
			<tr>
				<td>
					<label>Chair #</label>
				</td>
				<td>
					<input type="text" name="chair_no" id="chair_no" />
				</td>
			</tr>				
			<tr>				
				<td colspan="4" align="center"><input type="submit" name="assignnow" id="assignnow" placeholder="Brand" style="width:100px; height:30px;" value="Assign"></td>				
				<td colspan="4" align="center"><a href="assignment.php">Cancel</a></td>				
			</tr>	
		</table>	
	</form>
	
	
<?php }  require "includes/footer.php"; ?>