<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<!--<input type="submit" value="Add Avr" /> <br/><hr>-->
	<h1>Avr</h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width='100px'>Avr Label</th>
			<th width='100px'>Invoice No.</th>
			<th width='100px'>Avr Brand</th>
			<th width='100px'>Avr Model</th>
			<th width='100px'>Avr Serial</th>		
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$avr = $db->selectQuery("avr","*", "1");			
			foreach( $avr AS $c ):
				echo '<tr >';			
				$avrID = $c['avr_id'];				
		
				$avrID = $c['avr_id'];		
				$where = "assign_avrid = ".$avrID;
				$fields = "COUNT(assign_id) as total";								
				$details =	$db->selectSingleQueryArray("assignments", $fields , $where);						
				if($details['total'] > 0)
					echo "<td width='100px'><a href='avrdetails.php?id=".$avrID."' >".$c['avr_label']."</a></td>";
				else
					echo "<td width='100px'>".$c['avr_label']."</td>";
				echo "<td width='100px'>".$c['avr_invoiceno']."</td>";
				echo "<td width='100px'>".$c['avr_brand']."</td>";
				echo "<td width='100px'>".$c['avr_model']."</td>";
				echo "<td width='100px'>".$c['avr_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>


