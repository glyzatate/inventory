<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<!--<input type="submit" value="Add Monitor" /> <br/><hr>-->
	<h1>Monitor</h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width='100px'>Monitor Label</th>
			<th width='100px'>Invoice No.</th>
			<th width='100px'>Monitor Brand</th>
			<th width='100px'>Monitor Model</th>
			<th width='100px'>Monitor Serial</th>
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$monitor = $db->selectQuery("monitor","*", "1");			
			foreach( $monitor AS $c ):
				echo '<tr >';			
				$monitorID = $c['monitor_id'];				
		
				$monitorID = $c['monitor_id'];		
				$where = "assign_monitorid = ".$monitorID;
				$fields = "COUNT(assign_id) as total";								
				$details =	$db->selectSingleQueryArray("assignments", $fields , $where);						
				if($details['total'] > 0)
					echo "<td width='100px'><a href='monitordetails.php?id=".$monitorID."' >".$c['monitor_label']."</a></td>";
				else
					echo "<td width='100px'>".$c['monitor_label']."</td>";				
				echo "<td width='100px'>".$c['monitor_invoiceno']."</td>";
				echo "<td width='100px'>".$c['monitor_brand']."</td>";
				echo "<td width='100px'>".$c['monitor_model']."</td>";
				echo "<td width='100px'>".$c['monitor_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>

