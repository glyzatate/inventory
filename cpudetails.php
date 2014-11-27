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
<h3>CPU Details</h3>
<?php 			
		$where = "cpu_id = ".$_GET['id'];				
		$details = $db->selectSingleQueryArray("cpu","*", $where,"");				

		?>				
<table border="0">
	<?php echo '
		<tr bgcolor="#E0E0E0">
			<td width="20%">cpu Label</td>		
			<td>:<td>
			<td >'.$details["cpu_label"].'</td>			
		</tr>
		<tr>
			<td >cpu Brand</td>		
			<td>:<td>
			<td >'.$details["cpu_brand"].'</td>			
		</tr>
		<tr bgcolor="#E0E0E0">
			<td >cpu Model</td>		
			<td>:<td>
			<td >'.$details["cpu_model"].'</td>			
		</tr>
		<tr>
			<td >cpu Serial</td>		
			<td>:<td>
			<td >'.$details["cpu_serial"].'</td>			
		</tr>
	</table>'; ?>	
<hr>



<h3>CPU Assignment History</h3>
	<table border="1" >
		<tr align="center">
			<th width='200px'>Time Stamp</th>						
			<th width='200px'>Last Name</th>
			<th width='200px'>First Name</th>
			<th width='100px'>Table #</th>
			<th width='100px'>Assigned By</th>
		</tr>

		<?php 
		$addON = "LEFT JOIN staff ON  uid = assign_userid LEFT  JOIN cpu ON  cpu_id = assign_cpuid";
		$where = "assign_cpuid = ".$_GET['id'];
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