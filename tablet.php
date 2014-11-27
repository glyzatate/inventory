<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<!--<input type="submit" value="Add Tablet" /> <br/><hr>-->
	<h1>Tablet</h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width='100px'>Tablet Label</th>
			<th width='100px'>Invoice No.</th>
			<th width='100px'>Tablet Brand</th>
			<th width='100px'>Tablet Model</th>
			<th width='100px'>Tablet Serial</th>			
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$tablet = $db->selectQuery("tablet","*", "1");			
			foreach( $tablet AS $c ):
				echo '<tr >';			
				$tabletID = $c['tablet_id'];				
		
				$tabletID = $c['tablet_id'];		
				$where = "assign_tabletid = ".$tabletID;
				$fields = "COUNT(assign_id) as total";								
				$details =	$db->selectSingleQueryArray("assignments", $fields , $where);						
				if($details['total'] > 0)
					echo "<td width='100px'><a href='tabletdetails.php?id=".$tabletID."' >".$c['tablet_label']."</a></td>";
				else
					echo "<td width='100px'>".$c['tablet_label']."</td>";
				echo "<td width='100px'>".$c['tablet_invoiceno']."</td>";
				echo "<td width='100px'>".$c['tablet_model']."</td>";
				echo "<td width='100px'>".$c['tablet_model']."</td>";
				echo "<td width='100px'>".$c['tablet_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>


