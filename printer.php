<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';

if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	?>
	<!--<input type="submit" value="Add Printer" /> <br/><hr>-->
	<h1>Printer</h1><hr>
	<table border="1" width="750px">
		<tr align="center">
			<th width="25%">Invoice No.</th>
			<th width="25%">Printer Brand</th>
			<th width="25%">Printer Model</th>
			<th width="25%">Printer Serial</th>
		</tr>
	</table>	
	<div style="overflow:auto;height:600px;">
	<table border="1" width="750px">
		<?php 
			$mouse = $db->selectQuery("printer","*", "1");			
			foreach( $mouse AS $c ):
				echo '<tr >';
				// echo "<td> </td>";
				echo "<td width='25.2%'>".$c['printer_brand']."</td>";
				echo "<td>".$c['printer_brand']."</td>";
				echo "<td>".$c['printer_model']."</td>";
				echo "<td>".$c['printer_serial']."</td>";
				echo '</tr>';				
			endforeach;
		?>				
	</table>
	</div>


	
	
<?php }  require "includes/footer.php"; ?>


