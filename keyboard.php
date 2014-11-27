<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<!--<input type="submit" value="Add Keyboard" /> <br/><hr>-->
	<h1>Keyboard</h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width='100px'>Keyboard Label</th>
			<th width='100px'>Invoice No.</th>
			<th width='100px'>Keyboard Brand</th>
			<th width='100px'>Keyboard Model</th>
			<th width='100px'>Keyboard Serial</th>
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$keyboard = $db->selectQuery("keyboard","*", "1");			
			foreach( $keyboard AS $c ):
				echo '<tr >';			
				$keyboardID = $c['keyboard_id'];				
		
				$keyboardID = $c['keyboard_id'];		
				$where = "assign_keyboardid = ".$keyboardID;
				$fields = "COUNT(assign_id) as total";								
				$details =	$db->selectSingleQueryArray("assignments", $fields , $where);						
				if($details['total'] > 0)
					echo "<td width='100px'><a href='keyboarddetails.php?id=".$keyboardID."' >".$c['keyboard_label']."</a></td>";
				else
					echo "<td width='100px'>".$c['keyboard_label']."</td>";
				echo "<td width='100px'>".$c['keyboard_brand']."</td>";
				echo "<td width='100px'>".$c['keyboard_brand']."</td>";
				echo "<td width='100px'>".$c['keyboard_model']."</td>";
				echo "<td width='100px'>".$c['keyboard_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>

