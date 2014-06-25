<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	
	<input type="submit" value="Add Mouse" /> <br/><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width="25%">Invoice No.</th>
			<th width="25%">Mouse Brand</th>
			<th width="25%">Mouse Model</th>
			<th width="25%">Mouse Serial</th>
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$mouse = $db->selectQuery("mouse","*", "1");			
			foreach( $mouse AS $c ):
				echo '<tr >';
				// echo "<td> </td>";
				echo "<td width='25.2%'>".$c['mouse_brand']."</td>";
				echo "<td>".$c['mouse_brand']."</td>";
				echo "<td>".$c['mouse_model']."</td>";
				echo "<td>".$c['mouse_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>

