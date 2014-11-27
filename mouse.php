<?php 

$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	
	<a href="addmouse.php" ><input type="submit" value="Add Mouse" /> </a><br/><hr>
	<h1>Mouse </h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width='100px'>Mouse Label</th>
			<th width='100px'>Invoice No.</th>
			<th width='100px'>Mouse Brand</th>
			<th width='100px'>Mouse Model</th>
			<th width='100px'>Mouse Serial</th>
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	

	<table border="1" width="750px">
		<?php 
			$mouse = $db->selectQuery("mouse","*", "1");			
			foreach( $mouse AS $c ):
				echo '<tr >';			
				$mouseID = $c['mouse_id'];				
		
				$mouseID = $c['mouse_id'];		
				$where = "assign_mouseid = ".$mouseID;
				$fields = "COUNT(assign_id) as total";								
				$details =	$db->selectSingleQueryArray("assignments", $fields , $where);						
				if($details['total'] > 0)
					echo "<td width='100px'><a href='mousedetails.php?id=".$mouseID."' >".$c['mouse_label']."</a></td>";
				else
					echo "<td width='100px'>".$c['mouse_label']."</td>";
				echo "<td width='100px'>".$c['mouse_invoiceno']."</td>";
				echo "<td width='100px'>".$c['mouse_brand']."</td>";
				echo "<td width='100px'>".$c['mouse_model']."</td>";
				echo "<td width='100px'>".$c['mouse_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>

