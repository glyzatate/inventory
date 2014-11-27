<?php 
$css = array('jquery-ui/jquery-ui.css');
require 'includes/header.php';
if(!is_login()){
	echo 'You are not signed in.<br/>
		<a href="login.php">Click here</a> to sign in.';
}else{
	echo '<p>Welcome <b>'.$user->getFullName().' </b>!</p>';		
	
	//print_r($user);
	
	$param = $_GET['itemName'];
	?>
<hr>
<h4>List of <?php echo $param;?></h4>	
	
	<table border="1" >
		<tr align="center">
			<th width='200px'>Last Name</th>
			<th width='200px'>First Name</th>	
		</tr>

		<?php 
			echo $_POST['itemName'];
			$fields = "*";
			$where = "item_name like '%".strtolower($param)."%'  ";
			$itemdetails = $db->selectQuery("physical_inventory",$fields,$where);

			foreach( $itemdetails AS $c ):
				echo '<tr >';				
					echo "<td width='100px'><a href='peritemdetails.php?id=".$c['inventory_number']."' >".$c['item_name']."</td>";				
					echo "<td width='100px'>".$c['label']."</td>";
					// echo "<td width='100px'>".$c['monitor_brand']."</td>";
					// echo "<td width='100px'>".$c['monitor_model']."</td>";
					// echo "<td width='100px'>".$c['monitor_serial']."</td>";
				echo '</tr>';		
				
			endforeach; 
		?>				
	</table>
	

	
	
<?php }  require "includes/footer.php"; ?>