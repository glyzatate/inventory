<?php 
$detailss = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
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

<?php  
$details = $db->selectQuery("users","", $where,$addON);				

?>


	<table border="1" >
		<tr align="center">
			<th width='200px'>Time Stamp</th>			
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
		$addON = "LEFT JOIN users ON  userID= assign_userid LEFT JOIN avr ON  avr_id = assign_avrid LEFT  JOIN ups ON  ups_id = assign_upsid LEFT  JOIN monitor ON  monitor_id = assign_monitorid  LEFT  JOIN cpu ON  cpu_id = assign_cpuid LEFT  JOIN keyboard ON  keyboard_id = assign_keyboardid LEFT  JOIN mouse ON  mouse_id = assign_mouseid LEFT  JOIN hardphone ON  hardphone_id = assign_hardphoneid LEFT  JOIN headset ON  headset_id = assign_headsetid  LEFT  JOIN printer ON  printer_id = assign_printerid LEFT  JOIN tablet ON  tablet_id = assign_tabletid ";
		$where = "assign_userid = ".$_GET['userid'];
		$fields = "assign_timestamp,assign_userid,lastName,firstName,table_no,monitor_label,cpu_label, keyboard_label, mouse_label,avr_label, hardphone_label,headset_label, printer_brand,tablet_label,assign_chair";
		$details = $db->selectQuery("assignments",$fields, $where,$addON);				
			foreach( $details AS $detail ):
				echo '<tr >';				
				echo "<td >".$detail['assign_timestamp']."</td>";				
				echo "<td width='100px'>".$detail['table_no']."</td>";
				echo "<td width='100px'>".$detail['monitor_label']."</td>";
				echo "<td width='100px'>".$detail['cpu_label']."</td>";
				echo "<td width='100px'>".$detail['keyboard_label']."</td>";
				echo "<td width='100px'>".$detail['mouse_label']."</td>";
				echo "<td width='100px'>".$detail['avr_label']."</td>";
				echo "<td width='100px'>".$detail['hardphone_label']."</td>";
				echo "<td width='100px'>".$detail['headset_label']."</td>";
				echo "<td width='100px'>".$detail['printer_brand']."</td>";
				echo "<td width='100px'>".$detail['tablet_label']."</td>";
				echo "<td width='100px'>".$detail['headset_label']."</td>";
				echo "<td width='100px'>".$detail['ups_brand']."</td>";
				echo "<td width='100px'>".$detail['assign_chair']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>

	
	
<?php }  require "includes/footer.php"; ?>