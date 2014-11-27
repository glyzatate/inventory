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
<h3>Tablet Details</h3>
<?php 			
		$where = "tablet_id = ".$_GET['id'];				
		$details = $db->selectSingleQueryArray("tablet","*", $where,"");				

		?>				
<table border="0">
	<?php echo '
		<tr bgcolor="#E0E0E0">
			<td width="20%">Tablet Label</td>		
			<td>:<td>
			<td >'.$details["tablet_label"].'</td>			
		</tr>
		<tr>
			<td >Tablet Brand</td>		
			<td>:<td>
			<td >'.$details["tablet_brand"].'</td>			
		</tr>
		<tr bgcolor="#E0E0E0">
			<td >Tablet Model</td>		
			<td>:<td>
			<td >'.$details["tablet_model"].'</td>			
		</tr>
		<tr>
			<td >Tablet Serial</td>		
			<td>:<td>
			<td >'.$details["tablet_serial"].'</td>			
		</tr>
	</table>'; ?>	
<hr>



<h3>Tablet Assignment History</h3>
	<table border="1" >
		<tr align="center">
			<th width='200px'>Time Stamp</th>						
			<th width='200px'>Last Name</th>
			<th width='200px'>First Name</th>
			<th width='100px'>Table #</th>
			<th width='100px'>Assigned By</th>
		</tr>

		<?php 
		$addON = "LEFT JOIN staff ON  uid = assign_userid LEFT  JOIN tablet ON  tablet_id = assign_tabletid";
		$where = "assign_tabletid = ".$_GET['id'];
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
		?>				
	</table>

	
	
<?php }  require "includes/footer.php"; ?>